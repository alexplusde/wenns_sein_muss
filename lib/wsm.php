<?php
class wsm extends \rex_yform_manager_dataset
{
    # https://github.com/yakamara/redaxo_yform/blob/master/docs/04_yorm.md#yorm-mit-eigener-model-class-verwenden

    public function getService() :string
    {
        return $this->getValue('service');
    }
    public static function getConfig(string $key) :mixed
    {
        return rex_config::get("wenns_sein_muss", $key);
    }
    public static function setConfig(string $key, mixed $value) :bool
    {
        return rex_config::set("wenns_sein_muss", $key, $value);
    }
    public static function getIframe($data_service, $data_id = "", $data_params = "", $data_thumbnail = null)
    {
        $fragment = new rex_fragment();
        $fragment->setVar("data-service", $data_service);
        $fragment->setVar("data-id", $data_id);
        $fragment->setVar("data-params", $data_params);
        $fragment->setVar("data-thumbnail", $data_thumbnail);
        return $fragment->parse('wsm.iframe.php');
    }
    
    public static function getServices() :array
    {
        $return = [];
        $groups = [];
        $groups =  wsm_group::query()->find();

        foreach ($groups as $group) {
            $g = [];
            $g["title"] = $group->getTitle();
            $g["description"] = $group->getDescription();
            $g["toggle"]['value'] = $group->getName();
            $g["toggle"]['enabled'] = $group->getEnabled();
            $g["toggle"]['readonly'] = $group->getRequired();

            $services = [];

            $domain_id = 0; // default
            if (rex_addon::get('yrewrite')->isAvailable() && !rex::isSafeMode()) {
                $domain_id = rex_yrewrite::getCurrentDomain()->getId();
            }
            $group_id = $group->getId();
            $services = wsm::query()->whereRaw('(`group` = '.$group_id.' AND (FIND_IN_SET(`rex_domain`, 0) OR FIND_IN_SET(`rex_domain`, '.$domain_id.')))')->find();

            
            foreach ($services as $service) {
                $entries = [];
                $entries = wsm_entry::query()->where("f_id", $service->getId())->find();
                $s = [];
                foreach ($entries as $entry) {
                    $s["col1"] = $service->getService();
                    $s["col2"] = $entry->getDescription();
                    $s["col3"] = $entry->getDuration();
                    $s["col4"] = $entry->getType();
                    $g["cookie_table"][] = $s;
                }
            }
            $return[] = $g;
        }
        

        $return[] = ["title" => wsm::getConfig('settings_modal_block_more_title'), "description" => wsm::getConfig('settings_modal_block_more_description')];

        return $return;
    }

    public static function getServicesAsJson() :string
    {
        return json_encode(self::getServices(), 1);
    }
    public static function getServicesAsRevisionHash() :string
    {
        return md5(self::getServicesAsJson());
    }
}
