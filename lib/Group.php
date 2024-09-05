<?php

namespace Alexplusde\Wsm;

use rex_extension_point;
use rex_yform_list;
use rex_yform_manager_dataset;

class Group extends rex_yform_manager_dataset
{
    /* Name */
    /** @api */
    public function getName(): string
    {
        return $this->getValue('name');
    }

    /** @api */
    public function setName(mixed $value): self
    {
        $this->setValue('name', $value);
        return $this;
    }

    /* Titel */
    /** @api */
    public function getTitle(): string
    {
        return $this->getValue('title');
    }

    /** @api */
    public function setTitle(mixed $value): self
    {
        $this->setValue('title', $value);
        return $this;
    }

    /* Erläuterung */
    /** @api */
    public function getDescription(bool $asPlaintext = false): string
    {
        if ($asPlaintext) {
            return strip_tags($this->getValue('description'));
        }
        return $this->getValue('description');
    }

    /** @api */
    public function setDescription(mixed $value): self
    {
        $this->setValue('description', $value);
        return $this;
    }

    /* Vorauswahl */
    /** @api */
    public function getEnabled(bool $asBool = false): mixed
    {
        if ($asBool) {
            return (bool) $this->getValue('enabled');
        }
        return $this->getValue('enabled');
    }

    /** @api */
    public function setEnabled(int $value = 1): self
    {
        $this->setValue('enabled', $value);
        return $this;
    }

    /* Pflichtfeld */
    /** @api */
    public function getRequired(bool $asBool = false): mixed
    {
        if ($asBool) {
            return (bool) $this->getValue('required');
        }
        return $this->getValue('required');
    }

    /** @api */
    public function setRequired(int $value = 1): self
    {
        $this->setValue('required', $value);
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
            'description',
            'custom',
            static function ($a) {
                return $a['list']->getValue('description');
            },
        );
    }
}
