<?php
class wsm_entry extends \rex_yform_manager_dataset
{
    # https://github.com/yakamara/redaxo_yform/blob/master/docs/04_yorm.md#yorm-mit-eigener-model-class-verwenden


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
