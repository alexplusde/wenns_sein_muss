<script>
{
    currLang: '<?= rex_clang::getCurrent()->getCode(); ?>',
    autoLang: <?= (int)wsm::getConfig('auto_lang') ?>

    services : /* <?= wsm_group::getServicesAsJson() ?> */  
     
    {
        myservice : {

            embedUrl: 'https://myservice_embed_url>/{data-id}',

            // set valid url for automatic thumbnails   [OPTIONAL]
            thumbnailUrl: 'https://<myservice_embed_thumbnail_url>/{data-id}',	

            // global iframe settings (apply to all iframes relative to current service) [OPTIONAL]
            iframe : {
                allow : 'fullscreen',           // iframe's allow attribute
                params : 'mute=1&start=21'      // iframe's url query parameters
            },

            // cookie is set if the current service is accepted
            cookie : {
                name : 'cc_youtube',            // cookie name
                path : '/',                     // cookie path          [OPTIONAL]
                samesite : 'lax',               // cookie samesite      [OPTIONAL]
                domain : location.hostname      // cookie domain        [OPTIONAL]
            },

            languages : {
                en : {
                    notice: 'Html <b>notice</b> message',
                    loadBtn: 'Load video',          // Load only current iframe
                    loadAllBtn: 'Don\'t ask again'  // Load all iframes configured with this service + set cookie		
                }
            }
        }
    }
}
</script>
<script>
    window.addEventListener('load', function(){

        // obtain plugin
        var cc = initCookieConsent();

        cc.run({
            gui_options: {
                current_lang: "<?= rex_clang::getCurrent()->getCode(); ?>",
                auto_language: <?= (int)wsm::getConfig('auto_lang') ?>,
                force_consent: <?= (int)wsm::getConfig('force_consent') ?>,
                page_scripts: true,
                revision: <?= wsm_group::getServicesAsRevisionHash(); ?>,
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
            languages: {
                'en': {
                    consent_modal: {
                        title: 'We use cookies!',
                        description: 'Hi, this website uses essential cookies to ensure its proper operation and tracking cookies to understand how you interact with it. The latter will be set only after consent. <button type="button" data-cc="c-settings" class="cc-link">Let me choose</button>',
                        primary_btn: {
                            text: 'Accept all',
                            role: 'accept_all'              // 'accept_selected' or 'accept_all'
                        },
                        secondary_btn: {
                            text: 'Reject all',
                            role: 'accept_necessary'        // 'settings' or 'accept_necessary'
                        }
                    },
                    settings_modal: {
                        title: 'Cookie preferences',
                        save_settings_btn: 'Save settings',
                        accept_all_btn: 'Accept all',
                        reject_all_btn: 'Reject all',
                        close_btn_label: 'Close',
                        cookie_table_headers: [
                            {col1: 'Name'},
                            {col2: 'Domain'},
                            {col3: 'Expiration'},
                            {col4: 'Description'}
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
                                title: 'More information',
                                description: 'For any queries in relation to our policy on cookies and your choices, please <a class="cc-link" href="#yourcontactpage">contact us</a>.',
                            }
                        ]
                    }
                }
            }
        });
        
    });
</script>
<script defer src="<?= rex_url::addonAssets('wenns_sein_muss','cookieconsent/cookieconsent.js') ?>"></script>
<script defer src="<?= rex_url::addonAssets('wenns_sein_muss', 'iframemanager/iframemanager.js') ?>"></script>
<?php

dump(wsm_group::getServices()); 

?>
