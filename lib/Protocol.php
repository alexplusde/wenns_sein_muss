<?php

namespace Alexplusde\Wsm;

use rex_extension_point;
use rex_i18n;
use rex_yform_list;
use rex_yform_manager_dataset;

class Protocol extends rex_yform_manager_dataset
{
    /* Website */
    /** @api */
    public function getUrl(): string
    {
        return $this->getValue('url');
    }

    /** @api */
    public function setUrl(mixed $value): self
    {
        $this->setValue('url', $value);
        return $this;
    }

    /* ID */
    /** @api */
    public function getConsentId(): string
    {
        return $this->getValue('consent_id');
    }

    /** @api */
    public function setConsentId(mixed $value): self
    {
        $this->setValue('consent_id', $value);
        return $this;
    }

    /* Einwilligung */
    /** @api */
    public function getAcceptType(): string
    {
        return $this->getValue('accept_type');
    }

    /** @api */
    public function setAcceptType(mixed $value): self
    {
        $this->setValue('accept_type', $value);
        return $this;
    }

    /* eingewilligt (Kategorie) */
    /** @api */
    public function getAcceptedCategories(): string
    {
        return $this->getValue('accepted_categories');
    }

    /** @api */
    public function setAcceptedCategories(mixed $value): self
    {
        $this->setValue('accepted_categories', $value);
        return $this;
    }

    /* eingewilligt (Drittanbieter) */
    /** @api */
    public function getAcceptedServices(): string
    {
        return $this->getValue('accepted_services');
    }

    /** @api */
    public function setAcceptedServices(mixed $value): self
    {
        $this->setValue('accepted_services', $value);
        return $this;
    }

    /* abgelehnt (Kategorie) */
    /** @api */
    public function getRejectedCategories(): string
    {
        return $this->getValue('rejected_categories');
    }

    /** @api */
    public function setRejectedCategories(mixed $value): self
    {
        $this->setValue('rejected_categories', $value);
        return $this;
    }

    /* abgelehnt (Drittanbieter) */
    /** @api */
    public function getRejectedServices(): string
    {
        return $this->getValue('rejected_services');
    }

    /** @api */
    public function setRejectedServices(mixed $value): self
    {
        $this->setValue('rejected_services', $value);
        return $this;
    }

    /* Zeitstempel */
    /** @api */
    public function getConsentdate(): string
    {
        return $this->getValue('consentdate');
    }

    /** @api */
    public function setConsentdate(string $value): self
    {
        $this->setValue('consentdate', $value);
        return $this;
    }

    /* Revision */
    /** @api */
    public function getRevision(): ?string
    {
        return $this->getValue('revision');
    }

    /** @api */
    public function setRevision(string $value): self
    {
        $this->setValue('revision', $value);
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

        $list->removeColumn('accept_type');
        $list->removeColumn('accepted_categories');
        $list->removeColumn('accepted_services');
        $list->removeColumn('rejected_categories');
        $list->removeColumn('rejected_services');

        /* add column */
        $list->addColumn('preferences', rex_i18n::msg('wsm_protocol_preferences'), 5);
        $list->setColumnLabel('preferences', rex_i18n::msg('wsm_protocol_preferences'));

        $list->setColumnFormat(
            'preferences',
            'custom',
            static function ($a) {
                $accepted_services = $a['list']->getValue('accepted_services');
                $rejected_services = $a['list']->getValue('rejected_services');

                $accepted_services = array_filter(json_decode($accepted_services, true) ?? [], fn (string $value): bool => strlen($value) > 0);
                $rejected_services = array_filter(json_decode($rejected_services, true) ?? [], fn (string $value): bool => strlen($value) > 0);

                $output = '';
                $output .= '✅<br>';
                // TODO: Überprüfen, was $services enthält und ggf. Tags / Badges daraus machen
                foreach ($accepted_services as $category => $services) {
                    $output .= '<small>' . $category . ': ' . $services . '</small><br>';
                }

                $output .= '❌<br>';
                // TODO: Überprüfen, was $services enthält und ggf. Tags / Badges daraus machen
                foreach ($rejected_services as $category => $services) {
                    $output .= '<small>' . $category . ': ' . $services . '</small><br>';
                }

                return $output;
            },
        );
    }
}
