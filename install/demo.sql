-- Adminer 4.8.1 MySQL 10.4.24-MariaDB dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

TRUNCATE `rex_wenns_sein_muss_domain`;
INSERT INTO `rex_wenns_sein_muss_domain` (`id`, `domain_id`, `privacy_policy_id`, `imprint_id`) VALUES
(1,	'0',	'5',	'4'),
(2,	'0',	'5',	'4');

TRUNCATE `rex_wenns_sein_muss_entry`;
INSERT INTO `rex_wenns_sein_muss_entry` (`id`, `type`, `name`, `duration`, `description`, `service_id`) VALUES
(1,	'cookie',	'_ga',	'1 Tag',	'Beispiel-Beschreibung',	17),
(2,	'cookie',	'pixel.gif',	'1 Monat',	'Test',	17),
(3,	'cookie',	'im_youtube',	'6M',	'Speichert die Einwilligung über das Laden von YouTube-Videos durch einen iframe.',	4),
(4,	'cookie',	'im_vimeo',	'6M',	'Speichert die Einwilligung über das Laden von Vimeo-Videos durch einen iframe.',	9),
(5,	'cookie',	'cc_cookie',	'6M',	'Speichert die gewählten Einstellungen in diesem Einwilligungs-Dialog. Dieser Cookie ist notwendig für die Einhaltung der DSGVO der Webseite.',	1),
(6,	'cookie',	'VISITOR_INFO1_LIVE',	'179d',	'Versucht, die Benutzerbandbreite auf Seiten mit integrierten YouTube-Videos zu schätzen.',	4),
(7,	'cookie',	'YSC',	'Session',	'Registriert eine eindeutige ID, um Statistiken der Videos von YouTube, die der Benutzer gesehen hat, zu behalten.',	4),
(8,	'localStorage',	'yt.innertube::nextId',	'persistent',	'Registriert eine eindeutige ID, um Statistiken der Videos von YouTube, die der Benutzer gesehen hat, zu behalten.',	4),
(9,	'localStorage',	'yt.innertube::requests',	'Persistent',	'Registriert eine eindeutige ID, um Statistiken der Videos von YouTube, die der Benutzer gesehen hat, zu behalten.',	4),
(10,	'localStorage',	'ytidb::LAST_RESULT_ENTRY_KEY',	'Persistent',	'Speichert die Benutzereinstellungen beim Abruf eines auf anderen Webseiten integrierten YouTube-Videos.',	4);

TRUNCATE `rex_wenns_sein_muss_group`;
INSERT INTO `rex_wenns_sein_muss_group` (`id`, `prio`, `name`, `title`, `description`, `enabled`, `required`) VALUES
(1,	1,	'necessary',	'Notwendig',	'Notwendige Cookies helfen dabei, eine Webseite nutzbar zu machen, indem sie Grundfunktionen wie Seitennavigation und Zugriff auf sichere Bereiche der Webseite ermöglichen. Die Webseite kann ohne diese Cookies nicht richtig funktionieren.',	1,	1),
(2,	2,	'preferences',	'Präferenzen',	'Präferenzen zu speichern, ermöglicht es uns, Ihre gewählten Einstellungen zu merken und Zusatzfunktionen zu aktivieren, zum Beispiel Videos und Medien von externen Anbietern.',	0,	0),
(3,	3,	'statistics',	'Statistiken',	'Statistik-Dienste helfen uns als Website-Betreiber zu verstehen, wie unsere Besucher mit der Website interagieren, indem Informationen anonymisiert gesammelt und ausgewertet werden.',	0,	0),
(4,	4,	'marketing',	'Marketing',	'Marketing-Cookies können dazu verwendet werden, Besucher auf unterschiedlichen Webseiten zu folgen. Die Absicht ist z.B., nur dann Anzeigen zu zeigen, wenn sie relevant und ansprechend für den einzelnen Benutzer sind.',	0,	0),
(5,	5,	'unknown',	'Nicht klassifiziert',	'Nicht klassifizierte Cookies und ähnliche Technologien versuchen wir aktuell zu klassifizieren und warten auf Informationen der Drittanbieter, die diese verwenden und darüber Auskunft geben können.',	0,	0);

TRUNCATE `rex_wenns_sein_muss_iframe`;
INSERT INTO `rex_wenns_sein_muss_iframe` (`id`, `key`, `embedUrl`) VALUES
(5,	'youtube',	'https://www.youtube-nocookie.com/embed/{data-id}'),
(6,	'vimeo',	'https://player.vimeo.com/video/{data-id}');

