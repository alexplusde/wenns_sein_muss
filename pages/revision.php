<?php

echo rex_view::title(rex_i18n::msg('wenns_sein_muss_title'));

$func = rex_request('func', 'string');
$csrf = rex_csrf_token::factory('wenns_sein_muss_revision');
if ($func !== '') {
    if (!$csrf->isValid()) {
        echo rex_view::error(rex_i18n::msg('csrf_token_invalid'));
    } else {
        if ($func === 'revision') {
            rex_config::set('wenns_sein_muss', 'revision', intval(Alexplusde\Wsm\Wsm::getConfig('revision')) + 1);
            echo rex_view::success(rex_i18n::msg('wenns_sein_muss_revision_updated'));
        }
    }
}

/* Revision updaten */

$content = "";
$content .= '<p>'.rex_i18n::msg('wenns_sein_muss_revision').'</p>';
$content .= '<p><a class="btn btn-primary" href="'.rex_url::currentBackendPage(['func' => 'revision'] + $csrf->getUrlParams()).'" data-confirm="'.rex_i18n::msg('wenns_sein_muss_revision_warning').'">'.rex_i18n::msg('wenns_sein_muss_revision').'</a></p>';

$fragment = new rex_fragment();
$fragment->setVar('class', 'danger', false);
$fragment->setVar('title', rex_i18n::msg('wenns_sein_muss_revision'), false);
$fragment->setVar('body', $content, false);
echo $fragment->parse('core/page/section.php');
