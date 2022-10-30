<?php
/**
 *     REX_WSM[]
 */
class rex_var_wsm extends rex_var
{
    protected function getOutput()
    {
        $fragment = new rex_fragment();

        if ($this->hasArg('type') && $this->getArg('type') == "css") {
            return self::quote($fragment->parse('wsm.css.php'));
        }
        if ($this->hasArg('type') && $this->getArg('type') == "js") {
            return self::quote($fragment->parse('wsm.js.php'));
        }
        if ($this->hasArg('type') && $this->getArg('type') == "manage") {
            return self::quote($fragment->parse('wsm.manage.php'));
        }
        return self::quote("");
    }
}
