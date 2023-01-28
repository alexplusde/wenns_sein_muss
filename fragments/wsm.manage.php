<?php

$current = rex::getServer();

if (rex_addon::get('yrewrite')->isAvailable()) {
    $current = rex_yrewrite::getCurrentDomain()->getName();
};

?>
<div class="container p-5">
	<div class="row">
		<div class="col-md-12">
			<p><?= wsm::getConfig("consent_info_domain") ?>
				<mark><?= $current ?></mark>
			</p>

			<p><?= wsm::getConfig("consent_info_consented") ?>:
				<mark>
					<script>
						document.write(CookieConsent.getCookie("categories"));
					</script>
				</mark>
			</p>
			<p><?= wsm::getConfig("consent_info_uuid") ?>:
				<mark>
					<script>
						document.write(CookieConsent.getCookie("consentId"));
					</script>
				</mark>
			</p>
			<p><?= wsm::getConfig("consent_info_datestamp") ?>:
				<mark>
					<script>
						document.write(CookieConsent.getCookie("consentTimestamp"));
					</script>
				</mark>
			</p>
			<p><?= wsm::getConfig("consent_info_datestamp") ?>:
				<mark>
					<script>
						document.write(CookieConsent.getCookie("lastConsentTimestamp"));
					</script>
				</mark>
			</p>
			<button type="button" class="btn btn-primary"
				data-cc="show-preferencesModal"><?= wsm::getConfig("consent_info_open_settings") ?></button>
			<button class="btn btn-secondary" type="button" data-cc="show-consentModal">Modal öffnen</button>

		</div>
	</div>
</div>
<div class="container p-5">
	<div class="row">

		<div class="col col-md-6">
			<div data-service="youtube" data-id="5b35haQV7tU" data-autoscale></div>
		</div>
		<div class="col col-md-6">
			<div data-service="vimeo" data-id="776749483" data-title="Apple “Escape From The Office”" data-autoscale>
			</div>
		</div>

	</div>


	<br />

</div>