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

        
        $domain = wsm_domain::getCurrent();

        if ($domain) {
            $privacy_policy = $domain->getPrivacyPolicyArticle();
            $imprint = $domain->getImprintArticle();
        } else {
            $privacy_policy = rex_article::get(wsm::getConfigText("wsm_domain_imprint_id"));
            $imprint = rex_article::get(wsm::getConfigText("wsm_domain_privacy_policy_id"));
        }

        $sections[] = ['title' => wsm::getConfigText('consent_info_domain'), 'description' => '
        <p>'.wsm::getConfigText('consent_info_uuid').': <span id="consent-id">'.wsm::getConfigText('consent_info_unknown').'</span></p>
        <p>'.wsm::getConfigText('consent_info_datestamp').': <span id="consent-timestamp"></span></p>
        <p>'.wsm::getConfigText('consent_info_update_datestamp').': <span id="last-consent-timestamp"></span></p>
        <p>'.wsm::getConfigText('consent_info_more').': <a href="'.$privacy_policy->getUrl().'">'.$privacy_policy->getName().'</a>
            <a href="'.$imprint->getUrl().'">'.$imprint->getName().'</a></p>'];

        $return['preferencesModal']['sections'] = $sections;
        
        return $return;
    }
    public static function getLangAsJson() :string
    {
        return @json_encode(self::getLangAsArray(), JSON_PRETTY_PRINT);
    }

    /**
     * @throws rex_exception
     */
    private static function getConsentModal()
    {
        $consentModal = [];
        $consentModal["label"] = wsm::getConfigText('consent_modal_lable');
        $consentModal["title"] = wsm::getConfigText('consent_modal_title');
        $consentModal["description"] = wsm::getConfigText('consent_modal_description');
        $consentModal["acceptAllBtn"] = wsm::getConfigText('consent_modal_accept_all');
        $consentModal["closeIconLabel"] = wsm::getConfigText('consent_modal_close');
        $consentModal["acceptNecessaryBtn"] = wsm::getConfigText('consent_modal_accept_necessary');
        $consentModal["showPreferencesBtn"] = wsm::getConfigText('consent_modal_settings');

        $domain = wsm_domain::getCurrent();

        if ($domain) {
            $privacy_policy = $domain->getPrivacyPolicyArticle();
            $imprint = $domain->getImprintArticle();
        } else {
            $privacy_policy = rex_article::get(wsm::getConfig("wsm_domain_privacy_policy_id"));
            $imprint = rex_article::get(wsm::getConfig("wsm_domain_imprint_id"));
        }
        
        if (!$privacy_policy) {
            throw new rex_exception('Privacy Policy Article not found');
        }

        if (!$imprint) {
            throw new rex_exception('Imprint Article not found');
        }

        $consentModal["footer"] = '<a href="'.$privacy_policy->getUrl().'">'.$privacy_policy->getName().'</a>
            <a href="'.$imprint->getUrl().'">'.$imprint->getName().'</a>';

        return $consentModal;
    }
    private static function getPreferencesModal()
    {
        $preferencesModal = [];
        $preferencesModal["title"] = wsm::getConfigText('consent_settings_title');
        $preferencesModal["acceptAllBtn"] = wsm::getConfigText('consent_settings_accept_all') ;
        $preferencesModal["acceptNecessaryBtn"] = wsm::getConfigText('consent_settings_reject_all');
        $preferencesModal["savePreferencesBtn"] = wsm::getConfigText('consent_settings_save');
        $preferencesModal["closeIconLabel"] = wsm::getConfigText('consent_settings_close');
        $preferencesModal["serviceCounterLabel"] = wsm::getConfigText('consent_settings_service_counter_badge');

        return $preferencesModal;
    }
}
