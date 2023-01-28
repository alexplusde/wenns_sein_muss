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
                $g["cookie_table"]["body"][] = wsm_entry::findEntriesArray($service->getId());

                $g["cookie_table"]["headers"]['name'] = "Name";
                $g["cookie_table"]["headers"]['description'] = "Description";
                $g["cookie_table"]["headers"]['duration'] = "Duration";
                $g["cookie_table"]["headers"]['type'] = "Type";
            }
            $return[] = $g;
        }
        
        $return[] = ["title" => wsm::getConfig('settings_modal_block_more_title'), "description" => wsm::getConfig('settings_modal_block_more_description')];

        return $return;
    }

    public static function getServicesAsJson() :string
    {
        return @json_encode(self::getServicesAsArray());
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
