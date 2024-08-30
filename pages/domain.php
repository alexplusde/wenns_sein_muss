<?php

echo rex_view::title(rex_i18n::msg('wenns_sein_muss_title'));

$addon = rex_addon::get('wenns_sein_muss');

if (!rex_addon::get('yrewrite')->isAvailable() || count(rex_yrewrite::getDomains()) < 2) {
    echo rex_view::error(rex_i18n::rawMsg('wenns_sein_muss_error_no_domains', '<a href="'.rex_url::backendPage('wenns_sein_muss/settings/basic').'">WSM Einstellungen</a>'));
}

$yform = $addon->getProperty('yform', []);
$yform = $yform[\rex_be_controller::getCurrentPage()] ?? [];

$table_name = 'rex_wenns_sein_muss_domain';

\rex_extension::register(
    'YFORM_MANAGER_DATA_PAGE_HEADER',
    function (\rex_extension_point $ep) {
        if ($ep->getParam('yform')->table->getTableName() === $ep->getParam('table_name')) {
            return '';
        }
    },
    \rex_extension::EARLY,
    ['table_name'=>$table_name]
);

// @phpstan-ignore-next-line
$_REQUEST['table_name'] = $table_name;

include \rex_path::plugin('yform', 'manager', 'pages/data_edit.php');
