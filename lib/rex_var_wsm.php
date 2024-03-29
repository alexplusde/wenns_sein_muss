<?php
/**
 *     REX_WSM[type="css"]
 *     REX_WSM[type="js"]
 *     REX_WSM[type="manage"]
 *     REX_WSM[type="iframe" service="youtube" id="###id###" params="###urlparams###" thumbnail="###urlthumbnail"]
 */
class rex_var_wsm extends rex_var
{
    protected function getOutput()
    {
        $fragment = new wsm_fragment();

        if ($this->hasArg('type') && $this->getArg('type') == "css") {
            return self::quote($fragment->parse('wsm.css.php'));
        }
        if ($this->hasArg('type') && $this->getArg('type') == "js") {
            return self::quote($fragment->parse('wsm.js.php'));
        }
        if ($this->hasArg('type') && $this->getArg('type') == "manage") {
            return self::quote($fragment->parse('wsm.manage.php'));
        }
        if ($this->hasArg('type') && $this->getArg('type') == "iframe") {
            return self::quote(wsm_fragment::getIframe($this->getArg('service'), $this->getArg('id'), $this->getArg('params'), $this->getArg('thumbnail')));
        }
    }
}
