<script src="<?= rex_url::addonAssets('wenns_sein_muss','cookieconsent/cookieconsent.js') ?>"></script>
<script src="<?= rex_url::addonAssets('wenns_sein_muss', 'iframemanager/iframemanager.js') ?>"></script>

<?= rex_clang::getCurrent()->getCode(); ?>

<script>
    window.addEventListener('load', function(){

        var im = iframemanager();
        const cc = initCookieConsent();

        im.run(
        {
            currLang: '<?= rex_clang::getCurrent()->getCode(); ?>',
            // autoLang: <?= (int)wsm::getConfig('auto_lang') ?>,
            services : /* <?= wsm_group::getServicesAsJson() ?> */
            
            {
                youtube : {

                    embedUrl: 'https://www.youtube.com>/?v={data-id}',
                    thumbnailUrl: 'https://thumbnail.youtube.com/?v={data-id}',	
                    cookie : {
                        name : 'cc_youtube'
                    },

                    languages : {
                        <?= rex_clang::getCurrent()->getCode(); ?> : {
                            notice: '<?= wsm::getConfig('iframe_notice') ?>',
                            loadBtn: '<?= wsm::getConfig('iframe_load_btn') ?>',
                            loadAllBtn: '<?= wsm::getConfig('iframe_load_all_btn') ?>'
                        }
                    }
                }
            }
        });

        cc.run({
            gui_options: {
                current_lang: "<?= rex_clang::getCurrent()->getCode(); ?>",
                // auto_language: <?= (int)wsm::getConfig('auto_lang') ?>,
                force_consent: <?= (int)wsm::getConfig('force_consent') ?>,
                page_scripts: true,
                revision: '<?= wsm_group::getServicesAsRevisionHash(); ?>',
                consent_modal: {
                    layout: '<?= wsm::getConfig('consent_modal_layout') ?>',
                    position: '<?= wsm::getConfig('consent_modal_position') ?>',
                    transition: '<?= wsm::getConfig('consent_modal_transition') ?>',
                    swap_buttons:  <?= (int)wsm::getConfig('consent_modal_swap_buttons') ?>,
                },
                settings_modal: {
                    layout: '<?= wsm::getConfig('settings_modal_layout') ?>',
                    transition: '<?= wsm::getConfig('settings_modal_transition') ?>'
                }
            },

            languages: {
                en: {
                    consent_modal: {
                        title: '<?= wsm::getConfig('consent_modal_title') ?>',
                        description: '<?= wsm::getConfig('consent_modal_description') ?>' + '<button type="button" data-cc="c-settings" class="cc-link">Let me choose</button>',
                        primary_btn: {
                            text: '<?= wsm::getConfig('consent_modal_primary_btn') ?>',
                            role: 'accept_all'              // 'accept_selected' or 'accept_all'
                        },
                        secondary_btn: {
                            text: '<?= wsm::getConfig('consent_modal_secondary_btn') ?>',
                            role: 'accept_necessary'        // 'settings' or 'accept_necessary'
                        }
                    },
                    /*
                    onAccept: function(){
                        if(cc.allowedCategory('analytics'))
                            im.acceptService('all');
                    },
                    
                    onChange: function(){
                        if(!cc.allowedCategory('analytics'))
                            im.rejectService('all');
                    },
                    */
                    settings_modal: {
                        title: '<?= wsm::getConfig('settings_modal_title') ?>',
                        save_settings_btn: '<?= wsm::getConfig('settings_modal_save_settigns_btn') ?>',
                        accept_all_btn: '<?= wsm::getConfig('settings_modal_accept_all_btn') ?>',
                        reject_all_btn: '<?= wsm::getConfig('settings_modal_accept_all_btn') ?>',
                        close_btn_label: '<?= wsm::getConfig('settings_modal_close_btn_label') ?>',
                        cookie_table_headers: [
                            {col1: '<?= wsm::getConfig('settings_modal_cookie_table_headers_col1') ?>'},
                            {col2: '<?= wsm::getConfig('settings_modal_cookie_table_headers_col2') ?>'},
                            {col3: '<?= wsm::getConfig('settings_modal_cookie_table_headers_col3') ?>'},
                            {col4: '<?= wsm::getConfig('settings_modal_cookie_table_headers_col4') ?>'}
                        ],
                        blocks:  <?= wsm_group::getServicesAsJson(); ?>
                
                    }
                }
            }
        });
        
    });
</script>
