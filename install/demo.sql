-- Adminer 4.8.1 MySQL 10.4.24-MariaDB dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

TRUNCATE `rex_wenns_sein_muss`;
INSERT INTO `rex_wenns_sein_muss` (`id`, `group`, `service`, `privacy_policy_url`, `thumbnail`, `rex_domain`, `url`) VALUES
(1,	'1',	'Google',	'https://policies.google.com/privacy',	'',	'0',	'https://www.google.com'),
(3,	'2',	'Microsoft',	'https://privacy.microsoft.com/en-us/privacystatement',	'',	'0',	''),
(4,	'2',	'Google YouTube',	'https://policies.google.com/privacy',	'',	'0',	''),
(5,	'2',	'Google Fonts',	'',	'',	'0',	''),
(6,	'2',	'Facebook Inc.',	'',	'',	'0',	''),
(7,	'2',	'Instagram (Meta Inc.)',	'',	'',	'0',	''),
(8,	'2',	'Twitter Inc.',	'',	'',	'0',	''),
(9,	'2',	'Vimeo',	'',	'',	'0',	''),
(10,	'1',	'Diese Website',	'',	'',	'0',	''),
(11,	'4',	'Test',	'',	'',	'0',	'');

TRUNCATE `rex_wenns_sein_muss_entry`;
INSERT INTO `rex_wenns_sein_muss_entry` (`id`, `type`, `name`, `description`, `duration`, `f_id`) VALUES
(13,	'cookie',	'dasd',	'asdasda',	'sdasda',	'11'),
(14,	'cookie',	'dassadasdasda',	'sdasdas',	'dasdas',	'11');

TRUNCATE `rex_wenns_sein_muss_group`;
INSERT INTO `rex_wenns_sein_muss_group` (`id`, `name`, `title`, `description`, `enabled`, `required`) VALUES
(1,	'necessary',	'Notwendig',	'Notwendige Cookies helfen dabei, eine Webseite nutzbar zu machen, indem sie Grundfunktionen wie Seitennavigation und Zugriff auf sichere Bereiche der Webseite ermöglichen. Die Webseite kann ohne diese Cookies nicht richtig funktionieren.',	1,	1),
(2,	'preferences',	'Präferenzen',	'Präferenz-Cookies ermöglichen einer Webseite sich an Informationen zu erinnern, die die Art beeinflussen, wie sich eine Webseite verhält oder aussieht, wie z. B. Ihre bevorzugte Sprache oder die Region in der Sie sich befinden.',	0,	0),
(3,	'statistics',	'Statistiken',	'Statistik-Cookies helfen Webseiten-Besitzern zu verstehen, wie Besucher mit Webseiten interagieren, indem Informationen anonym gesammelt und gemeldet werden.',	0,	0),
(4,	'marketing',	'Marketing',	'Marketing-Cookies werden verwendet, um Besuchern auf Webseiten zu folgen. Die Absicht ist, Anzeigen zu zeigen, die relevant und ansprechend für den einzelnen Benutzer sind und daher wertvoller für Publisher und werbetreibende Drittparteien sind.',	0,	0),
(5,	'unknown',	'Nicht klassifiziert',	'Nicht klassifizierte Cookies sind Cookies, die wir gerade versuchen zu klassifizieren, zusammen mit Anbietern von individuellen Cookies.',	0,	0);

TRUNCATE `rex_wenns_sein_muss_protocol`;

-- 2022-10-30 22:05:23
