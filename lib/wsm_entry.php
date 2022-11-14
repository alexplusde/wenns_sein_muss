<?php
class wsm_entry extends \rex_yform_manager_dataset
{
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
}
