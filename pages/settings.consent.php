<?php

$addon = rex_addon::get('wenns_sein_muss');

echo rex_view::title($addon->i18n('wsm_title'));

$form = rex_config_form::factory($addon->getName());

$field = $form->addSelectField('consent_modal_layout', null, ['class' => 'form-control selectpicker']);
$field->setLabel($addon->i18n('consent_modal_layout'));
$select = $field->getSelect();
$select->addOption('cloud', 'cloud');
$select->addOption('cloud-inline', 'cloud-inline');
$select->addOption('box', 'box');
$select->addOption('box-inline', 'box-inline');
$select->addOption('box-wide', 'box-wide');
$select->addOption('bar', 'bar');
$select->addOption('bar-inline', 'bar-inline');

$field = $form->addSelectField('consent_modal_position', null, ['class' => 'form-control selectpicker']);
$field->setLabel($addon->i18n('consent_modal_position'));
$select = $field->getSelect();
$select->addOption('bottom left', 'bottom left');
$select->addOption('bottom center', 'bottom center');
$select->addOption('bottom right', 'bottom right');
$select->addOption('middle left', 'middle left');
$select->addOption('middle center', 'middle center');
$select->addOption('middle right', 'middle right');
$select->addOption('top left', 'top left');
$select->addOption('top center', 'top center');
$select->addOption('top right', 'top right');

$field = $form->addSelectField('consent_modal_swap_buttons', null, ['class' => 'form-control selectpicker']);
$field->setLabel($addon->i18n('consent_modal_swap_buttons'));
$select = $field->getSelect();
$select->addOption('invert buttons', 1);
$select->addOption('do not invert buttons', 0);

$field = $form->addSelectField('consent_modal_equal_weight_buttons', null, ['class' => 'form-control selectpicker']);
$field->setLabel($addon->i18n('consent_modal_equal_weight_buttons'));
$select = $field->getSelect();
$select->addOption($addon->i18n('consent_modal_equal_weight_buttons_yes'), 1);
$select->addOption($addon->i18n('consent_modal_equal_weight_buttons_no'), 0);

$field = $form->addSelectField('consent_settings_layout', null, ['class' => 'form-control selectpicker']);
$field->setLabel($addon->i18n('consent_settings_layout'));
$select = $field->getSelect();
$select->addOption('box', 'box');
$select->addOption('bar', 'bar');

$field = $form->addSelectField('consent_settings_position', null, ['class' => 'form-control selectpicker']);
$field->setLabel($addon->i18n('consent_settings_position'));
$select = $field->getSelect();
$select->addOption('left', 'left');
$select->addOption('right', 'right');

$field = $form->addSelectField('disable_page_interaction', null, ['class' => 'form-control selectpicker']);
$field->setLabel($addon->i18n('disable_page_interaction'));
$select = $field->getSelect();
$select->addOption('disable page interaction', '1');
$select->addOption('enable page interaction', '0');

$fragment = new rex_fragment();
$fragment->setVar('class', 'edit', false);
$fragment->setVar('title', $addon->i18n('wsm_config'), false);
$fragment->setVar('body', $form->get(), false);
echo $fragment->parse('core/page/section.php');
