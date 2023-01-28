<?php

class rex_api_wsm extends rex_api_function
{
    protected $published = true;

    public function execute()
    {

        if (rex_get("wsm", 'string') === "log") {
            self::log();
            header('Content-Type: text/html; charset=UTF-8');
        }
        if (rex_get("wsm", 'string') === "css") {
            echo wsm_fragment::getCss();
        }
        if (rex_get("wsm", 'string') === "lang") {
            header('Content-Type: application/json; charset=UTF-8');
            echo wsm_lang::getLangAsJson();
        }
        if (rex_get("wsm", 'string') === "js") {
            echo wsm_fragment::getJs();
        }
        exit();
    }



    private static function log() {

        $consentId = rex_request('consentId', 'string');

        $dataset = null;
        if ($consentId != "") {
            $dataset = wsm_protocol::query()->where("consent_id", $consentId)->findOne();

            if (!(bool)$dataset) {
                $dataset = wsm_protocol::create();
            }

            $current = rex::getServer();

            if (rex_addon::get('yrewrite')->isAvailable()) {
                $current = rex_yrewrite::getCurrentDomain()->getName();
            };
    

            $dataset
            ->setValue('url', $current)
            ->setValue('consent_id', $consentId)
            ->setValue('accept_type', rex_request('acceptType', 'string'))
            ->setValue('accepted_categories', rex_request('acceptedCategories', 'string'))
            ->setValue('rejected_categories', rex_request('rejectedCategories', 'string'))
            ->save();
        }
    }
}
