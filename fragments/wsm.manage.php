<button type="button" data-cc="c-settings">Show cookie settings</button>
<button type="button" data-cc="accept-all">Accept all cookies</button>

<?php

$current = rex::getServer();

if (rex_addon::get('yrewrite')->isAvailable()) {
    $current = rex_yrewrite::getCurrentDomain()->getName();
};

?>
<p>Ihre Einwilligung trifft auf die folgenden Domains zu:
	<mark><?= $current ?></mark>
</p>

<p>Ihr aktueller Zustand: <mark>
		<script>
			cookieconsent = initCookieConsent();

			document.write(cookieconsent.get("categories") || "keine");
		</script>
	</mark> </p>
<p>Ihre Einwilligungs-ID: <mark>
		<script>
			cookieconsent = initCookieConsent();

			document.write(cookieconsent.get("consent_uuid") || "noch keine Einwilligung erfolgt");
		</script>
	</mark></p>
<p>Einwilligungsdatum: <mark>
		<script>
			cookieconsent = initCookieConsent();

			document.write(cookieconsent.get("consent_date") || "noch keine Einwilligung erfolgt");
		</script>
	</mark></p>


<h2>
</h2>