<?php

namespace Alexplusde\Wsm;

use rex;
use rex_config;
use rex_type;
use rex_extension_point;
use rex_formatter;
use rex_i18n;

class Wsm
{

    const TABLES = [
        'service' => 'rex_wenns_sein_muss_service',
        'group' => 'rex_wenns_sein_muss_group',
        'entry' => 'rex_wenns_sein_muss_entry',
        'iframe' => 'rex_wenns_sein_muss_iframe',
        'domain' => 'rex_wenns_sein_muss_domain'
    ];

    public static function getDomainId() :int
    {
        $domain_id = 0; // default

        if (\rex_addon::get('yrewrite')->isAvailable() && !rex::isSafeMode()) {
            $domain_id = \rex_yrewrite::getCurrentDomain()->getId() ?: 0;
        }
        return $domain_id;
    }
    
    /* Erhalte das passende JSON für die Ausgabe der Drittanbieter-Services im Frontend */

    private static function getServicesAsArray() :array
    {
        $sections = [];

        $groups =  Group::query()->find();

        foreach ($groups as $group) {
            /** @var Group $group */
            $services = Service::findServices($group->getId());

            if (count($services) === 0) {
                continue;
            }

            $g = [];
            $g["title"] = $group->getTitle();
            $g["description"] = $group->getDescription();
            $g["linked_category"] = $group->getName();


            foreach ($services as $service) {
                /** @var Service $service */
                $entries = Entry::findEntriesArray($service->getId());

                $g["cookieTable"]["headers"]['name'] = "Name";
                $g["cookieTable"]["headers"]['description'] = "Description";
                $g["cookieTable"]["headers"]['duration'] = "Duration";
                $g["cookieTable"]["headers"]['type'] = "Type";
                $g["cookieTable"]["body"] = $entries;
            }
            $sections[] = $g;
        }
        
        return $sections;
    }

    /** @api */
    public static function getServicesAsJson() :string|false
    {
        return json_encode(self::getServicesAsArray(), JSON_PRETTY_PRINT);
    }

    /** @api */
    public static function getIframeServicesAsArray() :array
    {
        $return = [];

        $services =  Service::query()->where("iframe", "0", ">")->where("status", "1")->find();

        foreach ($services as $service) {
            /** @var Service $service */
            $iframe = $service->getRelatedDataset('iframe');
            /** @var Iframe $iframe */

            $s = [];
            $s['embedUrl'] = $iframe->getValue('embedUrl');
            $s['thumbnail'] = urldecode(rex_getUrl(null, null, array('rex-api-call' => "wsm_iframe", 'service' => \rex_string::normalize($service->getValue('service')), 'id' => "{data_id}"), "&"));
//          $s['iframe'] = $iframe->getValue('attributes');
            $s['languages'][\rex_clang::getCurrent()->getCode()]['notice'] = \rex_formatter::sprintf($service->getCompanyName(), Wsm::getConfigText('iframe_notice')) .' <a rel="noreferrer noopener" href="'.$service->getValue('privacy_policy_url').'" target="_blank">'.Wsm::getConfigText('iframe_notice_more').'</a>';
            $s['languages'][\rex_clang::getCurrent()->getCode()]['loadBtn'] = Wsm::getConfigText('iframe_load_btn');
            $s['languages'][\rex_clang::getCurrent()->getCode()]['loadAllBtn'] = Wsm::getConfigText('iframe_load_all_btn');
            
            $return[\rex_string::normalize($service->getService())] = $s;
        }
        return $return;
    }
    

    public static function getIframeServicesAsJson() :string
    {
        $code = (string)@json_encode(self::getIframeServicesAsArray(), JSON_PRETTY_PRINT);
        return str_replace(['"<BEGIN_JS>', '<END_JS>"'], ["", ""], $code);
    }

    /* Auswahl-Liste an Gruppen und deren Services */

