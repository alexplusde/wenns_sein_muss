<?php

namespace Alexplusde\Wsm;

use rex_var;

/**
 *     REX_WSM[type="css"]
 *     REX_WSM[type="js"]
 *     REX_WSM[type="manage"]
 *     REX_WSM[type="iframe" service="youtube" id="###id###" params="###urlparams###" thumbnail="###urlthumbnail"].
 */
class RexVar extends rex_var
{
    protected function getOutput()
    {
        $fragment = new Fragment();

        if ($this->hasArg('type') && 'css' === $this->getArg('type')) {
            return self::quote($fragment->parse('wsm.css.php'));
        }
        if ($this->hasArg('type') && 'js' === $this->getArg('type')) {
            return self::quote($fragment->parse('wsm.js.php'));
        }
        if ($this->hasArg('type') && 'manage' === $this->getArg('type')) {
            return self::quote($fragment->parse('wsm.manage.php'));
        }
        if ($this->hasArg('type') && 'iframe' === $this->getArg('type')) {
            return self::quote(Fragment::getIframe($this->getArg('service'), $this->getArg('id'), $this->getArg('params'), $this->getArg('thumbnail')));
        }
        return '';
    }
}
