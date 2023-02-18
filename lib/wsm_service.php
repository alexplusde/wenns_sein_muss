<?php
class wsm_service extends \rex_yform_manager_dataset
{
    public function getService() :string
    {
        return $this->getValue('service');
    }

    public static function findScripts()
    {
        return self::query()->whereRaw('(`script` != "" AND (FIND_IN_SET(`rex_domain`, 0) || FIND_IN_SET(`rex_domain`, '.wsm::getDomainId().')))')->joinRelation('group', 'g')->select('g.name', 'group_name')->find();
    }
    

    public static function findServices(int $group_id)
    {
        return self::query()->whereRaw('(`group` = '.$group_id.' AND (FIND_IN_SET(`rex_domain`, 0) || FIND_IN_SET(`rex_domain`, '.wsm::getDomainId().')))')->find();
    }
}
