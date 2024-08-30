<?php

namespace Alexplusde\Wsm;

class Protocol extends \rex_yform_manager_dataset
{
	
    /* Website */
    /** @api */
    public function getUrl() : ?string {
        return $this->getValue("url");
    }
    /** @api */
    public function setUrl(mixed $value) : self {
        $this->setValue("url", $value);
        return $this;
    }

    /* ID */
    /** @api */
    public function getConsentId() : ?string {
        return $this->getValue("consent_id");
    }
    /** @api */
    public function setConsentId(mixed $value) : self {
        $this->setValue("consent_id", $value);
        return $this;
    }

    /* Einwilligung */
    /** @api */
    public function getAcceptType() : ?string {
        return $this->getValue("accept_type");
    }
    /** @api */
    public function setAcceptType(mixed $value) : self {
        $this->setValue("accept_type", $value);
        return $this;
    }

    /* eingewilligt (Kategorie) */
    /** @api */
    public function getAcceptedCategories() : ?string {
        return $this->getValue("accepted_categories");
    }
    /** @api */
    public function setAcceptedCategories(mixed $value) : self {
        $this->setValue("accepted_categories", $value);
        return $this;
    }

    /* eingewilligt (Drittanbieter) */
    /** @api */
    public function getAcceptedServices() : ?string {
        return $this->getValue("accepted_services");
    }
    /** @api */
    public function setAcceptedServices(mixed $value) : self {
        $this->setValue("accepted_services", $value);
        return $this;
    }

    /* abgelehnt (Kategorie) */
    /** @api */
    public function getRejectedCategories() : ?string {
        return $this->getValue("rejected_categories");
    }
    /** @api */
    public function setRejectedCategories(mixed $value) : self {
        $this->setValue("rejected_categories", $value);
        return $this;
    }

    /* abgelehnt (Drittanbieter) */
    /** @api */
    public function getRejectedServices() : ?string {
        return $this->getValue("rejected_services");
    }
    /** @api */
    public function setRejectedServices(mixed $value) : self {
        $this->setValue("rejected_services", $value);
        return $this;
    }

    /* Zeitstempel */
    /** @api */
    public function getConsentdate() : ?string {
        return $this->getValue("consentdate");
    }
    /** @api */
    public function setConsentdate(string $value) : self {
        $this->setValue("consentdate", $value);
        return $this;
    }
}
