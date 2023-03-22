<?php

rex_config::removeNamespace("wenns_sein_muss");
if (rex_addon::get('yform')->isAvailable() && !rex::isSafeMode()) {
    //  rex_sql::factory()->setQuery('DELETE FROM ' . rex_yform_manager_table::table() . ' where table_name="rex_wenns_sein_muss"');
    // rex_yform_manager_table::deleteCache();
}
