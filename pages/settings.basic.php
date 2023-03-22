<?php
$addon = rex_addon::get('wenns_sein_muss');

echo rex_view::title($addon->i18n('wenns_sein_muss_title'));

$form = rex_config_form::factory($addon->getName());

$field = $form->addSelectField('auto_lang', null, ['class'=>'form-control selectpicker']);
$field->setLabel($addon->i18n("wsm_config_auto_lang_label"));
$select = $field->getSelect();
$select->addOption('ja', '1');
$select->addOption('nein', '0');

$field = $form->addSelectField('iframemanager', null, ['class'=>'form-control selectpicker']);
$field->setLabel($addon->i18n("wsm_config_iframemanager_label"));
$select = $field->getSelect();
$select->addOption($addon->i18n('wsm_config_iframemanager_active'), '1');
$select->addOption($addon->i18n('wsm_config_iframemanager_inactive'), '0');


$field = $form->addLinkmapField('wsm_domain_imprint_id');
$field->setLabel($addon->i18n("wsm_domain_imprint_id"));

$field = $form->addLinkmapField('wsm_domain_privacy_policy_id');
$field->setLabel($addon->i18n("wsm_domain_privacy_policy_id"));




$fragment = new rex_fragment();
$fragment->setVar('class', 'edit', false);
$fragment->setVar('title', $addon->i18n('wenns_sein_muss_config'), false);
$fragment->setVar('body', $form->get(), false);
echo $fragment->parse('core/page/section.php');
