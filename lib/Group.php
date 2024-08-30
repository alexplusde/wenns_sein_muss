<?php

namespace Alexplusde\WennsSeinMuss;

class Group extends \rex_yform_manager_dataset
{
    public function getGroup() :string
    {
        return (string)$this->getValue('group');
    }

    public function getName() :string
    {
        return (string)$this->getValue('name');
    }

    public function getTitle() :string
    {
        return (string)$this->getValue('title');
    }

    public function getDescription() :string
    {
        return (string)$this->getValue('description');
    }

    public function getEnabled() :int
    {
        return (int)$this->getValue('enabled');
    }

    public function getRequired() :int
    {
        return (int)$this->getValue('required');
    }
}
