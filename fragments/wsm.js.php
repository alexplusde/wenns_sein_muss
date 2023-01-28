<script defer>

window.addEventListener('DOMContentLoaded', (event) => {

	const wsm_im = iframemanager();

	wsm_im.run({
		onChange: ({
			changedServices,
			eventSource
		}) => {
			if (eventSource.type === 'click') {
				const servicesToAccept = [
					...wsm_cc.getUserPreferences().acceptedServices['preferences'],
					...changedServices,
				];

				wsm_cc.acceptService(servicesToAccept, 'preferences');
			}
		},

		currLang: '<?= rex_clang::getCurrent()->getCode(); ?>',

		services: {
			youtube: {
				embedUrl: 'https://www.youtube-nocookie.com/embed/{data-id}',
				thumbnailUrl: 'https://i3.ytimg.com/vi/{data-id}/hqdefault.jpg',

				iframe: {
					allow: 'accelerometer; encrypted-media; gyroscope; picture-in-picture; fullscreen;',
				},

				languages: {
					de: {
						notice: 'This content is hosted by a third party. By showing the external content you accept the <a rel="noreferrer noopener" href="https://www.youtube.com/t/terms" target="_blank">terms and conditions</a> of youtube.com.',
						loadAllBtn: '<?= wsm::getConfig('settings_modal_accept_all_btn') ?>',
					},
				},
			},

			vimeo: {
				embedUrl: 'https://player.vimeo.com/video/{data-id}',
				iframe: {
					allow: 'fullscreen; picture-in-picture;',
				},

				thumbnailUrl: async (dataId, setThumbnail) => {
					const url = `https://vimeo.com/api/v2/video/${dataId}.json`;
					const response = await (await fetch(url)).json();
					const thumbnailUrl = response[0]?.thumbnail_large;
					thumbnailUrl && setThumbnail(thumbnailUrl);
				},

				languages: {
					de: {
						notice: 'This content is hosted by a third party. By showing the external content you accept the <a rel="noreferrer noopener" href="https://vimeo.com/terms" target="_blank">terms and conditions</a> of vimeo.com.',
						loadBtn: 'Load once',
						loadAllBtn: "Don't ask again",
					},
				},
			},
		},
	});

	const wsm_cc = CookieConsent;

	wsm_cc.run({
		revision: <?= wsm::getRevisionNumber(); ?> ,
		/* 		autoShow: false, */
		disablePageInteraction: <?= wsm::getConfig('disable_page_interaction') ?? "false" ?> ,

		guiOptions: {
			consentModal: {
				layout: '<?= wsm::getConfig('settings_modal_layout') ?>',
				position: '<?= wsm::getConfig('consent_modal_position') ?>',
				equalWeightButtons: true,
				flipButtons: <?= (int)wsm::getConfig('consent_modal_swap_buttons') ?> ,
			},
			preferencesModal: {
				layout: '<?= wsm::getConfig('settings_modal_layout') ?>',
				equalWeightButtons: true,
				flipButtons: <?= (bool)wsm::getConfig('consent_modal_swap_buttons') ?> ,
			},
		},


		sections: <?= wsm::getServicesAsJson() ?>,

		categories: <?= wsm::getCategoriesAsJson() ?>,

		

		language: {
			default: '<?= rex_clang::getCurrent()->getCode(); ?>',

			translations: {
				<?= rex_clang::getCurrent()->getCode(); ?>
				: '/?rex-api-call=wsm&wsm=lang&lang=<?= rex_clang::getCurrent()->getCode(); ?>',
			},
		},

		onFirstConsent: () => {
			logConsent();
		},

		onChange: () => {
			logConsent();
		}
	});

	function logConsent() {

		// Retrieve all the fields
		const cookie = wsm_cc.getCookie();
		const preferences = wsm_cc.getUserPreferences();

		// In this example we're saving only 4 fields
		const userConsent = {
			consentId: cookie.consentId,
			acceptType: preferences.acceptType,
			acceptedCategories: preferences.acceptedCategories,
			rejectedCategories: preferences.rejectedCategories
		};

		// Send the data to your backend
		// replace "/your-endpoint-url" with your API
		fetch('/?rex-api-call=wsm&wsm=log', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json'
			},
			body: JSON.stringify(userConsent)
		});
	}
    console.log('DOM fully loaded and parsed');
});

</script>
