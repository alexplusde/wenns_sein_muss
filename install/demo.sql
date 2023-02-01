-- Adminer 4.8.1 MySQL 10.4.24-MariaDB dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

TRUNCATE `rex_wenns_sein_muss_entry`;
INSERT INTO `rex_wenns_sein_muss_entry` (`id`, `type`, `name`, `duration`, `description`, `service_id`) VALUES
(20,	'cookie',	'_ga',	'1 Tag',	'Beispiel-Beschreibung',	17),
(21,	'cookie',	'pixel.gif',	'1 Monat',	'Test',	17),
(22,	'cookie',	'im_youtube',	'6M',	'Speichert die Einwilligung über das Laden von YouTube-Videos durch einen iframe.',	10),
(23,	'cookie',	'im_vimeo',	'6M',	'Speichert die Einwilligung über das Laden von YouTube-Videos durch einen iframe.',	10),
(24,	'cookie',	'cc_cookie',	'6M',	'Speichert die gewählten Einstellungen in diesem Einwilligungs-Dialog.',	10);

TRUNCATE `rex_wenns_sein_muss_group`;
INSERT INTO `rex_wenns_sein_muss_group` (`id`, `prio`, `name`, `title`, `description`, `enabled`, `required`) VALUES
(1,	0,	'necessary',	'Notwendig',	'Notwendige Cookies helfen dabei, eine Webseite nutzbar zu machen, indem sie Grundfunktionen wie Seitennavigation und Zugriff auf sichere Bereiche der Webseite ermöglichen. Die Webseite kann ohne diese Cookies nicht richtig funktionieren.',	1,	1),
(2,	0,	'preferences',	'Präferenzen',	'Präferenzen zu speichern, ermöglicht es uns, Ihre gewählten Einstellungen zu merken und Zusatzfunktionen zu aktivieren, zum Beispiel Videos und Medien von externen Anbietern.',	0,	0),
(3,	0,	'statistics',	'Statistiken',	'Statistik-Dienste helfen uns als Website-Betreiber zu verstehen, wie unsere Besucher mit der Website interagieren, indem Informationen anonymisiert gesammelt und ausgewertet werden.',	0,	0),
(4,	0,	'marketing',	'Marketing',	'###todo###',	0,	0),
(5,	0,	'unknown',	'Nicht klassifiziert',	'Nicht klassifizierte Cookies und ähnliche Technologien versuchen wir aktuell zu klassifizieren und warten auf Informationen der Drittanbieter, die diese verwenden und darüber Auskunft geben können.',	0,	0);

TRUNCATE `rex_wenns_sein_muss_protocol`;
INSERT INTO `rex_wenns_sein_muss_protocol` (`id`, `url`, `consent_id`, `accept_type`, `accepted_categories`, `rejected_categories`, `consentdate`) VALUES
(18,	'www.redaxo.local',	'fae51ac9-9816-4ba5-9060-a0055a74227b',	'necessary',	'necessary',	'preferences,statistics,marketing,unknown',	'2023-01-28 19:38:33'),
(19,	'www.redaxo.local',	'7817539b-72d8-4f30-9a71-7d5ebcf4cea5',	'all',	'necessary,preferences,statistics,marketing,unknown',	'',	'2023-01-28 19:40:17'),
(20,	'www.redaxo.local',	'f6b9bd74-204e-4ee1-aa11-e9ecf7c1c801',	'custom',	'necessary,preferences',	'statistics,marketing,unknown',	'2023-01-28 20:04:22'),
(21,	'www.redaxo.local',	'3055463c-cbfb-489e-8b43-41f842c1817d',	'necessary',	'necessary',	'preferences,statistics,marketing,unknown',	'2023-01-28 20:08:11');

