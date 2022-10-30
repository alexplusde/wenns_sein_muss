<?php

echo rex_view::title(rex_i18n::msg('wenns_sein_muss_title'));

$addon = rex_addon::get('wenns_sein_muss');

$form = rex_config_form::factory($addon->getName());

$field = $form->addSelectField('consent_modal_layout', null, ['class'=>'form-control selectpicker']);
$field->setLabel("consent_modal_layout");
$select = $field->getSelect();
$select->addOption('cloud', 'cloud');
$select->addOption('box', 'box');
$select->addOption('bar', 'bar');


$field = $form->addSelectField('consent_modal_position', null, ['class'=>'form-control selectpicker']);
$field->setLabel("consent_modal_position");
$select = $field->getSelect();
$select->addOption('bottom left', 'bottom left');
$select->addOption('bottom middle', 'bottom middle');
$select->addOption('bottom right', 'bottom right');
$select->addOption('middle left', 'middle left');
$select->addOption('middle middle', 'middle middle');
$select->addOption('middle right', 'middle right');
$select->addOption('top left', 'top left');
$select->addOption('top middle', 'top middle');
$select->addOption('top right', 'top right');

$field = $form->addSelectField('consent_modal_transition', null, ['class'=>'form-control selectpicker']);
$field->setLabel("consent_modal_transition");
$select = $field->getSelect();
$select->addOption('slide', 'slide');
$select->addOption('zoom', 'zoom');

$field = $form->addSelectField('consent_modal_swap_buttons', null, ['class'=>'form-control selectpicker']);
$field->setLabel("consent_modal_swap_buttons");
$select = $field->getSelect();
$select->addOption('invert buttons', '1');
$select->addOption('do not invert buttons', '0');

$field = $form->addSelectField('settings_modal_layout', null, ['class'=>'form-control selectpicker']);
$field->setLabel("settings_modal_layout");
$select = $field->getSelect();
$select->addOption('box', 'box');
$select->addOption('bar', 'bar');

$field = $form->addSelectField('settings_modal_transition', null, ['class'=>'form-control selectpicker']);
$field->setLabel("settings_modal_transition");
$select = $field->getSelect();
$select->addOption('slide', 'slide');
$select->addOption('zoom', 'zoom');

$fragment = new rex_fragment();
$fragment->setVar('class', 'edit', false);
$fragment->setVar('title', $addon->i18n('wenns_sein_muss_config'), false);
$fragment->setVar('body', $form->get(), false);
echo $fragment->parse('core/page/section.php');