    private static function getCategoriesAsArray() :array
    {
        $categories = [];

        $groups =  Group::query()->find();

        foreach ($groups as $group) {
            /** @var Group $group */
            $g = [];
            $g["readOnly"] = (bool)$group->getRequired();
            $g["enabled"] = (bool)$group->getEnabled();

            $services = Service::findServices($group->getId());

            foreach ($services as $service) {
                /** @var Service $service */
                if(!($service->getIframe() instanceof Iframe)) {
                    continue;
                }
                $s = [];
                $s['label'] = $service->getService();
                /* <BEGIN JS> <END_JS> wird ersetzt, um aus dem zurückgegebenen String eine Funktion in JS zu machen */
                $s['onAccept'] = "<BEGIN_JS> () => wsm_im.acceptService('".\rex_string::normalize($service->getService())."') <END_JS>";
                $s['onReject'] = "<BEGIN_JS> () => wsm_im.rejectService('".\rex_string::normalize($service->getService())."') <END_JS>";

                $g['services'][\rex_string::normalize($service->getService())] = $s;
            }
            $categories[\rex_string::normalize($group->getName())] = $g;
        }

        return $categories;
    }

    public static function getCategoriesAsJson() :string
    {
        $code = strval(@json_encode(self::getCategoriesAsArray(), JSON_PRETTY_PRINT|JSON_FORCE_OBJECT));
        return str_replace(['"<BEGIN_JS>', '<END_JS>"'], ["", ""], $code);
    }

    /* Erhöhe mit jeder Änderung an Drittanbieter-Einstellungen die Revisionsnummer, um die Einwilligung erneut einzuholen */

    public static function getRevisionNumber() :int
    {
        return strtotime(self::getConfig('revision'));
    }

    /**
     * @api
     * @return string 
     */
    public static function getRevisionTimestamp() :string
    {
        return self::getConfig('revision');
    }

    public static function getLastChangeTimestamp() :string
    {
        return self::getConfig('lastchange');
    }

    public static function newRevision() :void
    {
        self::setConfig('revision', date("Y-m-d H:i:s"));
    }

    public static function newChange() :void
    {
        self::setConfig('lastchange', date("Y-m-d H:i:s"));
    }

    /**
     * @api
     */
    public static function yformDataChanged(\rex_extension_point $ep) :void
    {
        $table = $ep->getParam('table');
        $table_name = $table->getTableName();
        /* @var \rex_yform_manager_table $table */
        if (in_array($table_name, self::TABLES)) {
            self::newChange();
            /* Link to Backend Page to update the revision: page=wenns_sein_muss/revision */
            echo \rex_view::success(\rex_i18n::rawMsg("wsm_success_yform_data_changed", \rex_url::currentBackendPage(['page' => 'wenns_sein_muss/revision'])));
        }
        return;
    }

    /* Shortcut für eigene Konfigurationswerte */
    
    public static function getConfig(string $key, string $vartype = "string", mixed $default = "") :mixed
    {
        if (\rex_config::has("wenns_sein_muss", $key)) {
            return rex_type::cast(rex_config::get("wenns_sein_muss", $key), $vartype);
        }

        if ('' === $default) {
            return rex_type::cast($default, $vartype);
        }
        return $default;
    }
    public static function setConfig(string $key, mixed $value) :bool
    {
        return \rex_config::set("wenns_sein_muss", $key, $value);
    }

    /* Sprog */

    public static function getConfigText(string $key, string $lang_code = "de") :string
    {
        $clang_id = 1;
        
        if(rex_get('lang', 'string', "") !== "") {
            $lang_code = rex_get('lang');
        }
        $rex_clangs = \rex_clang::getAll();
        foreach($rex_clangs as $rex_clang) {
            /* @var \rex_clang $rex_clang */
            if($rex_clang->getCode() === $lang_code) {
                $clang_id = $rex_clang->getId();
                break;
            }
        }

        $text = self::getConfig($key, 'string');
        if (\rex_addon::get('sprog')->isAvailable() && !\rex::isSafeMode()) {
            if (false !== sprogcard($key, $clang_id)) {
                $text = sprogcard($key, $clang_id);
            }
        }

        if ($text === null) {
            return "missing text for key <code>". $key . "</code>";
        }

        return $text;
    }
}
