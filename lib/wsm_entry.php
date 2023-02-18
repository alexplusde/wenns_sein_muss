<?php
class wsm_entry extends \rex_yform_manager_dataset
{
    public function getType() :string
    {
        return $this->getValue('type');
    }
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

    public static function findEntriesArray(int $service_id)
    {
        $service = wsm_service::get($service_id);
        $entries = wsm_entry::query()->where("service_id", $service_id)->find();
        $return = [];
        foreach ($entries as $entry) {
            $e = [];
            $e["name"] = $entry->getName();
            $e["service"] = $service->getName();
            $e["description"] = $entry->getDescription();
            $e["duration"] = $entry->getDuration();
            $e["type"] = $entry->getType();

            $return[] = $e;
        }
        return $return;
    }
}
