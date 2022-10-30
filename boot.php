<?php

if (rex_addon::get('yform')->isAvailable() && !rex::isSafeMode()) {
    rex_yform_manager_dataset::setModelClass(
        'rex_wenns_sein_muss',
        wsm::class
    );
    rex_yform_manager_dataset::setModelClass(
        'rex_wenns_sein_muss_group',
        wsm_group::class
    );
    rex_yform_manager_dataset::setModelClass(
        'rex_wenns_sein_muss_protocol',
        wsm_protocol::class
    );
};
