<?php

namespace Alexplusde\Wsm;

use rex;
use rex_addon;
use rex_api_function;
use rex_yrewrite;

use const JSON_PRETTY_PRINT;

class ApiWsm extends rex_api_function
{
    protected $published = true;

    public function execute()
    {
        if ('log' === rex_get('wsm', 'string')) {
            header('Content-Type: application/json; charset=UTF-8');
            echo self::log();
        }
        if ('css' === rex_get('wsm', 'string')) {
            echo Fragment::getCss();
        }
        if ('lang' === rex_get('wsm', 'string')) {
            header('Content-Type: application/json; charset=UTF-8');
            echo Lang::getLangAsJson();
        }
        if ('js' === rex_get('wsm', 'string')) {
            echo Fragment::getJs();
        }
        exit;
    }

    private static function log(): string|false
    {
        $consentId = rex_post('consentId', 'string', '');

        if ('' !== $consentId) {
            $protocol = Protocol::create();

            $current = rex::getServer();

            if (rex_addon::get('yrewrite')->isAvailable()) {
                $current = rex_yrewrite::getCurrentDomain()->getName();
            }

            $protocol
            ->setUrl($current)
            ->setConsentId($consentId)
            ->setAcceptType(rex_post('acceptType', 'string'))
            ->setAcceptedCategories(rex_post('acceptedCategories', 'string'))
            ->setRejectedCategories(rex_post('rejectedCategories', 'string'))
            ->setAcceptedServices(rex_post('acceptedServices', 'string'))
            ->setRejectedServices(rex_post('rejectedServices', 'string'))
            ->setRevision(date('Y-m-d H:i:s', rex_post('revision', 'int')))
            ->save();

            return json_encode($protocol, JSON_PRETTY_PRINT);
        }

        return false;
    }
}
