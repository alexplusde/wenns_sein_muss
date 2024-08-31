<?php

namespace Alexplusde\Wsm;

class Lang
{
    /* Erhalte das passende JSON für die Ausgabe der Sprache Frontend */

    private static function getLangAsArray() :array
    {
        $return = [];
        $return['consentModal'] = self::getConsentModal();
        $return['preferencesModal'] = self::getPreferencesModal();
        
        $sections = [];

        /* Intro */

        $sections[0]['description'] = Wsm::getConfigText('consent_modal_description');

        /* Gruppen, Drittanbieter und ihre Einträge */

        $groups =  Group::query()->find();

        foreach ($groups as $group) {
            /** @var Group $group */
            $g = [];
            $g["title"] = $group->getTitle();
            $g["description"] = $group->getDescription();
            $g["linkedCategory"] = $group->getName();

            $services = Service::findServices($group->getId());
            
            foreach ($services as $service) {
                /** @var Service $service */
                $entries = Entry::findEntriesArray($service->getId());

                if (count($entries) > 0) {
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

        
        $domain = Domain::getCurrent();

        if ($domain instanceof Domain) {
            $privacy_policy = $domain->getPrivacyPolicyArticle();
            $imprint = $domain->getImprintArticle();
        } else {
            $privacy_policy = \rex_article::get(Wsm::getConfig("wsm_domain_imprint_id", 'int', 0));
            $imprint = \rex_article::get(Wsm::getConfig("wsm_domain_privacy_policy_id", 'int', 0));
        }

        if($privacy_policy instanceof \rex_article && $imprint instanceof \rex_article) {
            $sections = [];
            $sections[] = ['title' => Wsm::getConfigText('consent_info_domain'), 'description' => '
            <p>'.Wsm::getConfigText('consent_info_uuid').': <span id="consent-id">'.Wsm::getConfigText('consent_info_unknown').'</span></p>
            <p>'.Wsm::getConfigText('consent_info_datestamp').': <span id="consent-timestamp"></span></p>
            <p>'.Wsm::getConfigText('consent_info_update_datestamp').': <span id="last-consent-timestamp"></span></p>
            <p>'.Wsm::getConfigText('consent_info_more').': <a href="'.$privacy_policy->getUrl().'">'.$privacy_policy->getName().'</a>
                <a href="'.$imprint->getUrl().'">'.$imprint->getName().'</a></p>'];
        }

        $return['preferencesModal']['sections'] = $sections;
        
        return $return;
    }
    public static function getLangAsJson() :string|false
    {
        return @json_encode(self::getLangAsArray(), JSON_PRETTY_PRINT);
    }

    private static function getConsentModal() :array
    {
        $consentModal = [];
        $consentModal["label"] = Wsm::getConfigText('consent_modal_lable');
        $consentModal["title"] = Wsm::getConfigText('consent_modal_title');
        $consentModal["description"] = Wsm::getConfigText('consent_modal_description');
        $consentModal["acceptAllBtn"] = Wsm::getConfigText('consent_modal_accept_all');
        $consentModal["closeIconLabel"] = Wsm::getConfigText('consent_modal_close');
        $consentModal["acceptNecessaryBtn"] = Wsm::getConfigText('consent_modal_accept_necessary');
        $consentModal["showPreferencesBtn"] = Wsm::getConfigText('consent_modal_settings');

        $domain = Domain::getCurrent();

        if ($domain instanceof Domain) {
            $privacy_policy = $domain->getPrivacyPolicyArticle();
            $imprint = $domain->getImprintArticle();
        } else {
            $privacy_policy = \rex_article::get(Wsm::getConfig("wsm_domain_privacy_policy_id", 'int', 0));
            
            $imprint = \rex_article::get(Wsm::getConfig("wsm_domain_imprint_id", 'int', 0));
        }
        if($privacy_policy instanceof \rex_article && $imprint instanceof \rex_article) {
            $consentModal["footer"] = '<a href="'.$privacy_policy->getUrl().'">'.$privacy_policy->getName().'</a>
            <a href="'.$imprint->getUrl().'">'.$imprint->getName().'</a>';
        }

        return $consentModal;
    }
    private static function getPreferencesModal() :array
    {
        $preferencesModal = [];
        $preferencesModal["title"] = Wsm::getConfigText('consent_settings_title');
        $preferencesModal["acceptAllBtn"] = Wsm::getConfigText('consent_settings_accept_all') ;
        $preferencesModal["acceptNecessaryBtn"] = Wsm::getConfigText('consent_settings_reject_all');
        $preferencesModal["savePreferencesBtn"] = Wsm::getConfigText('consent_settings_save');
        $preferencesModal["closeIconLabel"] = Wsm::getConfigText('consent_settings_close');
        $preferencesModal["serviceCounterLabel"] = Wsm::getConfigText('consent_settings_service_counter_badge');

        return $preferencesModal;
    }
}
