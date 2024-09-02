<?php

namespace Alexplusde\Wsm;

use rex_extension_point;
use rex_yform_list;

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
            function ($a) {
                return $a['list']->getValue('description');
            }
        );
    }

}
