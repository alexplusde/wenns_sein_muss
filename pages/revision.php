<?php

echo rex_view::title(rex_i18n::msg('wenns_sein_muss_title'));

$func = rex_request('func', 'string');
$csrf = rex_csrf_token::factory('wenns_sein_muss_revision');
if ($func !== '') {
    if (!$csrf->isValid()) {
        echo rex_view::error(rex_i18n::msg('csrf_token_invalid'));
    } else {
        if ($func === 'revision') {
            rex_config::set('wenns_sein_muss', 'revision', rex_config::get('wenns_sein_muss', 'revision') + 1);
            echo rex_view::success(rex_i18n::msg('wenns_sein_muss_revision_updated'));
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
