<?php
#
$addon = rex_addon::get('wenns_sein_muss');


$form = rex_config_form::factory($addon->name);

$field = $form->addInputField('text', 'consent_modal_title', null, ["class" => "form-control"]);
$field->setLabel(rex_i18n::msg('consent_modal_title'));

$field = $form->addInputField('text', 'consent_modal_description', null, ["class" => "form-control"]);
$field->setLabel(rex_i18n::msg('consent_modal_description'));

$field = $form->addInputField('text', 'consent_modail_primary_btn', null, ["class" => "form-control"]);
$field->setLabel(rex_i18n::msg('consent_modail_primary_btn'));

$field = $form->addInputField('text', 'consent_modal_secondary_btn', null, ["class" => "form-control"]);
$field->setLabel(rex_i18n::msg('consent_modal_secondary_btn'));

$field = $form->addInputField('text', 'settings_modal_title', null, ["class" => "form-control"]);
$field->setLabel(rex_i18n::msg('settings_modal_title'));

$field = $form->addInputField('text', 'settings_modal_save_settigns_btn', null, ["class" => "form-control"]);
$field->setLabel(rex_i18n::msg('settings_modal_save_settigns_btn'));

$field = $form->addInputField('text', 'settings_modal_accept_all_btn', null, ["class" => "form-control"]);
$field->setLabel(rex_i18n::msg('settings_modal_accept_all_btn'));

$field = $form->addInputField('text', 'settings_modal_reject_all_btn', null, ["class" => "form-control"]);
$field->setLabel(rex_i18n::msg('settings_modal_reject_all_btn'));

$field = $form->addInputField('text', 'settings_modal_close_btn_label', null, ["class" => "form-control"]);
$field->setLabel(rex_i18n::msg('settings_modal_close_btn_label'));

$field = $form->addInputField('text', 'settings_modal_cookie_table_headers_col1', null, ["class" => "form-control"]);
$field->setLabel(rex_i18n::msg('settings_modal_cookie_table_headers_col1'));
$field = $form->addInputField('text', 'settings_modal_cookie_table_headers_col2', null, ["class" => "form-control"]);
$field->setLabel(rex_i18n::msg('settings_modal_cookie_table_headers_col2'));
$field = $form->addInputField('text', 'settings_modal_cookie_table_headers_col3', null, ["class" => "form-control"]);
$field->setLabel(rex_i18n::msg('settings_modal_cookie_table_headers_col3'));
$field = $form->addInputField('text', 'settings_modal_cookie_table_headers_col4', null, ["class" => "form-control"]);
$field->setLabel(rex_i18n::msg('settings_modal_cookie_table_headers_col4'));

$field = $form->addInputField('text', 'settings_modal_block_more_title', null, ["class" => "form-control"]);
$field->setLabel(rex_i18n::msg('settings_modal_block_more_title'));

$field = $form->addInputField('text', 'settings_modal_block_more_description', null, ["class" => "form-control"]);
$field->setLabel(rex_i18n::msg('settings_modal_block_more_description'));

$fragment = new rex_fragment();
$fragment->setVar('class', 'edit', false);
$fragment->setVar('title', $addon->i18n('wenns_sein_muss_config'), false);
$fragment->setVar('body', $form->get(), false);
echo $fragment->parse('core/page/section.php');
