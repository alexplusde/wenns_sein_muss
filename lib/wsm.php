<?php
class wsm extends \rex_yform_manager_dataset
{
    # https://github.com/yakamara/redaxo_yform/blob/master/docs/04_yorm.md#yorm-mit-eigener-model-class-verwenden

    public function getName() :string
    {
        return $this->getValue('name');
    }
    public function getService() :string
    {
        return $this->getValue('service');
    }
    public static function getConfig($key)
    {
        return rex_config::get("wenns_sein_muss", $key);
    }
    public static function setConfig($key, $value)
    {
        return rex_config::set("wenns_sein_muss", $key, $value);
    }
}
