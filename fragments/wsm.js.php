<script src="<?= rex_url::addonAssets('wenns_sein_muss','cookieconsent/cookieconsent.js') ?>"></script>
<script src="<?= rex_url::addonAssets('wenns_sein_muss', 'iframemanager/iframemanager.js') ?>"></script>
<script>
    window.addEventListener('load', function(){

        var im = iframemanager();
        const cc = initCookieConsent();

        im.run(
        {
            currLang: '<?= rex_clang::getCurrent()->getCode(); ?>',
            autoLang: <?= (int)wsm::getConfig('auto_lang') ?>,

            services : /* <?= wsm_group::getServicesAsJson() ?> */  
            
            {
                youtube : {

                    embedUrl: 'https://www.youtube.com>/?v={data-id}',

                    // set valid url for automatic thumbnails   [OPTIONAL]
                    thumbnailUrl: 'https://thumbnail.youtube.com/?v={data-id}',	

                    // cookie is set if the current service is accepted
                    cookie : {
                        name : 'cc_youtube'
                    },

                    languages : {
                        en : {
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
                auto_language: <?= (int)wsm::getConfig('auto_lang') ?>,
                force_consent: <?= (int)wsm::getConfig('force_consent') ?>,
                page_scripts: true,
                revision: '<?= wsm_group::getServicesAsRevisionHash(); ?>',
                consent_modal: {
                    layout: '<?= wsm::getConfig('consent_modal_layout') ?>',
                    position: '<?= wsm::getConfig('consent_modal_position') ?>',
                    transition: '<?= wsm::getConfig('consent_modal_transition') ?>',
                    swap_buttons:  <?= (int)wsm::getConfig('consent_modal_swap_buttons') ?>
                },
                settings_modal: {
                    layout: '<?= wsm::getConfig('settings_modal_layout') ?>',                 // box/bar
                    // position: 'left',           // left/right
                    transition: '<?= wsm::getConfig('settings_modal_transition') ?>'            // zoom/slide
                }
            },
            
            onAccept: function(){
                if(cc.allowedCategory('analytics'))
                    im.acceptService('all');
            },
            
            onChange: function(){
                if(!cc.allowedCategory('analytics'))
                    im.rejectService('all');
            },

            languages: {
                'en': {
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
                        blocks: [
                            {
                                title: 'Cookie usage 📢',
                                description: 'I use cookies to ensure the basic functionalities of the website and to enhance your online experience. You can choose for each category to opt-in/out whenever you want. For more details relative to cookies and other sensitive data, please read the full <a href="#" class="cc-link">privacy policy</a>.'
                            }, {
                                title: 'Strictly necessary cookies',
                                description: 'These cookies are essential for the proper functioning of my website. Without these cookies, the website would not work properly',
                                toggle: {
                                    value: 'necessary',
                                    enabled: true,
                                    readonly: true          // cookie categories with readonly=true are all treated as "necessary cookies"
                                }
                            }, {
                                title: 'Performance and Analytics cookies',
                                description: 'These cookies allow the website to remember the choices you have made in the past',
                                toggle: {
                                    value: 'analytics',     // your cookie category
                                    enabled: false,
                                    readonly: false
                                },
                                cookie_table: [             // list of all expected cookies
                                    {
                                        col1: '^_ga',       // match all cookies starting with "_ga"
                                        col2: 'google.com',
                                        col3: '2 years',
                                        col4: 'description ...',
                                        is_regex: true
                                    },
                                    {
                                        col1: '_gid',
                                        col2: 'google.com',
                                        col3: '1 day',
                                        col4: 'description ...',
                                    }
                                ]
                            }, {
                                title: 'Advertisement and Targeting cookies',
                                description: 'These cookies collect information about how you use the website, which pages you visited and which links you clicked on. All of the data is anonymized and cannot be used to identify you',
                                toggle: {
                                    value: 'targeting',
                                    enabled: false,
                                    readonly: false
                                }
                            }, {
                                title: '<?= wsm::getConfig('settings_modal_block_more_title') ?>',
                                description: '<?= wsm::getConfig('settings_modal_block_more_description') ?>',
                            }
                        ]
                    }
                }
            }
        });
        
    });
</script>
<button type="button" data-cc="c-settings">Show cookie settings</button>
<button type="button" data-cc="accept-all">Accept all cookies</button>
<?= wsm::getConfig('consent_modal_primary_btn') ?>
