<?php
class wsm_domain extends \rex_yform_manager_dataset
{
    public static function getCurrent()
    {
        return;
    }

    public function getImprintArticle()
    {
        return rex_article::get();
    }

    public static function getPrivacyPolicyArticle()
    {
        return rex_article::get();
    }
}
