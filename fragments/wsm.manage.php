<?php

$current = rex::getServer();

if (rex_addon::get('yrewrite')->isAvailable()) {
    $current = rex_yrewrite::getCurrentDomain()->getName();
};

?>
<p><?= wsm::getConfig("consent_info_domain") ?>
	<mark><?= $current ?></mark>
</p>

<p><?= wsm::getConfig("consent_info_domain") ?>:
	<mark>
		<script>
			cookieconsent = initCookieConsent();

			document.write(cookieconsent.get("categories") || "keine");
		</script>
	</mark> </p>
<p><?= wsm::getConfig("consent_info_domain") ?>:
	<mark>
		<script>
			cookieconsent = initCookieConsent();

			document.write(cookieconsent.get("consent_uuid") || "noch keine Einwilligung erfolgt");
		</script>
	</mark></p>
<p><?= wsm::getConfig("consent_info_domain") ?>:
	<mark>
		<script>
			cookieconsent = initCookieConsent();

			document.write(cookieconsent.get("consent_date") || "noch keine Einwilligung erfolgt");
		</script>
	</mark></p>
<button type="button"
	data-cc="c-settings"><?= wsm::getConfig("consent_info_open_settings") ?></button>