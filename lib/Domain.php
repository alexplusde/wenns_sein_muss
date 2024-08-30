<?php

namespace Alexplusde\Wsm;

use rex_article;
use rex_yrewrite_domain;
use rex_yrewrite;

class Domain extends \rex_yform_manager_dataset
{

    /**
     * @api
     * @return Domain
     */
    public static function getCurrent() : ?self
    {
        return self::query()->where('domain_id', Wsm::getDomainId())->findOne();
    }

    /** @api */
    public function getImprintArticle() : ?rex_article
    {
        return rex_article::get($this->getValue('imprint_id'));
    }

    /** @api */
    public function getPrivacyPolicyArticle() : ?rex_article
    {
        return rex_article::get($this->getValue('privacy_policy_id'));
    }

    /* Domain */
    /** @api */
    public function getDomain() : ?rex_yrewrite_domain {
        return rex_yrewrite::getDomainById($this->getValue("domain_id"));
    }
    /** @api */
    public function getDomainId() : ?int {
        return $this->getValue("domain_id");
    }
    /** @api */
    public function setDomainId(int $value) : self {
        $this->setValue("domain_id", $value);
        return $this;
    }

    /* Datenschutzerklärung */
    /** @api */
    public function getPrivacyPolicyId() : ?int {
        return $this->getValue("privacy_policy_id");
    }

    /** @api */
    public function getPrivacyPolicyUrl() : ?string {
        if($article = rex_article::get($this->getPrivacyPolicyId())) {
            return $article->getUrl();
        }
    }
    /** @api */
    public function setPrivacyPolicyId(string $id) : self {
        if(rex_article::get($id)) {
            $this->getValue("privacy_policy_id", $id);
        }
        return $this;
    }

    /* Impressum */
    /** @api */
    public function getImprintId() : ?int {
        return $this->getValue("imprint_id");
    }
    /** @api */
    public function getImprintUrl() : ?string {
        if($article = rex_article::get($this->getImprintId())) {
            return $article->getUrl();
        }
    }
    /** @api */
    public function setImprintId(string $id) : self {
        if(rex_article::get($id)) {
            $this->getValue("imprint_id", $id);
        }
        return $this;
    }
}
