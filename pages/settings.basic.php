<?php
$addon = rex_addon::get('wenns_sein_muss');

echo rex_view::title($addon->i18n('wenns_sein_muss_title'));

if(rex_get('func', 'string') !== 'edit') {
    
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

}

if (!rex_addon::get('yrewrite')->isAvailable() || count(rex_yrewrite::getDomains()) < 2) {
    echo rex_view::error(rex_i18n::rawMsg('wenns_sein_muss_error_no_domains', '<a href="'.rex_url::backendPage('wenns_sein_muss/settings/basic').'">WSM Einstellungen</a>'));
}

$table_name = 'rex_wenns_sein_muss_domain';

\rex_extension::register(
    'YFORM_MANAGER_DATA_PAGE_HEADER',
    function (\rex_extension_point $ep) {
        if ($ep->getParam('yform')->table->getTableName() === $ep->getParam('table_name')) {
            return '';
        }
    },
    \rex_extension::EARLY,
    ['table_name'=>$table_name]
);

// @phpstan-ignore-next-line
$_REQUEST['table_name'] = $table_name;

include \rex_path::plugin('yform', 'manager', 'pages/data_edit.php');
