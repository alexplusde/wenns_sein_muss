<?php
class wsm_domain extends \rex_yform_manager_dataset
{
    public static function getCurrent()
    {
        return wsm_domain::query()->where('domain_id', wsm::getDomainId())->findOne();
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
