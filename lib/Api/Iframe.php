<?php

namespace Alexplusde\Wsm;

use rex_api_function;
use rex_response;
use rex_socket;

use function array_key_exists;
use function is_array;

class ApiWsmIframe extends rex_api_function
{
    protected $published = true;

    public function execute()
    {
        $service = rex_get('service', 'string', '');
        $param = rex_get('id', 'string', '');
        if ('' === $param) {
            exit;
        }

        if ('vimeo' === $service) {
            $response = rex_socket::factoryUrl('https://vimeo.com/api/v2/video/' . $param . '.json')->doGet();
            if ($response->isOk()) {
                // liest die Informationen aus der Datei
                $body = json_decode($response->getBody());
            }
            rex_response::setStatus('301');
            if (is_array($body) && array_key_exists(0, $body) && property_exists($body[0], 'thumbnail_large')) {
                rex_response::sendRedirect($body[0]->thumbnail_large);
            }
        }

        if ('youtube' === $service) {
            rex_response::setStatus('301');
            rex_response::sendRedirect('https://i3.ytimg.com/vi/' . $param . '/hqdefault.jpg');
        }

        exit;
    }
}
