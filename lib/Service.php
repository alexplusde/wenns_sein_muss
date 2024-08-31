<?php

namespace Alexplusde\Wsm;

use rex_yform_manager_collection;
use rex_yform_manager_dataset;
use rex_yrewrite;

class Service extends \rex_yform_manager_dataset
{

    private const STATUS_OPTIONS = [
        0 => 'translate:wsm_service_status_draft',
        1 => 'translate:wsm_service_status_published',
    ];
    public function getName() :string
    {
        return $this->getService();
    }

    /**
     * 
     * @return rex_yform_manager_collection<self> 
     */
    public static function findScripts() : rex_yform_manager_collection
    {
        return self::query()->whereRaw('`status` = 1 AND `script` != "" AND (FIND_IN_SET(0, `rex_domain`) || FIND_IN_SET('.Wsm::getDomainId().', `rex_domain`))')->joinRelation('group', 'g')->select('g.name', 'group_name')->find();
    }
    

    /**
     * 
     * @return rex_yform_manager_collection<self> 
     */
    public static function findServices(int $group_id): rex_yform_manager_collection
    {
        return self::query()->whereRaw('`status` = 1 AND `group` = '.$group_id.' AND (FIND_IN_SET(0, `rex_domain`) || FIND_IN_SET('.Wsm::getDomainId() .', `rex_domain`))')->find();
    }

    /* Gruppe */
    /** @api */
    public function getGroup() : ?rex_yform_manager_dataset {
        return $this->getRelatedDataset("group");
    }

    /* Name */
    /** @api */
    public function getService() : string {
        return $this->getValue("service");
    }
    /** @api */
    public function setService(mixed $value) : self {
        $this->setValue("service", $value);
        return $this;
    }

    /* Name des Unternehmens */
    /** @api */
    public function getCompanyName() : string {
        return $this->getValue("company_name");
    }
    /** @api */
    public function setCompanyName(string $value) : self {
        $this->setValue("company_name", $value);
        return $this;
    }

    /* Anschrift */
    /** @api */
    public function getCompanyAddress() : string {
        return $this->getValue("company_address");
    }
    /** @api */
    public function setCompanyAddress(string $value) : self {
        $this->setValue("company_address", $value);
        return $this;
    }

    /* Datenschutzerklärung */
    /** @api */
    public function getPrivacyPolicyUrl() : string {
        return $this->getValue("privacy_policy_url");
    }
    /** @api */
    public function setPrivacyPolicyUrl(string $value) : self {
        $this->setValue("privacy_policy_url", $value);
        return $this;
    }

    /* Iframe-Manager */
    /** @api */
    public function getIframe() : ?rex_yform_manager_dataset {
        return $this->getRelatedDataset("iframe");
    }

    /* Domain(s) */
    /** @api */
    public function getRexDomain() : ? \rex_yrewrite_domain {
        return rex_yrewrite::getDomainById($this->getRexDomainId());
    }
    /** @api */
    public function getRexDomainId() : int {
        return intval($this->getValue("rex_domain"));
    }
    /** @api */
    public function setRexDomain(int $value) : self {
        $this->setValue("rex_domain", $value);
        return $this;
    }

    /* Cookies, LocalStorage und Tracking-Bilder */
    /** @api */
    public function getEntry() : ?rex_yform_manager_collection {
        return $this->getRelatedCollection("entry_ids");
    }

    /* JavaScript (nach Einwilligung) */
    /** @api */
    public function getScript() : string {
        return $this->getValue("script");
    }
    /** @api */
    public function setScript(string $value) : self {
        $this->setValue("script", $value);
        return $this;
    }
            
    /* Aktualisiert am... */
    /** @api */
    public function getUpdatedate() : string {
        return $this->getValue("updatedate");
    }
    /** @api */
    public function setUpdatedate(string $value) : self {
        $this->setValue("updatedate", $value);
        return $this;
    }

    /* Status */
    /** @api */
    public function getStatus() : ?int {
        return $this->getValue("status");
    }
    /** @api */
    public function setStatus(int $value) : self {
        $this->setValue("status", $value);
        return $this;
    }

    /** @api 
     * @return array<int, string>
    */
    public static function getStatusOptions() : array {
        return self::STATUS_OPTIONS;
    }
}
