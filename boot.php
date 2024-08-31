<?php

namespace Alexplusde\Wsm;

use rex;
use rex_article;
use rex_extension;
use rex_addon;
use rex_list;
use rex_yform_manager_table;
use rex_yform_manager_dataset;

if (rex_addon::get('yform')->isAvailable() && !rex::isSafeMode()) {
    rex_yform_manager_dataset::setModelClass(
        'rex_wenns_sein_muss_service',
        Service::class
    );
    rex_yform_manager_dataset::setModelClass(
        'rex_wenns_sein_muss_group',
        Group::class
    );
    rex_yform_manager_dataset::setModelClass(
        'rex_wenns_sein_muss_entry',
        Entry::class
    );
    rex_yform_manager_dataset::setModelClass(
        'rex_wenns_sein_muss_protocol',
        Protocol::class
    );
    rex_yform_manager_dataset::setModelClass(
        'rex_wenns_sein_muss_iframe',
        Iframe::class
    );
    rex_yform_manager_dataset::setModelClass(
        'rex_wenns_sein_muss_domain',
        Domain::class
    );
};

if(!rex_addon::get('yrewrite')->isAvailable()) {
    $addon = rex_addon::get('wenns_sein_muss');
    $pages = $addon->getProperty('pages');
    if (is_array($pages) && isset($pages['domain']['hidden'])) {
        $pages['domain']['hidden'] = true;
    }
    $addon->setProperty('pages', $pages);
}

// rex_extension::register('YFORM_DATA_ADDED', ['wsm','yform_data_added']);
// rex_extension::register('YFORM_DATA_UPDATED', ['wsm','yform_data_added']);
rex_extension::register('YFORM_DATA_DELETED', ['Alexplusde\Wsm\Wsm', 'yformDataDeleted']);

if(rex::isFrontend()) {
    \rex_api_function::register('wsm', ApiWsm::class);
    \rex_api_function::register('iframe', ApiWsmIframe::class);

}


if (rex::isBackend()) {
    rex_extension::register('YFORM_DATA_LIST', function (\rex_extension_point $ep) {
        $table = $ep->getParam('table');
        /** @var rex_yform_manager_table $table */
        if ($table->getTableName() === "rex_wenns_sein_muss_service") {
            $list = $ep->getSubject();
            /** @var rex_list $list */

            $list->setColumnPosition('script', 3);
            $list->setColumnLabel('script', 'JS');
            $list->setColumnFormat(
                'script',
                'custom',
                function ($a) {
                    if ($a['list']->getValue('script') !== "") {
                        return '<i class="fa fa-code"></i>';
                    } else {
                        return "";
                    }
                }
            );

            $list->setColumnPosition('iframe', 4);
            $list->setColumnLabel('iframe', 'IM');
            $list->setColumnFormat(
                'iframe',
                'custom',
                function ($a) {
                    if ($a['list']->getValue('iframe') > 0) {
                        return '<i class="fa fa-play-circle-o"></i>';
                    } else {
                        return "";
                    }
                }
            );

            $list->setColumnPosition('entry_ids', 5);
            $list->setColumnLabel('entry_ids', '🍪');
            $list->setColumnFormat(
                'entry_ids',
                'custom',
                function ($a) {
                    $count = count(Entry::query()->where('service_id', $a['list']->getValue('id'))->find());
                    if ($count > 0) {
                        return $count;
                    } else {
                        return "";
                    }
                }
            );


            $list->setColumnFormat(
                'service',
                'custom',
                function ($a) {
                    return ''.$a['list']->getValue('service').'<br /><small><strong>'.$a['list']->getValue('company_name').'</strong></small><br /><small>'.$a['list']->getValue('company_address').'</small>';
                }
            );

            $list->setColumnFormat(
                'privacy_policy_url',
                'custom',
                function ($a) {
                    $url = $a['list']->getValue('privacy_policy_url');
                    if ($url !== "" && strlen($url) >= 64) {
                        return '<a href="'.$a['list']->getValue('privacy_policy_url') .'">'.substr($url, 0, 64) .'...</a>';
                    } elseif ($url !== "") {
                        return '<a href="'.$a['list']->getValue('privacy_policy_url') .'">'.$url.'</a>';
                    } else {
                        return "❌";
                    }
                }
            );
        }
        if ($table->getTableName() === "rex_wenns_sein_muss_group") {
            $list = $ep->getSubject();
            /** @var rex_list $list */

            $list->setColumnFormat(
                'description',
                'custom',
                function ($a) {
                    return $a['list']->getValue('description');
                }
            );
        }
        if ($table->getTableName() === "rex_wenns_sein_muss_iframe") {
            $list = $ep->getSubject();
            /** @var rex_list $list */

            $list->setColumnFormat(
                'description',
                'custom',
                function ($a) {
                    return $a['list']->getValue('description');
                }
            );
        }
        if ($table->getTableName() === "rex_wenns_sein_muss_domain") {
            $list = $ep->getSubject();
            /** @var rex_list $list */

            $list->setColumnFormat(
                'imprint_id',
                'custom',
                function ($a) {
                    $id = $a['list']->getValue('imprint_id');
                    if (is_integer($id) && rex_article::get($id) instanceof rex_article) {
                        return rex_article::get($id)->getName().'<br><small>'. rex_article::get($id)->getUrl().'</small>';
                    }
                    return "❌";
                }
            );
            $list->setColumnFormat(
                'privacy_policy_id',
                'custom',
                function ($a) {
                    $id = $a['list']->getValue('privacy_policy_id');
                    if (is_integer($id) && rex_article::get($id) instanceof rex_article) {
                        return rex_article::get($id)->getName().'<br><small>'. rex_article::get($id)->getUrl().'</small>';
                    }
                    return "❌";
                }
            );
        }
    });
}
