<?php

$addon = rex_addon::get('wenns_sein_muss');

echo rex_view::title($addon->i18n('wsm_title'));

/* Wenn Revisions-Zeitstempel kleiner als Letzter Änderungs Zeitstempel, dann auf die Backend-Seite */
//if (\Alexplusde\Wsm\Wsm::getRevisionTimestamp() < \Alexplusde\Wsm\Wsm::getLastChangeTimestamp()) {
echo rex_view::warning("Die Konfiguration wurde seit der letzten Revision geändert:". \Alexplusde\Wsm\Wsm::getLastChangeTimestamp()." Bitte speichern Sie die Konfiguration erneut.");
//}
echo rex_view::info("Die aktuelle Revisionsnummer lautet: " . \Alexplusde\Wsm\Wsm::getRevisionNumber() ." (". rex_formatter::intlDateTime(\Alexplusde\Wsm\Wsm::getRevisionTimestamp()).").");

$table_name = 'rex_wenns_sein_muss_service';

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
