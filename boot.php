<?php

namespace Alexplusde\Wsm;

use rex;
use rex_addon;
use rex_api_function;
use rex_be_controller;
use rex_extension;
use rex_yform_manager_dataset;

use function in_array;
use function is_array;

if (rex_addon::get('yform')->isAvailable() && !rex::isSafeMode()) {
    rex_yform_manager_dataset::setModelClass(
        'rex_wenns_sein_muss_service',
        Service::class,
    );
    rex_yform_manager_dataset::setModelClass(
        'rex_wenns_sein_muss_group',
        Group::class,
    );
    rex_yform_manager_dataset::setModelClass(
        'rex_wenns_sein_muss_entry',
        Entry::class,
    );
    rex_yform_manager_dataset::setModelClass(
        'rex_wenns_sein_muss_protocol',
        Protocol::class,
    );
    rex_yform_manager_dataset::setModelClass(
        'rex_wenns_sein_muss_iframe',
        Iframe::class,
    );
    rex_yform_manager_dataset::setModelClass(
        'rex_wenns_sein_muss_domain',
        Domain::class,
    );
}

if (!rex_addon::get('yrewrite')->isAvailable()) {
    $addon = rex_addon::get('wenns_sein_muss');
    $pages = $addon->getProperty('pages');
    if (is_array($pages) && isset($pages['domain']['hidden'])) {
        $pages['domain']['hidden'] = true;
    }
    $addon->setProperty('pages', $pages);
}

rex_extension::register('YFORM_DATA_ADDED', Wsm::yformDataChanged(...));
rex_extension::register('YFORM_DATA_UPDATED', Wsm::yformDataChanged(...));
rex_extension::register('YFORM_DATA_DELETED', Wsm::yformDataChanged(...));

/**
 * nur im Frontend.
 */
if (rex::isFrontend()) {
    rex_api_function::register('wsm', ApiWsm::class);
    rex_api_function::register('iframe', ApiWsmIframe::class);
    return;
}

/**
 * nur im Backend.
 */
if (in_array(rex_be_controller::getCurrentPagePart(1), ['yform', 'wenns_sein_muss'])) {
    rex_extension::register('YFORM_DATA_LIST', Service::epYformDataList(...));
    rex_extension::register('YFORM_DATA_LIST', Group::epYformDataList(...));
    rex_extension::register('YFORM_DATA_LIST', Protocol::epYformDataList(...));
    rex_extension::register('YFORM_DATA_LIST', Iframe::epYformDataList(...));
    rex_extension::register('YFORM_DATA_LIST', Domain::epYformDataList(...));
}

if (Wsm::getConfig('first_run', 'bool', true)) {
    Wsm::InitOnFirstBoot();
}
