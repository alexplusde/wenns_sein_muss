<?php

class wsm_lang {
    
    /* Erhalte das passende JSON für die Ausgabe der Sprache Frontend */

    public static function getLangAsArray() :array
    {
        $return = [];
        $return['consentModal'] = self::getConsentModal();
        $return['preferencesModal'] = self::getPreferencesModal();
        
        $services = [];

        $services[0]['title'] = "Somebody said ... cookies?";
        $services[0]['description'] = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua";

        $services[1]['title'] = "Strictly necessary cookies <span class=\"pm__badge\">Always enabled</span>";
        $services[1]['description'] = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.";
        $services[1]['linkedCategory'] = "necessary";

        $services[2]['title'] = "Analytics cookies";
        $services[2]['description'] = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.";
        $services[2]['linkedCategory'] = "analytics";
        $services[2]['cookieTable']['headers']['name'] = wsm::getConfig('settings_modal_cookie_table_headers_col1');
        $services[2]['cookieTable']['headers']['service'] = wsm::getConfig('settings_modal_cookie_table_headers_col2');
        $services[2]['cookieTable']['headers']['description'] = wsm::getConfig('settings_modal_cookie_table_headers_col3');
        $services[2]['cookieTable']['headers']['more'] = wsm::getConfig('settings_modal_cookie_table_headers_col4');

        $services[2]['cookieTable']['body'][0]['name'] = "im_youtube";
        $services[2]['cookieTable']['body'][0]['description'] = "Used to remember if the user accepted the youtube service.";
        $services[2]['cookieTable']['body'][0]['Service'] = "Youtube Embed";

        $services[2]['cookieTable']['body'][1]['name'] = "im_vimeo";
        $services[2]['cookieTable']['body'][1]['description'] = "Used to remember if the user accepted the vimeo service.";
        $services[2]['cookieTable']['body'][1]['Service'] = "Vimeo Embed";

        $services[3]['title'] = "Advertisement cookies";
        $services[3]['description'] = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.";
        $services[3]['linkedCategory'] = "ads";

        $services[4]['title'] = wsm::getConfig('settings_modal_block_more_title');
        $services[4]['description'] = wsm::getConfig('settings_modal_block_more_description') ."<a class=\"cc__link\" href=\"#yourdomain.com\">contact me</a>.";

        $return['preferencesModal']['services'] = $services;
        
        return $return;
    }
    public static function getLangAsJson() :string
    {
        return @json_encode(self::getLangAsArray());
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
        $preferencesModal["serviceCounterLabel"] = "Service|Services";

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
