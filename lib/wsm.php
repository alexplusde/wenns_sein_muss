<?php
class wsm
{
    public static function getDomainId() {

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
            $g = [];
            $g["title"] = $group->getTitle();
            $g["description"] = $group->getDescription();
            $g["linked_category"] = $group->getName();

            $services = wsm_service::findServices($group->getId());

            foreach ($services as $service) {

                $entries = wsm_entry::findEntriesArray($service->getId());

                    $g["cookie_table"]["headers"]['name'] = "Name";
                    $g["cookie_table"]["headers"]['description'] = "Description";
                    $g["cookie_table"]["headers"]['duration'] = "Duration";
                    $g["cookie_table"]["headers"]['type'] = "Type";
                    $g["cookie_table"]["body"] = $entries;

            }
            $sections[] = $g;
        }

        
        $sections[] = ['title' => wsm::getConfig('settings_modal_block_more_title'), 'description' => wsm::getConfig('settings_modal_block_more_description') ."<a class=\"cc__link\" href=\"#yourdomain.com\">contact me</a>."];

        return $return;
    }
    

    public static function getServicesAsJson() :string
    {
        return @json_encode(self::getServicesAsArray());
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

    public static function getRevisionNumber() :int
    {
        return self::getConfig('revision');
    }

    public static function yform_data_added($ep)
    {
        $subject = $ep->getSubject();

        if ($subject->objparams['main_table'] == "rex_wenns_sein_muss" || $subject->objparams['main_table'] == "rex_wenns_sein_muss_entry" || $subject->objparams()['table'] == "rex_wenns_sein_muss_group") {
            wsm::setConfig('revision', wsm::getConfig('revision')+1);
        }
        return;
    }
    public static function yform_data_deleted($ep)
    {
        if ($ep->getParams()['table'] == "rex_wenns_sein_muss" || $ep->getParams()['table'] == "rex_wenns_sein_muss_entry" || $ep->getParams()['table'] == "rex_wenns_sein_muss_group") {
            wsm::setConfig('revision', wsm::getConfig('revision')+1);
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
}
