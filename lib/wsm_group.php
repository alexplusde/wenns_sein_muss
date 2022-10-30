<?php
class wsm_group extends \rex_yform_manager_dataset
{
    # https://github.com/yakamara/redaxo_yform/blob/master/docs/04_yorm.md#yorm-mit-eigener-model-class-verwenden

    public function getName() :string
    {
        return $this->getValue('name');
    }

    public static function domains($label, $value)
    {
        return "xx".$label;
    }

    public static function getServices() {

        return self::query()->find();

    }
    public static function getServicesAsJson() {

        return json_encode(self::getServices(), true);

    }
    public static function getServicesAsRevisionHash() {

        return md5(self::getServicesAsJson());

    }
}
