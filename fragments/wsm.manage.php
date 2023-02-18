<?php

$current = rex::getServer();

if (rex_addon::get('yrewrite')->isAvailable()) {
    $current = rex_yrewrite::getCurrentDomain()->getName();
};

?>
			<p><?= wsm::getConfigText("consent_info_domain") ?>
				<mark><?= $current ?></mark>
			</p>

			<p><?= wsm::getConfigText("consent_info_consented") ?>:
				<mark data-wsm-manage="categories"><?= wsm::getConfigText("no_consent") ?>
				</mark>
			</p>
			<p><?= wsm::getConfigText("consent_info_uuid") ?>:
				<mark data-wsm-manage="consentId"><?= wsm::getConfigText("no_consent") ?>
				</mark>
			</p>
			<p><?= wsm::getConfigText("consent_info_datestamp") ?>:
				<mark data-wsm-manage="consentTimestamp"><?= wsm::getConfigText("no_consent") ?>
				</mark>
			</p>
			<p><?= wsm::getConfigText("consent_info_datestamp") ?>:
				<mark data-wsm-manage="lastConsentTimestamp"><?= wsm::getConfigText("no_consent") ?>
				</mark>
			</p>
			<button type="button" class="btn btn-primary"
				data-cc="show-preferencesModal"><?= wsm::getConfigText("consent_info_open_settings") ?></button>
			<button class="btn btn-secondary" type="button" data-cc="show-consentModal"><?= wsm::getConfigText("consent_info_open_modal") ?></button>
<!-- Test -->
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
	</div>
