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
			cookieconsent = initCookieConsent();

			document.write(cookieconsent.get("categories") ||
				"<?= wsm::getConfig("consent_info_unknown") ?>");
		</script>
	</mark>
</p>
<p><?= wsm::getConfig("consent_info_uuid") ?>:
	<mark>
		<script>
			cookieconsent = initCookieConsent();

			document.write(cookieconsent.get("consent_uuid") ||
				"<?= wsm::getConfig("consent_info_unknown") ?>");
		</script>
	</mark>
</p>
<p><?= wsm::getConfig("consent_info_datestamp") ?>:
	<mark>
		<script>
			cookieconsent = initCookieConsent();

			document.write(cookieconsent.get("consent_date") ||
				"<?= wsm::getConfig("consent_info_open_settings") ?>"
				);
		</script>
	</mark>
</p>
<button type="button"
	data-cc="c-settings"><?= wsm::getConfig("consent_info_open_settings") ?></button>