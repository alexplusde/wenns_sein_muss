<?php

class wsm_lang
{
    /* Erhalte das passende JSON für die Ausgabe der Sprache Frontend */

    public static function getLangAsArray() :array
    {
        $return = [];
        $return['consentModal'] = self::getConsentModal();
        $return['preferencesModal'] = self::getPreferencesModal();
        
        $sections = [];

        /* Intro */

        $sections[0]['title'] = wsm::getConfigText('consent_modal_title');
        $sections[0]['description'] = wsm::getConfigText('consent_modal_description');

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
                    $g["cookieTable"]["headers"]['name'] = "Name";
                    $g["cookieTable"]["headers"]['service'] = "Service";
                    $g["cookieTable"]["headers"]['description'] = "Description";
                    $g["cookieTable"]["headers"]['duration'] = "Duration";
                    $g["cookieTable"]["headers"]['type'] = "Type";
                    $g["cookieTable"]["body"] = $entries;
                }
            }
            $sections[] = $g;
        }

        /* Einwilligungs-Protokoll darstellen */
        $sections[] = ['title' => wsm::getConfigText('consent_settings_block_consent_title'), 'description' => '<p>consent id: <span id="consent-id">-</span></p><p>consent date: <span id="consent-timestamp">-</span></p><p>last update: <span id="last-consent-timestamp">-</span></p>'];

        /* Allgemeine Infos */
        $sections[] = ['title' => wsm::getConfigText('consent_settings_block_more_title'), 'description' => wsm::getConfigText('consent_settings_block_more_description') ."<a class=\"cc__link\" href=\"#yourdomain.com\">contact me</a>."];

        $return['preferencesModal']['sections'] = $sections;
        
        return $return;
    }
    public static function getLangAsJson() :string
    {
        return @json_encode(self::getLangAsArray(), JSON_PRETTY_PRINT);
    }

    private static function getConsentModal()
    {
        $consentModal = [];
        $consentModal["label"] = wsm::getConfigText('consent_modal_lable');
        $consentModal["title"] = wsm::getConfigText('consent_modal_title');
        $consentModal["description"] = wsm::getConfigText('consent_modal_description');
        $consentModal["acceptAllBtn"] = wsm::getConfigText('consent_modal_accept_all');
        $consentModal["closeIconLabel"] = wsm::getConfigText('consent_modal_close_btn_label');
        $consentModal["acceptNecessaryBtn"] = wsm::getConfigText('consent_modal_accept_necessary');
        $consentModal["showPreferencesBtn"] = wsm::getConfigText('consent_modal_settings');
        $consentModal["footer"] = "<a href=\"#link\">Privacy Policy</a><a href=\"#link\">Terms and conditions</a>";

        return $consentModal;
    }
    private static function getPreferencesModal()
    {
        $preferencesModal = [];
        $preferencesModal["title"] = wsm::getConfigText('consent_settings_title');
        $preferencesModal["acceptAllBtn"] = wsm::getConfigText('consent_settings_accept_all_btn') ;
        $preferencesModal["acceptNecessaryBtn"] = wsm::getConfigText('consent_settings_reject_all_btn');
        $preferencesModal["savePreferencesBtn"] = wsm::getConfigText('consent_settings_save_settigns_btn');
        $preferencesModal["closeIconLabel"] = wsm::getConfigText('consent_settings_close_btn');
        $preferencesModal["serviceCounterLabel"] = wsm::getConfigText('consent_settings_service_counter_label');

        return $preferencesModal;
    }
}
