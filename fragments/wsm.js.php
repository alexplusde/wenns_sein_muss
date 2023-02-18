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

			services: <?= wsm::getIframeServicesAsJson() ?> ,

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


			sections: <?= wsm::getServicesAsJson() ?> ,

			categories: <?= wsm::getCategoriesAsJson() ?> ,



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

			const cookie = wsm_cc.getCookie();
			const preferences = wsm_cc.getUserPreferences();

			let formData = new FormData();
			formData.append('consentId', cookie.consentId);
			formData.append('acceptType', preferences.acceptType);
			formData.append('acceptedCategories', preferences.acceptedCategories);
			formData.append('rejectedCategories', preferences.rejectedCategories);

			fetch('/?rex-api-call=wsm&wsm=log', {
				method: 'POST',
				body: formData
			});
		}
	});
</script>
