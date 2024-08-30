<?php

class rex_api_wsm_iframe extends rex_api_function
{
    protected $published = true;

    public function execute()
    {
        $service = rex_get("service", 'string');
        $param =  rex_get("id", 'string');
        if (!$param) {
            exit;
        }

        if ($service === "vimeo" && $param) {
            $response = rex_socket::factoryUrl("https://vimeo.com/api/v2/video/".$param.".json")->doGet();
            if($response->isOk()) {
                //liest die Informationen aus der Datei
                $body = json_decode($response->getBody());
            }
            rex_response::setStatus(301);
            rex_response::sendRedirect($body[0]->thumbnail_large);
        }

        if ($service === "youtube") {
            rex_response::setStatus(301);
            rex_response::sendRedirect("https://i3.ytimg.com/vi/".$param."/hqdefault.jpg");
        }

        exit();
    }
}
