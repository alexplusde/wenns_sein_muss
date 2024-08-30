<?php

rex_sql_table::get(rex::getTable('wenns_sein_muss_domain'))
    ->ensurePrimaryIdColumn()
    ->ensureColumn(new rex_sql_column('domain_id', 'text'))
    ->ensureColumn(new rex_sql_column('privacy_policy_id', 'text'))
    ->ensureColumn(new rex_sql_column('imprint_id', 'text'))
    ->ensure();

rex_sql_table::get(rex::getTable('wenns_sein_muss_entry'))
    ->ensurePrimaryIdColumn()
    ->ensureColumn(new rex_sql_column('type', 'text'))
    ->ensureColumn(new rex_sql_column('name', 'varchar(191)', false, ''))
    ->ensureColumn(new rex_sql_column('duration', 'varchar(191)', false, ''))
    ->ensureColumn(new rex_sql_column('description', 'text'))
    ->ensureColumn(new rex_sql_column('service_id', 'int(11)'))
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
    ->ensureColumn(new rex_sql_column('key', 'varchar(191)', false, ''))
    ->ensureColumn(new rex_sql_column('embedUrl', 'varchar(191)', false, ''))
    ->ensure();

rex_sql_table::get(rex::getTable('wenns_sein_muss_protocol'))
    ->ensurePrimaryIdColumn()
    ->ensureColumn(new rex_sql_column('url', 'varchar(191)', false, ''))
    ->ensureColumn(new rex_sql_column('consent_id', 'varchar(191)', false, ''))
    ->ensureColumn(new rex_sql_column('accept_type', 'varchar(191)', false, ''))
    ->ensureColumn(new rex_sql_column('accepted_categories', 'varchar(191)', false, ''))
    ->ensureColumn(new rex_sql_column('accepted_services', 'varchar(191)', false, ''))
    ->ensureColumn(new rex_sql_column('rejected_categories', 'varchar(191)', false, ''))
    ->ensureColumn(new rex_sql_column('rejected_services', 'varchar(191)', false, ''))
    ->ensureColumn(new rex_sql_column('consentdate', 'datetime'))
    ->ensure();

rex_sql_table::get(rex::getTable('wenns_sein_muss_service'))
    ->ensurePrimaryIdColumn()
    ->ensureColumn(new rex_sql_column('group', 'int(11)'))
    ->ensureColumn(new rex_sql_column('service', 'varchar(191)', false, ''))
    ->ensureColumn(new rex_sql_column('company_name', 'varchar(191)', false, ''))
    ->ensureColumn(new rex_sql_column('company_address', 'varchar(191)', false, ''))
    ->ensureColumn(new rex_sql_column('privacy_policy_url', 'varchar(191)', false, ''))
    ->ensureColumn(new rex_sql_column('iframe', 'int(11)'))
    ->ensureColumn(new rex_sql_column('rex_domain', 'text'))
    ->ensureColumn(new rex_sql_column('script', 'text'))
    ->ensureColumn(new rex_sql_column('updatedate', 'datetime'))
    ->ensure();


/* Tablesets aktualisieren */

$addon = rex_addon::get("wenns_sein_muss");
if (rex_addon::get('yform')->isAvailable() && !rex::isSafeMode()) {

    rex_yform_manager_table_api::importTablesets((string)rex_file::get(rex_path::addon($addon->getName(), 'install/rex_wenns_sein_muss.tableset.json')));

    rex_yform_manager_table::deleteCache();
}
