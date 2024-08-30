<?php

echo rex_view::title(rex_i18n::msg('wenns_sein_muss_title'));

$func = rex_request('func', 'string');
$csrf = rex_csrf_token::factory('wenns_sein_muss_demo');
if ($func !== '') {
    if (!$csrf->isValid()) {
        echo rex_view::error(rex_i18n::msg('csrf_token_invalid'));
    } else {
        if ($func === 'setup') {
            $file = rex_path::addon('wenns_sein_muss').'install/demo.sql';
            rex_sql_util::importDump($file);
            echo rex_view::success(rex_i18n::msg('wenns_sein_muss_demo_imported'));
        }
        if ($func === 'sprog') {
            $package = rex_package::get('wenns_sein_muss');
            $sprog_config = $package->getProperty('sprog_config');
            foreach($sprog_config as $key) {
                rex_config::set('wenns_sein_muss', $key, Sprog\Wildcard::getOpenTag() . $key .Sprog\Wildcard::getCloseTag());
            }
        }
            
    }
}

/* Demo-Daten importieren */

$content = "";
$content .= '<p>'.rex_i18n::msg('wenns_sein_muss_demo_import').'</p>';
$content .= '<p><a class="btn btn-primary" href="'.rex_url::currentBackendPage(['func' => 'setup'] + $csrf->getUrlParams()).'" data-confirm="'.rex_i18n::msg('wenns_sein_muss_demo_warning').'">'.rex_i18n::msg('wenns_sein_muss_demo').'</a></p>';

$fragment = new rex_fragment();
$fragment->setVar('class', 'danger', false);
$fragment->setVar('title', rex_i18n::msg('wenns_sein_muss_demo'), false);
$fragment->setVar('body', $content, false);
echo $fragment->parse('core/page/section.php');

/* Config mit Sprog-Keys überschreiben  */

if(rex_addon::get('sprog')->isAvailable()) {
    $content = "";
    $content .= '<p>'.rex_i18n::msg('wenns_sein_muss_sprog_import').'</p>';
    $content .= '<p><a class="btn btn-primary" href="'.rex_url::currentBackendPage(['func' => 'sprog'] + $csrf->getUrlParams()).'" data-confirm="'.rex_i18n::msg('wenns_sein_muss_sprog_warning').'">'.rex_i18n::msg('wenns_sein_muss_sprog').'</a></p>';


    $fragment = new rex_fragment();
    $fragment->setVar('class', 'danger', false);
    $fragment->setVar('title', rex_i18n::msg('wenns_sein_muss_sprog'), false);
    $fragment->setVar('body', $content, false);
    echo $fragment->parse('core/page/section.php');
}
