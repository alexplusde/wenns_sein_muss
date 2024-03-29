<?php

class rex_api_wsm extends rex_api_function
{
    protected $published = true;

    public function execute()
    {

        if (rex_get("wsm", 'string') === "log") {
            header('Content-Type: application/json; charset=UTF-8');
            echo self::log();
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

        $consentId = rex_post('consentId', 'string');

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
            ->setValue('accept_type', rex_post('acceptType', 'string'))
            ->setValue('accepted_categories', rex_post('acceptedCategories', 'string'))
            ->setValue('rejected_categories', rex_post('rejectedCategories', 'string'))
            ->setValue('accepted_services', rex_post('acceptedServices', 'string'))
            ->setValue('rejected_services', rex_post('rejectedServices', 'string'))
            ->save();
            
            return json_encode($_POST);

        }
    }
}