TRUNCATE `rex_wenns_sein_muss_service`;
INSERT INTO `rex_wenns_sein_muss_service` (`id`, `group`, `service`, `company_name`, `company_address`, `privacy_policy_url`, `iframe`, `rex_domain`, `script`, `updatedate`) VALUES
(1,	1,	'Diese Website',	'',	'',	'',	0,	'0',	'',	'2023-02-18 17:02:40'),
(3,	2,	'Microsoft',	'Microsoft Ireland Operations Limited',	'One Microsoft Place, South County Business Park, Leopardstown, Dublin 18, Irland',	'https://privacy.microsoft.com/en-us/privacystatement',	0,	'',	'',	'2023-02-18 16:51:06'),
(4,	2,	'YouTube',	'Google Ireland Limited',	'Gordon House, Barrow Street, Dublin 4, Irland',	'https://policies.google.com/privacy',	5,	'0',	'',	'2023-03-23 00:20:00'),
(5,	2,	'Google Fonts',	'Google Ireland Limited',	'Gordon House, Barrow Street, Dublin 4, Irland',	'https://policies.google.com/privacy',	0,	'',	'',	'2023-02-18 15:36:37'),
(6,	2,	'Facebook',	'Meta Platforms Ireland Limited',	'4 Grand Canal Square, Dublin 2, Irland',	'https://www.facebook.com/privacy/policy/',	0,	'',	'',	'2022-12-17 15:13:00'),
(9,	2,	'Vimeo',	'Vimeo Inc.',	'555 West 18th Street, New York, New York 10011, USA',	'https://vimeo.com/privacy',	0,	'',	'',	'2022-12-17 15:13:00'),
(10,	3,	'Google Analytics',	'Google Ireland Limited',	'Gordon House, Barrow Street, Dublin 4, Irland',	'https://support.google.com/analytics/answer/6004245',	0,	'',	'',	'2023-02-18 15:36:47'),
(13,	4,	'Google Ads',	'Google Ireland Limited',	'Gordon House, Barrow Street, Dublin 4, Irland',	'https://policies.google.com/privacy',	0,	'',	'',	'2023-02-18 16:50:39'),
(14,	4,	'LinkedIn',	'LinkedIn Corporation',	'2029 Stierlin Court, Mountain View, CA 94043, USA',	'https://www.linkedin.com/legal/privacy-policy',	0,	'',	'',	'2022-12-17 15:13:00'),
(15,	4,	'WhatsApp',	'WhatsApp Inc.',	'1601 Willow Road, Menlo Park, California 94025, USA',	'https://www.whatsapp.com/legal/#privacy-policy',	0,	'',	'',	'2022-12-17 15:13:00'),
(16,	4,	'Vimeo',	'Vimeo Inc.',	'555 West 18th Street, New York, New York 10011, USA',	'https://vimeo.com/privacy',	0,	'',	'',	'2022-12-17 15:13:00'),
(17,	2,	'Google Maps',	'Google Ireland Limited',	'Gordon House, Barrow Street, Dublin 4, Irland',	'https://policies.google.com/privacy',	0,	'',	'',	'2023-02-18 15:36:40'),
(18,	2,	'Microsoft Teams',	'Microsoft Ireland Operations Limited',	'One Microsoft Place, South County Business Park, Leopardstown, Dublin 18, Irland',	'https://privacy.microsoft.com/de-de/privacystatement',	0,	'',	'',	'2022-12-17 15:13:00'),
(20,	2,	'MyFonts',	'Monotype Imaging Holdings Inc.',	'600 Unicorn Park Drive, Woburn, Massachusetts 01801, USA',	'https://www.monotype.com/de/rechtshinweise/datenschutzrichtlinie/datenschutzrichtlinie-zum-tracking-von-webschriften',	0,	'',	'',	'2022-12-17 15:13:00'),
(21,	2,	'Font Awesome',	'6 Porter Road Apartment 3R, Cambridge, Massachusetts, USA',	'Fonticons, Inc.',	'https://fontawesome.com/privacy',	0,	'',	'',	'2022-12-17 15:13:00'),
(22,	4,	'Adobe Fonts',	'Adobe Systems Incorporated',	'345 Park Avenue, San Jose, CA 95110-2704, USA.',	'https://www.adobe.com/de/privacy/policies/adobe-fonts.html',	0,	'',	'',	'2023-02-18 16:51:35'),
(23,	3,	'Google Conversion-Tracking',	'Google Ireland Limited',	'Gordon House, Barrow Street, Dublin 4, Irland',	'https://policies.google.com/privacy',	0,	'',	'',	'2023-02-18 15:36:50'),
(24,	3,	'Matomo',	'',	'',	'',	0,	'',	'',	'2022-12-17 15:13:00'),
(25,	2,	'Google Tag Manager',	'Google Ireland Limited',	'Gordon House, Barrow Street, Dublin 4, Irland',	'https://policies.google.com/privacy',	0,	'',	'',	'2023-02-18 15:36:43'),
(26,	2,	'Instagram',	'Meta Platforms Ireland Limited',	'4 Grand Canal Square, Grand Canal Harbour, Dublin 2, Irland',	'https://instagram.com/about/legal/privacy/',	0,	'',	'',	'2022-12-17 15:13:00'),
(27,	2,	'Twitter',	'Twitter International Company',	'One Cumberland Place, Fenian Street, Dublin 2, D02 AX07, Irland',	'https://twitter.com/de/privacy',	0,	'',	'',	'2022-12-17 15:13:00');

-- 2023-03-23 00:01:04
