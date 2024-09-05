<?php

$addon = rex_addon::get('wenns_sein_muss');

echo rex_view::title($addon->i18n('wsm_title'));

$form = rex_config_form::factory($addon->getName());

$field = $form->addInputField('text', 'iframe_notice', null, ['class' => 'form-control']);
$field->setLabel($addon->i18n('iframe_notice'));

$field = $form->addInputField('text', 'iframe_notice_more', null, ['class' => 'form-control']);
$field->setLabel($addon->i18n('iframe_notice_more'));

$field = $form->addInputField('text', 'iframe_load_btn', null, ['class' => 'form-control']);
$field->setLabel($addon->i18n('iframe_load_btn'));

$field = $form->addInputField('text', 'iframe_load_all_btn', null, ['class' => 'form-control']);
$field->setLabel($addon->i18n('iframe_load_all_btn'));

$fragment = new rex_fragment();
$fragment->setVar('class', 'edit', false);
$fragment->setVar('title', $addon->i18n('wsm_config'), false);
$fragment->setVar('body', $form->get(), false);
echo $fragment->parse('core/page/section.php');
