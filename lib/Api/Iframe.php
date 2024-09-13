<?php

namespace Alexplusde\Wsm;

use rex_api_function;
use rex_response;
use rex_socket;
use rex_string;
use rex_path;
use rex_file;
use rex_url;

use function array_key_exists;
use function is_array;

class ApiWsmIframe extends rex_api_function
{
    protected $published = true;

    public function execute()
    {
        $service = rex_get('service', 'string', '');
        $id = rex_get('id', 'string', '');

        if ('' === $id) {
            exit;
        }

        if ('vimeo' === $service) {
            $response = rex_socket::factoryUrl('https://vimeo.com/api/v2/video/' . $id . '.json')->doGet();
            if ($response->isOk()) {
                // liest die Informationen aus der Datei
                $body = json_decode($response->getBody());
            }
            if (is_array($body) && array_key_exists(0, $body) && property_exists($body[0], 'thumbnail_large')) {                
                $url = self::getImgFromVimeo($id, $body[0]->thumbnail_large);
                rex_response::setStatus('301');
                rex_response::sendRedirect($url);
            }
        }

        if ('youtube' === $service) {
            $url = self::getImgFromYoutube($id);
            rex_response::setStatus('301');
            rex_response::sendRedirect($url);
        }

        exit;
    }

    
    private static function getImgFromYoutube(string $id) :string
    {
        
        if (null !== \rex_file::get(rex_path::addonData('wenns_sein_muss', self::generateFileName('youtube', $id)))) {
            return self::getThumbUrl('youtube', $id);
        }

        try {
            $socket = rex_socket::factory('i3.ytimg.com', 443, true);
            $socket->setPath('/vi/' . $id . '/hqdefault.jpg');
            $socket->followRedirects(1);
            
            $response = $socket->doGet();

            if ($response->isOk()) {
                $image_path = rex_path::addonData('wenns_sein_muss', self::generateFileName('youtube', $id));
                $response->writeBodyTo($image_path);
                return self::getThumbUrl('youtube', $id);
            }
        } catch(\rex_socket_exception $e) {
            \rex_logger::factory()->notice($e->getMessage());
        }
        return '';
    }

    private static function getImgFromVimeo(string $id, string $url) :string
    {
        
        if (null !== \rex_file::get(rex_path::addonData('wenns_sein_muss', self::generateFileName('vimeo', $id)))) {
            return self::getThumbUrl('vimeo', $id);
        }

        try {
            $socket = rex_socket::factoryUrl($url);
            $response = $socket->doGet();

            if ($response->isOk()) {
                $image_path = rex_path::addonData('wenns_sein_muss', self::generateFileName('vimeo', $id));
                $response->writeBodyTo($image_path);
                return self::getThumbUrl('vimeo', $id);
            }
        } catch(\rex_socket_exception $e) {
            \rex_logger::factory()->notice($e->getMessage());
        }
        return '';
    }

    private static function generateFileName(string $service = '', string $id, string $filetype = '.jpg') :string
    {
        return rex_string::normalize($service . '_' . $id) . $filetype;
    }
    
    public static function getThumbUrl(string $service = '', string $id, string $filetype = '.jpg') :string
    {
        $filename = self::generateFilename($service, $id, $filetype);
        $file = rex_path::addonData('wenns_sein_muss', $filename);

        $timestamp = filemtime($file);
        $frontend_url = rex_url::media(). Wsm::getConfig('media_manager_type', 'string', 'wsm').'/'.$filename.'?timestamp='.$timestamp;
        return $frontend_url;
    }
}
