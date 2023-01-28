<?php

$current = rex::getServer();

if (rex_addon::get('yrewrite')->isAvailable()) {
    $current = rex_yrewrite::getCurrentDomain()->getName();
};

?>
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
<button type="button"
	data-cc="show-preferencesModal"><?= wsm::getConfig("consent_info_open_settings") ?></button>
<button type="button" data-cc="show-consentModal"><?= wsm::getConfig("consent_info_open_modal") ?></button>
<?php

dump(wsm::getCategoriesAsJson());

?>
