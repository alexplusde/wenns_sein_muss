<?php
/**
 *     REX_WSM[]
 */
class rex_var_wsm extends rex_var
{
    protected function getOutput()
    {
        $fragment = new rex_fragment();

        if ($this->hasArg('css')) {
            return self::quote($fragment->parse('wsm.css.php'));
        }
        if ($this->hasArg('js')) {
            return self::quote($fragment->parse('wsm.js.php'));
        }
        return self::quote("");
    }
}
