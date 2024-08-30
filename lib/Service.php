<?php

namespace Alexplusde\WennsSeinMuss;

class Service extends \rex_yform_manager_dataset
{
    public function getService() :string
    {
        return $this->getValue('service');
    }

    public function getName() :string
    {
        return $this->getService();
    }

    public function getCompanyName() :string
    {
        return $this->getValue('company_name');
    }

    public static function findScripts()
    {
        return self::query()->whereRaw('`script` != "" AND (FIND_IN_SET(0, `rex_domain`) || FIND_IN_SET('.wsm::getDomainId().', `rex_domain`))')->joinRelation('group', 'g')->select('g.name', 'group_name')->find();
    }
    

    public static function findServices(int $group_id)
    {
        return self::query()->whereRaw('`group` = '.$group_id.' AND (FIND_IN_SET(0, `rex_domain`) || FIND_IN_SET('.wsm::getDomainId().', `rex_domain`))')->find();
    }
}
