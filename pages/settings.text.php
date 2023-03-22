<?php
$addon = rex_addon::get('wenns_sein_muss');

echo rex_view::title($addon->i18n('wenns_sein_muss_title'));

$form = rex_config_form::factory($addon->getName());

$form->addFieldset($addon->i18n('consent_modal'));

$field = $form->addInputField('text', 'consent_modal_title', $value = null, ["class" => "form-control"]);
$field->setLabel($addon->i18n('consent_modal_title'));

$field = $form->addInputField('text', 'consent_modal_description', $value = null, ["class" => "form-control"]);
$field->setLabel($addon->i18n('consent_modal_description'));

$field = $form->addInputField('text', 'consent_modal_settings', $value = null, ["class" => "form-control"]);
$field->setLabel($addon->i18n('consent_modal_settings'));

$field = $form->addInputField('text', 'consent_modal_accept_all', $value = null, ["class" => "form-control"]);
$field->setLabel($addon->i18n('consent_modal_accept_all'));

$field = $form->addInputField('text', 'consent_modal_accept_necessary', $value = null, ["class" => "form-control"]);
$field->setLabel($addon->i18n('consent_modal_accept_necessary'));

$form->addFieldset($addon->i18n('consent_settings'));

$field = $form->addInputField('text', 'consent_settings_title', $value = null, ["class" => "form-control"]);
$field->setLabel($addon->i18n('consent_settings_title'));

$field = $form->addInputField('text', 'consent_settings_save', $value = null, ["class" => "form-control"]);
$field->setLabel($addon->i18n('consent_settings_save'));

$field = $form->addInputField('text', 'consent_settings_accept_all', $value = null, ["class" => "form-control"]);
$field->setLabel($addon->i18n('consent_settings_accept_all'));

$field = $form->addInputField('text', 'consent_settings_reject_all', $value = null, ["class" => "form-control"]);
$field->setLabel($addon->i18n('consent_settings_reject_all'));

$field = $form->addInputField('text', 'consent_settings_close', $value = null, ["class" => "form-control"]);
$field->setLabel($addon->i18n('consent_settings_close'));

$field = $form->addInputField('text', 'consent_settings_service_counter_badge', $value = null, ["class" => "form-control"]);
$field->setLabel($addon->i18n('consent_settings_service_counter_badge'));

$field = $form->addInputField('text', 'consent_settings_cookie_table_headers_col1', $value = null, ["class" => "form-control"]);
$field->setLabel($addon->i18n('consent_settings_cookie_table_headers_col1'));
$field = $form->addInputField('text', 'consent_settings_cookie_table_headers_col2', $value = null, ["class" => "form-control"]);
$field->setLabel($addon->i18n('consent_settings_cookie_table_headers_col2'));
$field = $form->addInputField('text', 'consent_settings_cookie_table_headers_col3', $value = null, ["class" => "form-control"]);
$field->setLabel($addon->i18n('consent_settings_cookie_table_headers_col3'));
$field = $form->addInputField('text', 'consent_settings_cookie_table_headers_col4', $value = null, ["class" => "form-control"]);
$field->setLabel($addon->i18n('consent_settings_cookie_table_headers_col4'));

$field = $form->addInputField('text', 'consent_info_more', $value = null, ["class" => "form-control"]);
$field->setLabel($addon->i18n('consent_info_more'));


$form->addFieldset($addon->i18n('consent_open'));

$field = $form->addInputField('text', 'consent_modal_open', $value = null, ["class" => "form-control"]);
$field->setLabel($addon->i18n('consent_modal_open'));

$field = $form->addInputField('text', 'consent_settings_open', $value = null, ["class" => "form-control"]);
$field->setLabel($addon->i18n('consent_settings_open'));

$form->addFieldset('Einwilligungs-Protokoll');

$field = $form->addInputField('text', 'consent_info_domain', $value = null, ["class" => "form-control"]);
$field->setLabel($addon->i18n('consent_info_domain'));

$field = $form->addInputField('text', 'consent_info_uuid', $value = null, ["class" => "form-control"]);
$field->setLabel($addon->i18n('consent_info_uuid'));

$field = $form->addInputField('text', 'consent_info_datestamp', $value = null, ["class" => "form-control"]);
$field->setLabel($addon->i18n('consent_info_datestamp'));

$field = $form->addInputField('text', 'consent_info_update_datestamp', $value = null, ["class" => "form-control"]);
$field->setLabel($addon->i18n('consent_info_update_datestamp'));

$field = $form->addInputField('text', 'consent_info_unknown', $value = null, ["class" => "form-control"]);
$field->setLabel($addon->i18n('consent_info_unknown'));

$fragment = new rex_fragment();
$fragment->setVar('class', 'edit', false);
$fragment->setVar('title', $addon->i18n('wenns_sein_muss_config'), false);
$fragment->setVar('body', $form->get(), false);
echo $fragment->parse('core/page/section.php');
