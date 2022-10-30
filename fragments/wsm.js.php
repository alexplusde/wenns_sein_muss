<script>
{
    currLang: '<?= rex_clang::getCurrent()->getCode(); ?>',     // current language of the notice (must also be defined in the "languages" object below)
    autoLang: <?= wsm::getConfig('auto_lang') ?>,    // if enabled => use current client's browser language 
                        // instead of currLang [OPTIONAL]

    services : <?= wsm::getServicesAsJson() ?>
    
    /* 
    {
        myservice : {

            embedUrl: 'https://myservice_embed_url>/{data-id}',

            // set valid url for automatic thumbnails   [OPTIONAL]
            thumbnailUrl: 'https://<myservice_embed_thumbnail_url>/{data-id}',	

            // global iframe settings (apply to all iframes relative to current service) [OPTIONAL]
            iframe : {
                allow : 'fullscreen',           // iframe's allow attribute
                params : 'mute=1&start=21'      // iframe's url query parameters

                // function run for each iframe configured with current service
                onload : function(data_id, setThumbnail){
                    console.log("loaded iframe with data-id=" + data_id);
                }
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
        },

        anotherservice : {
            ...
        }
    } */
}
</script>
<script>
    cookieconsent.run({
        gui_options: {
            current_lang: <?= rex_clang::getCurrent()->getCode(); ?>,
            auto_language: <?= wsm::getConfig('auto_lang') ?>,
            force_consent: <?= wsm::getConfig('force_consent') ?>,
            page_scripts: true,
            revision: 1,
            consent_modal: {
                layout: 'cloud',               // box/cloud/bar
                position: 'bottom center',     // bottom/middle/top + left/right/center
                transition: 'slide',           // zoom/slide
                swap_buttons: false            // enable to invert buttons
            },
            settings_modal: {
                layout: 'box',                 // box/bar
                // position: 'left',           // left/right
                transition: 'slide'            // zoom/slide
            }
        }
        languages: {
            en: {
                consent_modal: {
                    description: 'Usual description ... {{revision_message}}',
                    revision_message: '<br> Dude, my terms have changed. Sorry for bothering you again!',
                },
            }
        }
    });
</script>
<script defer src="<?= rex_url::addonAssets('wenns_sein_muss','path-to-cookieconsent.js') ?>"></script>
<script defer src="<?= rex_url::addonAssets('wenns_sein_muss', 'iframemanager.js') ?>"></script>
