<?php

if (rex_addon::get('yform')->isAvailable() && !rex::isSafeMode()) {
    rex_yform_manager_dataset::setModelClass(
        'rex_wenns_sein_muss_service',
        wsm_service::class
    );
    rex_yform_manager_dataset::setModelClass(
        'rex_wenns_sein_muss_group',
        wsm_group::class
    );
    rex_yform_manager_dataset::setModelClass(
        'rex_wenns_sein_muss_entry',
        wsm_entry::class
    );
    rex_yform_manager_dataset::setModelClass(
        'rex_wenns_sein_muss_protocol',
        wsm_protocol::class
    );
    rex_yform_manager_dataset::setModelClass(
        'rex_wenns_sein_muss_iframe',
        wsm_iframe::class
    );
};

// rex_extension::register('YFORM_DATA_ADDED', ['wsm','yform_data_added']);
// rex_extension::register('YFORM_DATA_UPDATED', ['wsm','yform_data_added']);
rex_extension::register('YFORM_DATA_DELETED', ['wsm','yform_data_deleted']);

if (rex::isBackend()) {
    rex_extension::register('YFORM_DATA_LIST', function ($ep) {
        if ($ep->getParam('table')->getTableName() == "rex_wenns_sein_muss_service") {
            $list = $ep->getSubject();

            $list->setColumnPosition('script', 3);
            $list->setColumnLabel('script', 'JS');
            $list->setColumnFormat(
                'script',
                'custom',
                function ($a) {
                    if ($a['list']->getValue('script') != "") {
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
                    $count = count(wsm_entry::query()->where('service_id', $a['list']->getValue('id'))->find());
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
                        return ''.$a['list']->getValue('service').'<br /><small>'.$a['list']->getValue('company_address').'</small>';
                }
            );

            $list->setColumnFormat(
                'privacy_policy_url',
                'custom',
                function ($a) {
                    $url = $a['list']->getValue('privacy_policy_url');
                    if ($url != "" && strlen($url) >= 64) {
                        return '<a href="'.$a['list']->getValue('privacy_policy_url') .'">'.substr($url, 0, 64) .'...</a>';
                    } else if ($url != "") {
                        return '<a href="'.$a['list']->getValue('privacy_policy_url') .'">'.$url.'</a>';
                    } else {
                        return "❌";
                    }
                }
            );

        }
    });
}
