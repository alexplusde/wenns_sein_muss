<?php

namespace Alexplusde\Wsm;

use rex_article;

class Domain extends \rex_yform_manager_dataset
{
    public static function getCurrent()
    {
        return self::query()->where('domain_id', Wsm::getDomainId())->findOne();
    }

    public function getImprintArticle()
    {
        return rex_article::get($this->getValue('imprint_id'));
    }

    public function getPrivacyPolicyArticle()
    {
        return rex_article::get($this->getValue('privacy_policy_id'));
    }
}
