<?php

rex_sql_table::get(rex::getTable('wenns_sein_muss_domain'))
    ->ensurePrimaryIdColumn()
    ->ensureColumn(new rex_sql_column('domain_id', 'int(11)'))
    ->ensureColumn(new rex_sql_column('privacy_policy_id', 'int(11)'))
    ->ensureColumn(new rex_sql_column('imprint_id', 'int(11)'))
    ->ensureIndex(new rex_sql_index('domain_id', ['domain_id'], rex_sql_index::UNIQUE))
    ->ensure();

rex_sql_table::get(rex::getTable('wenns_sein_muss_entry'))
    ->ensurePrimaryIdColumn()
    ->ensureColumn(new rex_sql_column('type', 'varchar(191)'))
    ->ensureColumn(new rex_sql_column('name', 'varchar(191)', false, ''))
    ->ensureColumn(new rex_sql_column('duration', 'varchar(191)', false, ''))
    ->ensureColumn(new rex_sql_column('description', 'text'))
    ->ensureColumn(new rex_sql_column('service_id', 'int(10) unsigned'))
    ->ensureIndex(new rex_sql_index('service_id', ['service_id']))
    ->ensure();

rex_sql_table::get(rex::getTable('wenns_sein_muss_group'))
    ->ensurePrimaryIdColumn()
    ->ensureColumn(new rex_sql_column('prio', 'int(11)'))
    ->ensureColumn(new rex_sql_column('name', 'varchar(191)', false, ''))
    ->ensureColumn(new rex_sql_column('title', 'varchar(191)', false, ''))
    ->ensureColumn(new rex_sql_column('description', 'text'))
    ->ensureColumn(new rex_sql_column('enabled', 'tinyint(1)', false, '0'))
    ->ensureColumn(new rex_sql_column('required', 'tinyint(1)', false, '0'))
    ->ensure();

rex_sql_table::get(rex::getTable('wenns_sein_muss_iframe'))
    ->ensurePrimaryIdColumn()
    ->ensureColumn(new rex_sql_column('embedUrl', 'text', false, '\'\''))
    ->ensureColumn(new rex_sql_column('key', 'varchar(191)', false, ''))
    ->ensure();

rex_sql_table::get(rex::getTable('wenns_sein_muss_protocol'))
    ->ensurePrimaryIdColumn()
    ->ensureColumn(new rex_sql_column('url', 'varchar(191)', false, ''))
    ->ensureColumn(new rex_sql_column('consent_id', 'varchar(191)', false, ''))
    ->ensureColumn(new rex_sql_column('accept_type', 'varchar(191)', false, ''))
    ->ensureColumn(new rex_sql_column('revision', 'datetime'))
    ->ensureColumn(new rex_sql_column('accepted_categories', 'varchar(191)', false, ''))
    ->ensureColumn(new rex_sql_column('accepted_services', 'varchar(191)', false, ''))
    ->ensureColumn(new rex_sql_column('rejected_categories', 'varchar(191)', false, ''))
    ->ensureColumn(new rex_sql_column('rejected_services', 'varchar(191)', false, ''))
    ->ensureColumn(new rex_sql_column('consentdate', 'datetime'))
    ->ensureIndex(new rex_sql_index('consent_id', ['consent_id']))
    ->ensure();

rex_sql_table::get(rex::getTable('wenns_sein_muss_service'))
    ->ensurePrimaryIdColumn()
    ->ensureColumn(new rex_sql_column('group', 'int(10) unsigned'))
    ->ensureColumn(new rex_sql_column('service', 'varchar(191)', false, ''))
    ->ensureColumn(new rex_sql_column('company_name', 'varchar(191)', false, ''))
    ->ensureColumn(new rex_sql_column('company_address', 'varchar(191)', false, ''))
    ->ensureColumn(new rex_sql_column('privacy_policy_url', 'varchar(191)', false, ''))
    ->ensureColumn(new rex_sql_column('iframe', 'int(10) unsigned'))
    ->ensureColumn(new rex_sql_column('rex_domain', 'varchar(191)'))
    ->ensureColumn(new rex_sql_column('script', 'text'))
    ->ensureColumn(new rex_sql_column('updatedate', 'datetime'))
    ->ensureColumn(new rex_sql_column('status', 'tinyint(1)'))
    ->ensureIndex(new rex_sql_index('group', ['group']))
    ->ensure();

/* Tablesets aktualisieren */

$addon = rex_addon::get("wenns_sein_muss");
if (rex_addon::get('yform')->isAvailable() && !rex::isSafeMode()) {
    rex_yform_manager_table_api::importTablesets((string)rex_file::get(rex_path::addon($addon->getName(), 'install/rex_wenns_sein_muss_domain.tableset.json')));
    rex_yform_manager_table_api::importTablesets((string)rex_file::get(rex_path::addon($addon->getName(), 'install/rex_wenns_sein_muss_entry.tableset.json')));
    rex_yform_manager_table_api::importTablesets((string)rex_file::get(rex_path::addon($addon->getName(), 'install/rex_wenns_sein_muss_group.tableset.json')));
    rex_yform_manager_table_api::importTablesets((string)rex_file::get(rex_path::addon($addon->getName(), 'install/rex_wenns_sein_muss_iframe.tableset.json')));
    rex_yform_manager_table_api::importTablesets((string)rex_file::get(rex_path::addon($addon->getName(), 'install/rex_wenns_sein_muss_protocol.tableset.json')));
    rex_yform_manager_table_api::importTablesets((string)rex_file::get(rex_path::addon($addon->getName(), 'install/rex_wenns_sein_muss_service.tableset.json')));
    rex_yform_manager_table::deleteCache();
}
