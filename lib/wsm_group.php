<?php
class wsm_group extends \rex_yform_manager_dataset
{
    # https://github.com/yakamara/redaxo_yform/blob/master/docs/04_yorm.md#yorm-mit-eigener-model-class-verwenden

    public function getName() :string
    {
        return (string)$this->getValue('name');
    }

    public function getTitle() :string
    {
        return (string)$this->getValue('title');
    }

    public function getDescription() :string
    {
        return (string)$this->getValue('description');
    }

    public function getEnabled() :int
    {
        return (int)$this->getValue('enabled');
    }

    public function getRequired() :int
    {
        return (int)$this->getValue('required');
    }


    public static function getServices() :array
    {
        $return = [];
        $groups = [];
        $groups =  self::query()->find();

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
            
            $services = wsm::query()->where("group", $group->getId())->where('domain', $domain_id)->find();

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
