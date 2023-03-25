<?php

rex_config::removeNamespace("wenns_sein_muss");
if (rex_addon::get('yform')->isAvailable() && !rex::isSafeMode()) {
    rex_yform_manager_table_api::removeTable('wenns_sein_muss_domain');
    rex_yform_manager_table_api::removeTable('wenns_sein_muss_entry');
    rex_yform_manager_table_api::removeTable('wenns_sein_muss_group');
    rex_yform_manager_table_api::removeTable('wenns_sein_muss_service');
    rex_yform_manager_table_api::removeTable('wenns_sein_muss_iframe');
    rex_yform_manager_table_api::removeTable('wenns_sein_muss_protocol');
}
