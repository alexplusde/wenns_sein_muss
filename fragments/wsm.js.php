<script
	src="<?= rex_url::addonAssets('wenns_sein_muss', 'cookieconsent/cookieconsent.js') ?>">
</script>
<?php if (wsm::getConfig('iframemanager')) {?>
<script
	src="<?= rex_url::addonAssets('wenns_sein_muss', 'iframemanager/iframemanager.js') ?>">
</script>
<?php } ?>
<script>
	window.addEventListener('load', function() {
		<?php if (wsm::getConfig('iframemanager')) {?>
		var im = iframemanager();
		<?php } ?>

		const cc = initCookieConsent();

		<?php if (wsm::getConfig('iframemanager')) {?>

		im.run({
			currLang: '<?= rex_clang::getCurrent()->getCode(); ?>',

			services: {
				youtube: {

					embedUrl: 'https://www.youtube-nocookie.com/embed/{data-id}',
					thumbnailUrl: 'https://i3.ytimg.com/vi/{data-id}/hqdefault.jpg',
					cookie: {
						name: 'cc_youtube'
					},

					languages: {
						en: {
							notice: '<?= wsm::getConfig('iframe_notice') ?>',
							loadBtn: '<?= wsm::getConfig('iframe_load_btn') ?>',
							loadAllBtn: '<?= wsm::getConfig('iframe_load_all_btn') ?>'
						}
					}
				},
				vimeo: {
					embedUrl: 'https://player.vimeo.com/video/{data-id}',

					thumbnailUrl: function(id, setThumbnail) {

						var url = "https://vimeo.com/api/v2/video/" + id + ".json";
						var xhttp = new XMLHttpRequest();

						xhttp.onreadystatechange = function() {
							if (this.readyState == 4 && this.status == 200) {
								var src = JSON.parse(this.response)[0].thumbnail_large;
								setThumbnail(src);
							}
						};

						xhttp.open("GET", url, true);
						xhttp.send();
					},
					iframe: {
						allow: 'accelerometer; encrypted-media; gyroscope; picture-in-picture; fullscreen;',
					},
					cookie: {
						name: 'cc_vimeo'
					},
					languages: {
						en: {
							notice: '<?= wsm::getConfig('iframe_notice') ?>',
							loadBtn: '<?= wsm::getConfig('iframe_load_btn') ?>',
							loadAllBtn: '<?= wsm::getConfig('iframe_load_all_btn') ?>'
						}
					}
				},
				google_maps: {
					embedUrl: 'https://www.google.com/maps/embed/v1/place?key=API_KEY&q={data-id}',
					iframe: {
						allow: 'picture-in-picture; fullscreen;'
					},
					cookie: {
						name: 'cc_maps'
					},
					languages: {
						en: {
							notice: '<?= wsm::getConfig('iframe_notice') ?>',
							loadBtn: '<?= wsm::getConfig('iframe_load_btn') ?>',
							loadAllBtn: '<?= wsm::getConfig('iframe_load_all_btn') ?>'
						}
					}
				}
			}
		});
		<?php } ?>

		cc.run({
			current_lang: "<?= rex_clang::getCurrent()->getCode(); ?>",
			// auto_language: "document",
			force_consent: <?= (int)wsm::getConfig('force_consent') ?> ,
			page_scripts: true,
			revision: "<?= wsm::getRevisionNumber(); ?>",

			gui_options: {

				consent_modal: {
					layout: '<?= wsm::getConfig('consent_modal_layout') ?>',
					position: '<?= wsm::getConfig('consent_modal_position') ?>',
					transition: '<?= wsm::getConfig('consent_modal_transition') ?>',
					swap_buttons: Boolean( <?= (int)wsm::getConfig('consent_modal_swap_buttons') ?> ),
				},

				settings_modal: {
					layout: '<?= wsm::getConfig('settings_modal_layout') ?>',
					transition: '<?= wsm::getConfig('settings_modal_transition') ?>'
				}
			},
			onAccept: function(cookie) {

				if (cc.allowedCategory('analytics'))
					im.acceptService('all');
			},

			onChange: function(cookie, changed_categories) {

				var http = new XMLHttpRequest();
				var params = 'rex-api-call=wsm&consent_uuid=' + cookie.consent_uuid +
					'&cookies=' + encodeURIComponent(changed_categories);
				http.open('POST', "/", true);
				http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
				http.send(params);

				if (!cc.allowedCategory('analytics'))
					im.rejectService('all');
			},

			onFirstAction: function(user_preferences, cookie) {

				var http = new XMLHttpRequest();
				var params = 'rex-api-call=wsm&consent_uuid=' + cookie.consent_uuid +
					'&cookies=' + encodeURIComponent(user_preferences);
				http.open('POST', "/", true);
				http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
				http.send(params);

			},


			languages: {
				"de": {
					consent_modal: {
						title: '<?= wsm::getConfig('consent_modal_title') ?>',
						description: '<?= wsm::getConfig('consent_modal_description') ?>' +
							'<button type="button" data-cc="c-settings" class="cc-link">Let me choose</button>',
						primary_btn: {
							text: '<?= wsm::getConfig('consent_modal_primary_btn') ?>',
							role: 'accept_all' // 'accept_selected' or 'accept_all'
						},
						secondary_btn: {
							text: '<?= wsm::getConfig('consent_modal_secondary_btn') ?>',
							role: 'accept_necessary' // 'settings' or 'accept_necessary'
						}
					},
					settings_modal: {
						title: '<?= wsm::getConfig('settings_modal_title') ?>',
						save_settings_btn: '<?= wsm::getConfig('settings_modal_save_settigns_btn') ?>',
						accept_all_btn: '<?= wsm::getConfig('settings_modal_accept_all_btn') ?>',
						reject_all_btn: '<?= wsm::getConfig('settings_modal_reject_all_btn') ?>',
						close_btn_label: '<?= wsm::getConfig('settings_modal_close_btn_label') ?>',
						cookie_table_headers: [{
								col1: '<?= wsm::getConfig('settings_modal_cookie_table_headers_col1') ?>'
							},
							{
								col2: '<?= wsm::getConfig('settings_modal_cookie_table_headers_col2') ?>'
							},
							{
								col3: '<?= wsm::getConfig('settings_modal_cookie_table_headers_col3') ?>'
							},
							{
								col4: '<?= wsm::getConfig('settings_modal_cookie_table_headers_col4') ?>'
							}
						],
						blocks: <?= wsm::getServicesAsJson(); ?>

					}
				}
			}
		});

	});
</script>