<?php

class wsm_fragment extends rex_fragment
{
    public static function getIframe(string $data_service, int $data_id = "", $data_params = "", string $data_thumbnail = null)
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
        
    public static function getScripts()
    {
        $output = "";
        foreach (wsm_service::findScripts() as $script) {
            $fragment = new rex_fragment();
            $fragment->setVar('category', $script->getValue('group_name'));
            $fragment->setVar('service', $script->getValue('service'));
            $fragment->setVar('script', $script->getValue('script'), false);
            $output.= $fragment->parse("wsm.script.php");
        }
        return $output;
    }
}
