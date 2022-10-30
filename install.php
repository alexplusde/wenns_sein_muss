<?php
/* Tablesets aktualisieren */

$addon = rex_addon::get("wenns_sein_muss");
if (rex_addon::get('yform')->isAvailable() && !rex::isSafeMode()) {
    rex_yform_manager_table_api::importTablesets((string)rex_file::get(rex_path::addon($addon->getName(), 'install/rex_wenns_sein_muss.tableset.json')));
    rex_yform_manager_table::deleteCache();
}
