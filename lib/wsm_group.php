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
}
