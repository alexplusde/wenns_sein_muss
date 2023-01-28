<?php

class wsm_fragment extends rex_fragment {
    
    public static function getIframe($data_service, $data_id = "", $data_params = "", $data_thumbnail = null)
    {
        $fragment = new self();
        $fragment->setVar("data-service", $data_service);
        $fragment->setVar("data-id", $data_id);
        $fragment->setVar("data-params", $data_params);
        $fragment->setVar("data-thumbnail", $data_thumbnail);
        return $fragment->parse('wsm.iframe.php');
    }
    public static function getJs()
    {
        $fragment = new self();
        return $fragment->parse('wsm.js.php');
    }
    public static function getCss()
    {
        $fragment = new self();
        return $fragment->parse('wsm.css.php');
    }    
}
