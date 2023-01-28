<?php

class wsm_lang {
    
    /* Erhalte das passende JSON für die Ausgabe der Sprache Frontend */

    public static function getLangAsArray() :array
    {
        $return = [];
        $return['consentModal'] = self::getConsentModal();
        $return['preferencesModal'] = self::getPreferencesModal();
        
        $sections = [];

        /* Intro */

        $sections[0]['title'] = wsm::getConfig('consent_modal_title');
        $sections[0]['description'] = wsm::getConfig('consent_modal_description');

        /* Gruppen, Drittanbieter und ihre Einträge */

        $groups =  wsm_group::query()->find();

        foreach ($groups as $group) {
            $g = [];
            $g["title"] = $group->getTitle();
            $g["description"] = $group->getDescription();
            $g["linkedCategory"] = $group->getName();

            $services = wsm_service::findServices($group->getId());

            foreach ($services as $service) {

                $entries = wsm_entry::findEntriesArray($service->getId());

                if (count($entries)) {
                    $g["cookie_table"]["headers"]['name'] = "Name";
                    $g["cookie_table"]["headers"]['description'] = "Description";
                    $g["cookie_table"]["headers"]['duration'] = "Duration";
                    $g["cookie_table"]["headers"]['type'] = "Type";
                    $g["cookie_table"]["body"] = $entries;
                }
            }
            $sections[] = $g;
        }

        /* Allgemeine Infos */

        $sections[] = ['title' => wsm::getConfig('settings_modal_block_more_title'), 'description' => wsm::getConfig('settings_modal_block_more_description') ."<a class=\"cc__link\" href=\"#yourdomain.com\">contact me</a>."];

        $return['preferencesModal']['sections'] = $sections;
        
        return $return;
    }
    public static function getLangAsJson() :string
    {
        return @json_encode(self::getLangAsArray(), JSON_PRETTY_PRINT);
    }

    private static function getConsentModal() {

        $consentModal = [];
        $consentModal["label"] = "Cookie Consent";
        $consentModal["title"] = wsm::getConfig('consent_modal_title');
        $consentModal["description"] = wsm::getConfig('consent_modal_description');
        $consentModal["acceptAllBtn"] = wsm::getConfig('consent_modal_primary_btn');
        $consentModal["closeIconLabel"] = wsm::getConfig('settings_modal_close_btn_label');
        $consentModal["acceptNecessaryBtn"] = wsm::getConfig('consent_modal_secondary_btn');
        $consentModal["showPreferencesBtn"] = "Manage preferences";
        $consentModal["footer"] = "<a href=\"#link\">Privacy Policy</a><a href=\"#link\">Terms and conditions</a>";

        return $consentModal;

    }
    private static function getPreferencesModal() {

        $preferencesModal = [];
        $preferencesModal["title"] = wsm::getConfig('settings_modal_title');
        $preferencesModal["acceptAllBtn"] = wsm::getConfig('settings_modal_accept_all_btn') ;
        $preferencesModal["acceptNecessaryBtn"] = wsm::getConfig('settings_modal_reject_all_btn');
        $preferencesModal["savePreferencesBtn"] = wsm::getConfig('settings_modal_save_settigns_btn');
        $preferencesModal["closeIconLabel"] = wsm::getConfig('settings_modal_close_btn');
        $preferencesModal["serviceCounterLabel"] = "Dienst|Dienste";

        return $preferencesModal;

    }

    private static function getIframe() {
        /*
        <?= wsm::getConfig('iframe_notice') ?>
        <?= wsm::getConfig('iframe_load_btn') ?>
        <?= wsm::getConfig('iframe_load_all_btn') ?>
        <?= wsm::getConfig('iframe_notice') ?>
        <?= wsm::getConfig('iframe_load_btn') ?>
        <?= wsm::getConfig('iframe_load_all_btn') ?>
        */
    }
}
