<?php

namespace Alexplusde\Wsm;

use rex_yform_manager_dataset;

class Entry extends rex_yform_manager_dataset
{
    /**
     * @return array<string,string>[]
     */
    public static function findEntriesArray(int $service_id): array
    {
        $service = Service::get($service_id);
        if (null === $service) {
            return [];
        }
        $entries = self::query()->where('service_id', $service_id)->find();
        $return = [];
        foreach ($entries as $entry) {
            $e = [];
            $e['name'] = $entry->getName();
            $e['service'] = $service->getName();
            $e['description'] = $entry->getDescription();
            $e['duration'] = $entry->getDuration();
            $e['type'] = $entry->getType();

            $return[] = $e;
        }
        return $return;
    }

    /* Typ */
    /** @api */
    public function getType(): string
    {
        return $this->getValue('type');
    }

    /** @api */
    public function setType(mixed $value): self
    {
        $this->setValue('type', $value);
        return $this;
    }

    /* Name / Schlüssel */
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

    /* Speicherdauer */
    /** @api */
    public function getDuration(): string
    {
        return $this->getValue('duration');
    }

    /** @api */
    public function setDuration(mixed $value): self
    {
        $this->setValue('duration', $value);
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

    /* Service */
    /** @api */
    public function getService(): ?rex_yform_manager_dataset
    {
        return $this->getRelatedDataset('service_id');
    }
}
