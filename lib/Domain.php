<?php

namespace Alexplusde\Wsm;

use rex_article;
use rex_extension_point;
use rex_yform_list;
use rex_yform_manager_dataset;
use rex_yrewrite;
use rex_yrewrite_domain;

use function is_int;

class Domain extends rex_yform_manager_dataset
{
    /**
     * @api
     */
    public static function getCurrent(): ?self
    {
        return self::query()->where('domain_id', Wsm::getDomainId())->findOne();
    }

    /** @api */
    public function getImprintArticle(): ?rex_article
    {
        return rex_article::get($this->getValue('imprint_id'));
    }

    /** @api */
    public function getPrivacyPolicyArticle(): ?rex_article
    {
        return rex_article::get($this->getValue('privacy_policy_id'));
    }

    /* Domain */
    /** @api */
    public function getDomain(): ?rex_yrewrite_domain
    {
        return rex_yrewrite::getDomainById($this->getValue('domain_id'));
    }

    /** @api */
    public function getDomainId(): int
    {
        return $this->getValue('domain_id');
    }

    /** @api */
    public function setDomainId(int $value): self
    {
        $this->setValue('domain_id', $value);
        return $this;
    }

    /* Datenschutzerklärung */
    /** @api */
    public function getPrivacyPolicyId(): int
    {
        return $this->getValue('privacy_policy_id');
    }

    /** @api */
    public function getPrivacyPolicyUrl(): string
    {
        if (($article = rex_article::get($this->getPrivacyPolicyId())) instanceof rex_article) {
            return $article->getUrl();
        }
        return '';
    }

    /** @api */
    public function setPrivacyPolicyId(int $id): self
    {
        if (rex_article::get($id) instanceof rex_article) {
            $this->setValue('privacy_policy_id', $id);
        }
        return $this;
    }

    /* Impressum */
    /** @api */
    public function getImprintId(): int
    {
        return $this->getValue('imprint_id');
    }

    /** @api */
    public function getImprintUrl(): string
    {
        if (($article = rex_article::get($this->getImprintId())) instanceof rex_article) {
            return $article->getUrl();
        }
        return '';
    }

    /** @api */
    public function setImprintId(int $id): self
    {
        if (rex_article::get($id) instanceof rex_article) {
            $this->setValue('imprint_id', $id);
        }
        return $this;
    }

    /**
     * @param rex_extension_point<rex_yform_list> $ep
     * @return void|rex_yform_list
     */
    public static function epYformDataList(rex_extension_point $ep)
    {
        if ($ep->getParam('table')->getTableName() !== self::table()->getTableName()) {
            return;
        }

        /** @var rex_yform_list $list */
        $list = $ep->getSubject();

        $list->setColumnFormat(
            'imprint_id',
            'custom',
            static function ($a) {
                $id = $a['list']->getValue('imprint_id');
                if (is_int($id) && rex_article::get($id) instanceof rex_article) {
                    return rex_article::get($id)->getName() . '<br><small>' . rex_article::get($id)->getUrl() . '</small>';
                }
                return '❌';
            },
        );
        $list->setColumnFormat(
            'privacy_policy_id',
            'custom',
            static function ($a) {
                $id = $a['list']->getValue('privacy_policy_id');
                if (is_int($id) && rex_article::get($id) instanceof rex_article) {
                    return rex_article::get($id)->getName() . '<br><small>' . rex_article::get($id)->getUrl() . '</small>';
                }
                return '❌';
            },
        );
    }
}
