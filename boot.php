<?php

namespace Alexplusde\Wsm;

use rex;
use rex_article;
use rex_extension;
use rex_addon;
use rex_i18n;
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

rex_extension::register('YFORM_DATA_ADDED', Wsm::yformDataChanged(...));
rex_extension::register('YFORM_DATA_UPDATED', Wsm::yformDataChanged(...));
rex_extension::register('YFORM_DATA_DELETED', Wsm::yformDataChanged(...));

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
                    $service = ''.$a['list']->getValue('service').'<br /><small><strong>'.$a['list']->getValue('company_name').'</strong></small><br /><small>'.$a['list']->getValue('company_address').'</small><br />';
                    $url = $a['list']->getValue('privacy_policy_url');
                    if ($url !== "" && strlen($url) >= 64) {
                        $service .= '<a href="'.$a['list']->getValue('privacy_policy_url') .'">'.substr($url, 0, 64) .'...</a>';
                    } elseif ($url !== "") {
                        $service .= '<a href="'.$a['list']->getValue('privacy_policy_url') .'">'.$url.'</a>';
                    } else {
                        $service .= "❌";
                    }

                    return $service;
                }
            );
            $list->removeColumn('privacy_policy_url');
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
        if ($table->getTableName() === "rex_wenns_sein_muss_protocol") {
            $list = $ep->getSubject();
            /** @var rex_list $list */

            $list->removeColumn('accept_type');
            $list->removeColumn('accepted_categories');
            $list->removeColumn('accepted_services');
            $list->removeColumn('rejected_categories');
            $list->removeColumn('rejected_services');

            /* add column */
            $list->addColumn('preferences', rex_i18n::msg('wsm_protocol_preferences'), 5);
            $list->setColumnLabel('preferences', rex_i18n::msg('wsm_protocol_preferences'));

            $list->setColumnFormat(
                'preferences',
                'custom',
                function ($a) {
                    $accepted_services = $a['list']->getValue('accepted_services');
                    $rejected_services = $a['list']->getValue('rejected_services');

                    $accepted_services = json_decode($accepted_services, true) ?? [];
                    $rejected_services = json_decode($rejected_services, true) ?? [];

                    $output = "";
                    $output .= '✅<br>';
                    foreach ($accepted_services as $category => $services) {
                        if (!empty($services)) {
                            $output .= '<small>'.$category.': '.implode(', ', $services).'</small><br>';
                        }
                    }

                    $output .= '❌<br>';
                    foreach ($rejected_services as $category => $services) {
                        if (!empty($services)) {
                            $output .= '<small>'.$category.': '.implode(', ', $services).'</small><br>';
                        }
                    }

                    return $output;
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

if (rex::isBackend() && Wsm::getConfig('first_run', 'bool', true)) {
    Wsm::setConfig('first_run', false);
    /* Wenn YRewrite installiert ist, dann Domain hinzufügen */
    if (rex_addon::get('yrewrite')->isAvailable()) {
        $domains = \rex_yrewrite::getDomains();
        foreach($domains as $domain) {
            /** @var \rex_yrwewrite_domain $domain */
            $wsm_domain = Domain::create();
            $wsm_domain->setDomainId($domain->getId());
            $wsm_domain->setPrivacyPolicyId($domain->getStartId());
            $wsm_domain->setImprintId($domain->getStartId());
            $wsm_domain->save();
        }
    }
}
