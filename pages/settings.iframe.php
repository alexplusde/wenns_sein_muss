<?php

echo rex_view::title(rex_i18n::msg('wenns_sein_muss_title'));

$addon = rex_addon::get('wenns_sein_muss');

$form = rex_config_form::factory($addon->name);

$field = $form->addInputField('text', 'iframe_notice', null, ["class" => "form-control"]);
$field->setLabel(rex_i18n::msg('iframe_notice'));

$field = $form->addInputField('text', 'iframe_load_btn', null, ["class" => "form-control"]);
$field->setLabel(rex_i18n::msg('iframe_load_btn'));

$field = $form->addInputField('text', 'iframe_load_all_btn', null, ["class" => "form-control"]);
$field->setLabel(rex_i18n::msg('iframe_load_all_btn'));

$fragment = new rex_fragment();
$fragment->setVar('class', 'edit', false);
$fragment->setVar('title', $addon->i18n('wenns_sein_muss_config'), false);
$fragment->setVar('body', $form->get(), false);
echo $fragment->parse('core/page/section.php');
