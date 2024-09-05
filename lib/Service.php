<?php

namespace Alexplusde\Wsm;

use rex_extension_point;
use rex_yform_list;
use rex_yform_manager_collection;
use rex_yform_manager_dataset;
use rex_yrewrite;
use rex_yrewrite_domain;

use function count;
use function strlen;

class Service extends rex_yform_manager_dataset
{
    private const STATUS_OPTIONS = [
        0 => 'translate:wsm_service_status_draft',
        1 => 'translate:wsm_service_status_published',
    ];

    public function getName(): string
    {
        return $this->getService();
    }

    /**
     * @return rex_yform_manager_collection<self>
     */
    public static function findScripts(): rex_yform_manager_collection
    {
        return self::query()->whereRaw('`status` = 1 AND `script` != "" AND (FIND_IN_SET(0, `rex_domain`) || FIND_IN_SET(' . Wsm::getDomainId() . ', `rex_domain`))')->joinRelation('group', 'g')->select('g.name', 'group_name')->find();
    }

    /**
     * @return rex_yform_manager_collection<self>
     */
    public static function findServices(int $group_id): rex_yform_manager_collection
    {
        return self::query()->whereRaw('`status` = 1 AND `group` = ' . $group_id . ' AND (FIND_IN_SET(0, `rex_domain`) || FIND_IN_SET(' . Wsm::getDomainId() . ', `rex_domain`))')->find();
    }

    /* Gruppe */
    /** @api */
    public function getGroup(): ?rex_yform_manager_dataset
    {
        return $this->getRelatedDataset('group');
    }

    /* Name */
    /** @api */
    public function getService(): string
    {
        return $this->getValue('service');
    }

    /** @api */
    public function setService(mixed $value): self
    {
        $this->setValue('service', $value);
        return $this;
    }

    /* Name des Unternehmens */
    /** @api */
    public function getCompanyName(): string
    {
        return $this->getValue('company_name');
    }

    /** @api */
    public function setCompanyName(string $value): self
    {
        $this->setValue('company_name', $value);
        return $this;
    }

    /* Anschrift */
    /** @api */
    public function getCompanyAddress(): string
    {
        return $this->getValue('company_address');
    }

    /** @api */
    public function setCompanyAddress(string $value): self
    {
        $this->setValue('company_address', $value);
        return $this;
    }

    /* Datenschutzerklärung */
    /** @api */
    public function getPrivacyPolicyUrl(): string
    {
        return $this->getValue('privacy_policy_url');
    }

    /** @api */
    public function setPrivacyPolicyUrl(string $value): self
    {
        $this->setValue('privacy_policy_url', $value);
        return $this;
    }

    /* Iframe-Manager */
    /** @api */
    public function getIframe(): ?rex_yform_manager_dataset
    {
        return $this->getRelatedDataset('iframe');
    }

    /* Domain(s) */
    /** @api */
    public function getRexDomain(): ?rex_yrewrite_domain
    {
        return rex_yrewrite::getDomainById($this->getRexDomainId());
    }

    /** @api */
    public function getRexDomainId(): int
    {
        return (int) $this->getValue('rex_domain');
    }

    /** @api */
    public function setRexDomain(int $value): self
    {
        $this->setValue('rex_domain', $value);
        return $this;
    }

    /* Cookies, LocalStorage und Tracking-Bilder */
    /** @api */
    public function getEntry(): ?rex_yform_manager_collection
    {
        return $this->getRelatedCollection('entry_ids');
    }

    /* JavaScript (nach Einwilligung) */
    /** @api */
    public function getScript(): string
    {
        return $this->getValue('script');
    }

    /** @api */
    public function setScript(string $value): self
    {
        $this->setValue('script', $value);
        return $this;
    }

    /* Aktualisiert am... */
    /** @api */
    public function getUpdatedate(): string
    {
        return $this->getValue('updatedate');
    }

    /** @api */
    public function setUpdatedate(string $value): self
    {
        $this->setValue('updatedate', $value);
        return $this;
    }

    /* Status */
    /** @api */
    public function getStatus(): ?int
    {
        return $this->getValue('status');
    }

    /** @api */
    public function setStatus(int $value): self
    {
        $this->setValue('status', $value);
        return $this;
    }

    /** @api
     * @return array<int, string>
     */
    public static function getStatusOptions(): array
    {
        return self::STATUS_OPTIONS;
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

        $list->setColumnPosition('script', 3);
        $list->setColumnLabel('script', 'JS');
        $list->setColumnFormat(
            'script',
            'custom',
            static function ($a) {
                if ('' !== $a['list']->getValue('script')) {
                    return '<i class="fa fa-code"></i>';
                }
                return '';
            },
        );

        $list->setColumnPosition('iframe', 4);
        $list->setColumnLabel('iframe', 'IM');
        $list->setColumnFormat(
            'iframe',
            'custom',
            static function ($a) {
                if ($a['list']->getValue('iframe') > 0) {
                    return '<i class="fa fa-play-circle-o"></i>';
                }
                return '';
            },
        );

        $list->setColumnPosition('entry_ids', 5);
        $list->setColumnLabel('entry_ids', '🍪');
        $list->setColumnFormat(
            'entry_ids',
            'custom',
            static function ($a) {
                $count = count(Entry::query()->where('service_id', $a['list']->getValue('id'))->find());
                if ($count > 0) {
                    return $count;
                }
                return '';
            },
        );

        $list->setColumnFormat(
            'service',
            'custom',
            static function ($a) {
                $service = '' . $a['list']->getValue('service') . '<br /><small><strong>' . $a['list']->getValue('company_name') . '</strong></small><br /><small>' . $a['list']->getValue('company_address') . '</small><br />';
                $url = $a['list']->getValue('privacy_policy_url');
                if ('' !== $url && strlen($url) >= 64) {
                    $service .= '<a href="' . $a['list']->getValue('privacy_policy_url') . '">' . substr($url, 0, 64) . '...</a>';
                } elseif ('' !== $url) {
                    $service .= '<a href="' . $a['list']->getValue('privacy_policy_url') . '">' . $url . '</a>';
                } else {
                    $service .= '❌';
                }

                return $service;
            },
        );
        $list->removeColumn('privacy_policy_url');
    }
}