TRUNCATE `rex_wenns_sein_muss_service`;
INSERT INTO `rex_wenns_sein_muss_service` (`id`, `group`, `service`, `company_name`, `company_address`, `privacy_policy_url`, `thumbnail`, `rex_domain`, `script`, `updatedate`) VALUES
(1,	3,	'Google Analytics',	'Google Ireland Limited',	'Gordon House, Barrow Street, Dublin 4, Irland',	'https://support.google.com/analytics/answer/6004245?hl=de',	'',	'0',	'',	'2022-12-17 15:13:00'),
(3,	2,	'Microsoft',	'',	'',	'https://privacy.microsoft.com/en-us/privacystatement',	'',	'0',	'',	'2022-12-17 15:13:00'),
(4,	2,	'YouTube',	'Google Ireland Limited',	'Gordon House, Barrow Street, Dublin 4, Irland',	'https://policies.google.com/privacy',	'',	'0',	'',	'2022-12-17 15:13:00'),
(5,	2,	'Google Fonts',	'Google Ireland Limited',	'',	'https://policies.google.com/privacy?hl=de',	'',	'1',	'link = document.createElement(\'link\');\r\nlink.href = \'https://fonts.googleapis.com/css2?family=Rubik+Vinyl&display=swap\';\r\nlink.rel = \'stylesheet\';\r\n\r\ndocument.getElementsByTagName(\'head\')[0].appendChild(link);\r\n',	'2023-01-28 17:54:36'),
(6,	2,	'Facebook',	' Meta Platforms Ireland Limited',	'4 Grand Canal Square, Dublin 2, Irland',	'https://www.facebook.com/privacy/policy/',	'',	'0',	'',	'2022-12-17 15:13:00'),
(9,	2,	'Vimeo',	'Vimeo Inc.',	'555 West 18th Street, New York, New York 10011, USA',	'https://vimeo.com/privacy',	'',	'0',	'',	'2022-12-17 15:13:00'),
(10,	1,	'Diese Website',	'',	'',	'',	'',	'0',	'',	'2023-01-28 19:34:24'),
(13,	4,	'Google Ads',	'Google Ireland Limited',	'Gordon House, Barrow Street, Dublin 4, Irland',	'https://policies.google.com/privacy?hl=de',	'',	'0',	'<script>\r\n    confirm(\"Dieses Skript für Google Ads wurde erst nach Einwilligung geladen.\");\r\n</script>',	'2023-01-28 19:40:07'),
(14,	4,	'LinkedIn',	'LinkedIn Corporation',	'2029 Stierlin Court, Mountain View, CA 94043, USA',	'https://www.linkedin.com/legal/privacy-policy',	'',	'0',	'',	'2022-12-17 15:13:00'),
(15,	4,	'WhatsApp',	'WhatsApp Inc.',	'1601 Willow Road, Menlo Park, California 94025, USA',	'https://www.whatsapp.com/legal/#privacy-policy',	'',	'0',	'',	'2022-12-17 15:13:00'),
(16,	4,	'Vimeo',	'Vimeo Inc.',	'555 West 18th Street, New York, New York 10011, USA',	'https://vimeo.com/privacy',	'',	'0',	'',	'2022-12-17 15:13:00'),
(17,	2,	'Google Maps',	'Google Ireland Limited',	'Gordon House, Barrow Street, Dublin 4, Irland',	'https://policies.google.com/privacy?hl=de',	'',	'1',	'console.log(\"yay\");\r\n',	'2023-01-28 16:04:34'),
(18,	2,	'Microsoft Teams',	'Microsoft Ireland Operations Limited',	'One Microsoft Place, South County Business Park, Leopardstown, Dublin 18, Irland',	'https://privacy.microsoft.com/de-de/privacystatement',	'',	'0',	'',	'2022-12-17 15:13:00'),
(20,	2,	'MyFonts',	'Monotype Imaging Holdings Inc.',	'600 Unicorn Park Drive, Woburn, Massachusetts 01801, USA',	'https://www.monotype.com/de/rechtshinweise/datenschutzrichtlinie/datenschutzrichtlinie-zum-tracking-von-webschriften',	'',	'0',	'',	'2022-12-17 15:13:00'),
(21,	2,	'Font Awesome',	'6 Porter Road Apartment 3R, Cambridge, Massachusetts, USA',	'Fonticons, Inc.',	'https://fontawesome.com/privacy',	'',	'0',	'',	'2022-12-17 15:13:00'),
(22,	4,	'Adobe Fonts',	'345 Park Avenue, San Jose, CA 95110-2704, USA.',	'Adobe Systems Incorporated',	'https://www.adobe.com/de/privacy/policies/adobe-fonts.html',	'',	'0',	'',	'2022-12-17 15:13:00'),
(23,	3,	'Google Conversion-Tracking',	'Google Ireland Limited',	'Gordon House, Barrow Street, Dublin 4, Irland',	'https://policies.google.com/privacy?hl=de',	'',	'0',	'',	'2022-12-17 15:13:00'),
(24,	3,	'Matomo',	'',	'',	'',	'',	'0',	'',	'2022-12-17 15:13:00'),
(25,	2,	'Google Tag Manager',	'Google Ireland Limited',	'Gordon House, Barrow Street, Dublin 4, Irland',	'https://policies.google.com/privacy?hl=de',	'',	'0',	'',	'2022-12-17 15:13:00'),
(26,	2,	'Instagram',	'Meta Platforms Ireland Limited',	'4 Grand Canal Square, Grand Canal Harbour, Dublin 2, Irland',	'https://instagram.com/about/legal/privacy/',	'',	'0',	'',	'2022-12-17 15:13:00'),
(27,	2,	'Twitter',	'Twitter International Company',	'One Cumberland Place, Fenian Street, Dublin 2, D02 AX07, Irland',	'https://twitter.com/de/privacy',	'',	'0',	'',	'2022-12-17 15:13:00');
