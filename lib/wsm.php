<?php
class wsm
{
    public static function getDomainId()
    {
        $domain_id = 0; // default

        if (rex_addon::get('yrewrite')->isAvailable() && !rex::isSafeMode()) {
            $domain_id = rex_yrewrite::getCurrentDomain()->getId();
        }
        return $domain_id;
    }
    
    /* Erhalte das passende JSON für die Ausgabe der Drittanbieter-Services im Frontend */

    public static function getServicesAsArray() :array
    {
        $return = [];

        $groups =  wsm_group::query()->find();

        foreach ($groups as $group) {
            $services = wsm_service::findServices($group->getId());

            if (count($services) == 0) {
                continue;
            }

            $g = [];
            $g["title"] = $group->getTitle();
            $g["description"] = $group->getDescription();
            $g["linked_category"] = $group->getName();


            foreach ($services as $service) {
                $entries = wsm_entry::findEntriesArray($service->getId());

                $g["cookieTable"]["headers"]['name'] = "Name";
                $g["cookieTable"]["headers"]['description'] = "Description";
                $g["cookieTable"]["headers"]['duration'] = "Duration";
                $g["cookieTable"]["headers"]['type'] = "Type";
                $g["cookieTable"]["body"] = $entries;
            }
            $sections[] = $g;
        }

        
        $sections[] = ['title' => wsm::getConfigText('consent_settings_block_more_title'), 'description' => wsm::getConfigText('consent_settings_block_more_description') ."<a class=\"cc__link\" href=\"#yourdomain.com\">contact me</a>."];

        return $return;
    }

    public static function getServicesAsJson() :string
    {
        return @json_encode(self::getServicesAsArray());
    }

    public static function getIframeServicesAsArray() :array
    {
        $return = [];

        $services =  wsm_service::query()->where("iframe", "0", ">")->find();

        foreach ($services as $service) {
            $iframe = $service->getRelatedDataset('iframe');
           
            $s['embedUrl'] = $iframe->getValue('embedUrl');
            $s['thumbnail'] = urldecode(rex_getUrl(null, null, array('rex-api-call' => "wsm_iframe", 'service' => rex_string::normalize($service->getValue('service')), 'id' => "{data_id}"), "&"));
//          $s['iframe'] = $iframe->getValue('attributes');
            $s['languages'][rex_clang::getCurrent()->getCode()]['notice'] = rex_formatter::sprintf($service->getCompanyName(), wsm::getConfigText('iframe_notice')) .' <a rel="noreferrer noopener" href="'.$service->getValue('privacy_policy_url').'" target="_blank">'.wsm::getConfigText('iframe_notice_more').'</a>';
            $s['languages'][rex_clang::getCurrent()->getCode()]['loadBtn'] = wsm::getConfigText('iframe_load_btn');
            $s['languages'][rex_clang::getCurrent()->getCode()]['loadAllBtn'] = wsm::getConfigText('iframe_load_all_btn');
            
            $return[rex_string::normalize($service->getValue('service'))] = $s;
        }
        return $return;
    }
    

    public static function getIframeServicesAsJson() :string
    {
        $code = @json_encode(self::getIframeServicesAsArray());
        return str_replace(['"<BEGIN_JS>', '<END_JS>"'], "", $code);
    }

    /* Auswahl-Liste an Gruppen und deren Services */

    public static function getCategoriesAsArray() :array
    {
        $categories = [];

        $groups =  wsm_group::query()->find();

        foreach ($groups as $group) {
            $g = [];
            $g["readOnly"] = (bool)$group->getRequired();
            $g["enabled"] = (bool)$group->getEnabled();

            $services = wsm_service::findServices($group->getId());

            foreach ($services as $service) {
                $s = [];
                $s['label'] = $service->getService();
                /* <BEGIN JS> <END_JS> wird ersetzt, um aus dem zurückgegebenen String eine Funktion in JS zu machen */
                $s['onAccept'] = "<BEGIN_JS> () => wsm_im.acceptService('".rex_string::normalize($service->getService())."') <END_JS>";
                $s['onReject'] = "<BEGIN_JS> () => wsm_im.rejectService('".rex_string::normalize($service->getService())."') <END_JS>";

                $g['services'][rex_string::normalize($service->getService())] = $s;
            }
            $categories[rex_string::normalize($group->getName())] = $g;
        }

        return $categories;
    }

    public static function getCategoriesAsJson() :string
    {
        $code = @json_encode(self::getCategoriesAsArray(), JSON_PRETTY_PRINT, JSON_FORCE_OBJECT);
        return str_replace(['"<BEGIN_JS>', '<END_JS>"'], "", $code);
    }

    /* Erhöhe mit jeder Änderung an Drittanbieter-Einstellungen die Revisionsnummer, um die Einwilligung erneut einzuholen */

    public static function getRevisionNumber()
    {
        return self::getConfig('revision');
    }

    public static function getRevisionTimestamp() :string
    {
        return self::getConfig('revision_timestamp') ?? "";
    }

    public static function yform_data_added(rex_extension_point $ep)
    {
        $subject = $ep->getSubject();

        if ($subject && $subject->objparams['main_table'] == "rex_wenns_sein_muss" || $subject->objparams['main_table'] == "rex_wenns_sein_muss_entry" || $subject->objparams()['table'] == "rex_wenns_sein_muss_group") {
            wsm::setConfig('revision', wsm::getConfig('revision')+1);
            wsm::setConfig('revision_timestamp', date("Y-m-d H:i:s"));
        }
        return;
    }
    public static function yform_data_deleted(rex_extension_point $ep)
    {
        if ($ep->getParams()['table'] == "rex_wenns_sein_muss" || $ep->getParams()['table'] == "rex_wenns_sein_muss_entry" || $ep->getParams()['table'] == "rex_wenns_sein_muss_group") {
            wsm::setConfig('revision', wsm::getConfig('revision')+1);
            wsm::setConfig('revision_timestamp', date("Y-m-d H:i:s"));
        }
        return;
    }

    /* Shortcut für eigene Konfigurationswerte */
    
    public static function getConfig(string $key) :mixed
    {
        return rex_config::get("wenns_sein_muss", $key);
    }
    public static function setConfig(string $key, mixed $value) :bool
    {
        return rex_config::set("wenns_sein_muss", $key, $value);
    }

    /* Sprog */

    public static function getConfigText(string $key) :string
    {
        $text = wsm::getConfig($key);
/*
        if (rex_addon::get('sprog')->isAvailable() && !rex::isSafeMode()) {
            if ($key != sprogdown($key)) {
                $text = sprogdown($key);
            }
        }
  */              
        if ($text === null) {
            return "missing text for key <code>". $key . "</code>";
        }

        return $text;
    }
}
