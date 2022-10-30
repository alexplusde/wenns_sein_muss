<?php
#
$addon = rex_addon::get('wenns_sein_muss');

$form = rex_config_form::factory($addon->name);

$field = $form->addInputField('text', 'privacy_policy_id', null, ["class" => "form-control"]);
$field->setLabel(rex_i18n::msg('wsm_config_privacy_policy_id_label'));
$field->setNotice(rex_i18n::msg('wsm_config_privacy_policy_id_notice'));

$field = $form->addInputField('text', 'imprint_id', null, ["class" => "form-control"]);
$field->setLabel(rex_i18n::msg('wsm_config_imprint_id_label'));
$field->setNotice(rex_i18n::msg('wsm_config_imprint_id_notice'));

$field = $form->addInputField('text', 'auto_lang', null, ["class" => "form-control"]);
$field->setLabel(rex_i18n::msg('wsm_config_auto_lang_label'));
$field->setNotice(rex_i18n::msg('wsm_config_auto_lang_notice'));

$fragment = new rex_fragment();
$fragment->setVar('class', 'edit', false);
$fragment->setVar('title', $addon->i18n('wenns_sein_muss_config'), false);
$fragment->setVar('body', $form->get(), false);
echo $fragment->parse('core/page/section.php');
