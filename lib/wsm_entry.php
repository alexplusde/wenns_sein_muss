<?php
class wsm_entry extends \rex_yform_manager_dataset
{
    public function getName() :string
    {
        return $this->getValue('name');
    }
    public function getDescription() :string
    {
        return $this->getValue('description');
    }
    public function getDuration() :string
    {
        return $this->getValue('duration');
    }
    public function getType() :string
    {
        return $this->getValue('type');
    }

    public static function findEntriesArray($service_id) {

        $entries = wsm_entry::query()->where("service_id", $service_id)->find();
        $return = [];
        foreach ($entries as $entry) {
            $return["name"] = $entry->getName();
            $return["description"] = $entry->getDescription();
            $return["duration"] = $entry->getDuration();
            $return["type"] = $entry->getType();
        }
        return $return;
    }

}
