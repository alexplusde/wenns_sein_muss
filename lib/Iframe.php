<?php

namespace Alexplusde\Wsm;

class Iframe extends \rex_yform_manager_dataset
{
	
    /* Schlüssel */
    /** @api */
    public function getKey() : ?string {
        return $this->getValue("key");
    }
    /** @api */
    public function setKey(mixed $value) : self {
        $this->setValue("key", $value);
        return $this;
    }

    /* Embed-URL */
    /** @api */
    public function getEmbedUrl() : ?string {
        return $this->getValue("embedUrl");
    }
    /** @api */
    public function setEmbedUrl(mixed $value) : self {
        $this->setValue("embedUrl", $value);
        return $this;
    }

}?>
