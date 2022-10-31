<?php

class rex_api_wsm extends rex_api_function
{
    protected $published = true;

    public function execute()
    {
        // Parameter abrufen und auswerten
        $consent_uuid = rex_request('consent_uuid', 'string');

        $dataset = null;
        if ($consent_uuid != "") {
            $dataset = wsm_protocol::query()->where("hash", $consent_uuid)->findOne();

            if (!(bool)$dataset) {
                $dataset = wsm_protocol::create();
            }

            $current = rex::getServer();

            if (rex_addon::get('yrewrite')->isAvailable()) {
                $current = rex_yrewrite::getCurrentDomain()->getName();
            };
    

            $dataset
            ->setValue('url', $current)
            ->setValue('hash', $consent_uuid)
            ->setValue('cookies', "")
            ->save();
        }

        // Artikel senden
        header('Content-Type: text/html; charset=UTF-8');
        dump($dataset);
        exit();
    }
}
