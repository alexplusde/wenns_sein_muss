<?php
class wsm_group extends \rex_yform_manager_dataset
{
    # https://github.com/yakamara/redaxo_yform/blob/master/docs/04_yorm.md#yorm-mit-eigener-model-class-verwenden

    public function getName() :string
    {
        return $this->getValue('name');
    }

    public static function getServices() 
    {
        $groups = [];
        $groups =  self::query()->find();

        $return = [];

        foreach ($groups as $group) {
            $g["title"] = $group->title;
            $g["description"] = $group->description;
            $g["toggle"]['value'] = $group->name;
            $g["toggle"]['enabled'] = $group->enabled;
            $g["toggle"]['readonly'] = $group->required;

            $services = [];
            $services = wsm::query()->where("group", $group->id)->find();

            foreach ($services as $service) {
                $entries = [];
                $entries = wsm_entry::query()->where("name", $service->id)->find();
                $s = [];
                foreach ($entries as $entry) {
                    $s["col1"] = $service->service;
                    $s["col2"] = $entry->description;
                    $s["col3"] = $entry->duration;
                    $s["col4"] = $entry->type;
                    $g["cookie_table"][] = $s;
                }
            }
            $return[] = $g;
        }
        

    $return[] = ["title" => wsm::getConfig('settings_modal_block_more_title'), "description" => wsm::getConfig('settings_modal_block_more_description')];

    return $return;


    }
    public static function getServicesAsJson() {

        return json_encode(self::getServices(), true);

    }
    public static function getServicesAsRevisionHash() {

        return md5(self::getServicesAsJson());

    }
}
