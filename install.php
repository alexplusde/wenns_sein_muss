<?php

rex_sql_table::get(rex::getTable('wenns_sein_muss_domain'))
    ->ensurePrimaryIdColumn()
    ->removeIndex('domain_id')
    ->ensureColumn(new rex_sql_column('domain_id', 'int(10) unsigned'))
    ->ensureColumn(new rex_sql_column('privacy_policy_id', 'int(10) unsigned'))
    ->ensureColumn(new rex_sql_column('imprint_id', 'int(10) unsigned'))
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
    ->ensureColumn(new rex_sql_column('embedUrl', 'text', false, ''))
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

$addon = rex_addon::get('wenns_sein_muss');
if (rex_addon::get('yform')->isAvailable()) {
    rex_yform_manager_table_api::importTablesets(rex_file::get(__DIR__ . '/install/rex_wenns_sein_muss_domain.json'));
    rex_yform_manager_table_api::importTablesets(rex_file::get(__DIR__ . '/install/rex_wenns_sein_muss_entry.json'));
    rex_yform_manager_table_api::importTablesets(rex_file::get(__DIR__ . '/install/rex_wenns_sein_muss_group.json'));
    rex_yform_manager_table_api::importTablesets(rex_file::get(__DIR__ . '/install/rex_wenns_sein_muss_iframe.json'));
    rex_yform_manager_table_api::importTablesets(rex_file::get(__DIR__ . '/install/rex_wenns_sein_muss_protocol.json'));
    rex_yform_manager_table_api::importTablesets(rex_file::get(__DIR__ . '/install/rex_wenns_sein_muss_service.json'));
    rex_yform_manager_table::deleteCache();
}

rex_config::set('wenns_sein_muss', 'lastchange', date('Y-m-d H:i:s'));

rex_dir::create(rex_path::addonData('wenns_sein_muss'));

/* via rex_sql überprüfen, ob es bereits ein Media Manager Profil gibt - wenn nicht, dann anlegen */
$media_manager_types = rex_sql::factory()->setQuery('SELECT * FROM ' . rex::getTable('media_manager_type'))->getArray();
$profile_exists = false;
foreach ($media_manager_types as $profile) {
    if ($profile['name'] === rex_config::get('wenns_sein_muss', 'media_manager_type')) {
        $profile_exists = true;
        break;
    }
}

if (!$profile_exists) {
    $sql = rex_sql::factory();
    $sql->setTable(rex::getTable('media_manager_type'));
    $sql->setValue('name', 'wenns_sein_muss');
    $sql->setValue('status', 0);
    $sql->setValue('description', '');
    $sql->setValue('createdate', date('Y-m-d H:i:s'));
    $sql->setValue('createuser', 'wenns_sein_muss');
    $sql->setValue('updatedate', date('Y-m-d H:i:s'));
    $sql->setValue('updateuser', 'wenns_sein_muss');
    $sql->insert();

    /* ID des letzten Datensatzes ermitteln */
    $profile_id = rex_sql::factory()->getLastId();

    $sql = rex_sql::factory();
    $sql->setTable(rex::getTable('media_manager_type_effect'));
    $sql->setValue('type_id', $profile_id);
    $sql->setValue('effect', 'mediapath');
    $sql->setValue('parameters', '{"rex_effect_rounded_corners":{"rex_effect_rounded_corners_topleft":"","rex_effect_rounded_corners_topright":"","rex_effect_rounded_corners_bottomleft":"","rex_effect_rounded_corners_bottomright":""},"rex_effect_workspace":{"rex_effect_workspace_set_transparent":"colored","rex_effect_workspace_width":"","rex_effect_workspace_height":"","rex_effect_workspace_hpos":"left","rex_effect_workspace_vpos":"top","rex_effect_workspace_padding_x":"0","rex_effect_workspace_padding_y":"0","rex_effect_workspace_bg_r":"","rex_effect_workspace_bg_g":"","rex_effect_workspace_bg_b":"","rex_effect_workspace_bgimage":""},"rex_effect_crop":{"rex_effect_crop_width":"","rex_effect_crop_height":"","rex_effect_crop_offset_width":"","rex_effect_crop_offset_height":"","rex_effect_crop_hpos":"center","rex_effect_crop_vpos":"middle"},"rex_effect_insert_image":{"rex_effect_insert_image_brandimage":"","rex_effect_insert_image_hpos":"left","rex_effect_insert_image_vpos":"top","rex_effect_insert_image_padding_x":"-10","rex_effect_insert_image_padding_y":"-10"},"rex_effect_rotate":{"rex_effect_rotate_rotate":"0"},"rex_effect_filter_colorize":{"rex_effect_filter_colorize_filter_r":"","rex_effect_filter_colorize_filter_g":"","rex_effect_filter_colorize_filter_b":""},"rex_effect_image_properties":{"rex_effect_image_properties_jpg_quality":"","rex_effect_image_properties_png_compression":"","rex_effect_image_properties_webp_quality":"","rex_effect_image_properties_avif_quality":"","rex_effect_image_properties_avif_speed":"","rex_effect_image_properties_interlace":null},"rex_effect_filter_brightness":{"rex_effect_filter_brightness_brightness":""},"rex_effect_flip":{"rex_effect_flip_flip":"X"},"rex_effect_image_format":{"rex_effect_image_format_convert_to":"webp"},"rex_effect_filter_contrast":{"rex_effect_filter_contrast_contrast":""},"rex_effect_filter_sharpen":{"rex_effect_filter_sharpen_amount":"80","rex_effect_filter_sharpen_radius":"0.5","rex_effect_filter_sharpen_threshold":"3"},"rex_effect_resize":{"rex_effect_resize_width":"","rex_effect_resize_height":"","rex_effect_resize_style":"maximum","rex_effect_resize_allow_enlarge":"enlarge"},"rex_effect_filter_blur":{"rex_effect_filter_blur_repeats":"10","rex_effect_filter_blur_type":"gaussian","rex_effect_filter_blur_smoothit":""},"rex_effect_mirror":{"rex_effect_mirror_height":"","rex_effect_mirror_opacity":"100","rex_effect_mirror_set_transparent":"colored","rex_effect_mirror_bg_r":"","rex_effect_mirror_bg_g":"","rex_effect_mirror_bg_b":""},"rex_effect_header":{"rex_effect_header_download":"open_media","rex_effect_header_cache":"no_cache","rex_effect_header_filename":"filename","rex_effect_header_index":"index"},"rex_effect_convert2img":{"rex_effect_convert2img_convert_to":"jpg","rex_effect_convert2img_density":"150","rex_effect_convert2img_color":""},"rex_effect_mediapath":{"rex_effect_mediapath_mediapath":"..\\/var\\/data\\/addons\\/wenns_sein_muss"}}');
    $sql->setValue('priority', 1);
    $sql->setValue('createdate', date('Y-m-d H:i:s'));
    $sql->setValue('createuser', 'wenns_sein_muss');
    $sql->setValue('updatedate', date('Y-m-d H:i:s'));
    $sql->setValue('updateuser', 'wenns_sein_muss');
    $sql->insert();
}
