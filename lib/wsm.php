<?php
class wsm extends \rex_yform_manager_dataset
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
}
