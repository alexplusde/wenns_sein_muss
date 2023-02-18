<?php

echo rex_view::title(rex_i18n::msg('wenns_sein_muss_title'));

$addon = rex_addon::get('wenns_sein_muss');

$form = rex_config_form::factory($addon->getName());

$field = $form->addSelectField('auto_lang', null, ['class'=>'form-control selectpicker']);
$field->setLabel("wsm_config_auto_lang_label");
$select = $field->getSelect();
$select->addOption('ja', '1');
$select->addOption('nein', '0');

$field = $form->addSelectField('iframemanager', null, ['class'=>'form-control selectpicker']);
$field->setLabel("wsm_config_iframemanager_label");
$select = $field->getSelect();
$select->addOption('aktiviert', '1');
$select->addOption('deaktiviert', '0');

$fragment = new rex_fragment();
$fragment->setVar('class', 'edit', false);
$fragment->setVar('title', $addon->i18n('wenns_sein_muss_config'), false);
$fragment->setVar('body', $form->get(), false);
echo $fragment->parse('core/page/section.php');
