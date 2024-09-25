<?php

/**
 * De-Installieren des Addons.
 *
 * Der Umfang kann interaktiv festgelegt werden:
 * - Minimal: nur die YForm-Tablesets; die Tabellen selbst bleiben erhalten
 * - Vollständig: entfernt auch Tabellen.
 *
 * Steuerung mit einem Trick: Ohne den Url-Parameter nscope wird die Deinstallation
 * mit einem Fake-Fehler abgebrochen. Die "Fehlermeldung" ist eine Abfrage des
 * Scopes. Je nach Auswahl wird ein Link abgesetzt, der den Zusatzparameter nscope
 * mit der jeweiligen ID (1 oder 2) mitführt. Darüber steuert sich dann der
 * Deinstallations-Umfang.
 */

namespace Alexplusde\Wsm;

use rex;
use rex_context;
use rex_functional_exception;
use rex_markdown;
use rex_request;
use rex_sql_table;
use rex_yform_manager_table_api;

use function in_array;

use const PHP_EOL;

/**
 * Im SafeMode nix tun, nur das Addon "abschalten" ohne Tabellen und Tablesets zu entfernen
 * Grund: Tablesets können nicht ohne Weiteres entfernt werden. Verbleiben aber nur
 * die Tablesets ohne Tabellen, ist das auch unschön.
 */
if (rex::isSafeMode()) {
    return;
}

/**
 * Url-Parameter scope auswerten: unbekannt oder ungültig lösen die
 * "Fehlermeldung" mit der Abfrage aus
 * (Text als Markdown schreiben; dann muss man hier nicht soviel HTML basteln).
 */
$scope = rex_request::get('scope', 'int', 0);
if (!in_array($scope, [1, 2], true)) {
    $context = rex_context::fromGet();
    // TODO: Texte nach *.lang verlagern
    $msg = '### Bitte den De-Installations-Umfang auswählen' . PHP_EOL;
    $msg .= '- **Minimal** (YForm-Tablesets entfernen) ⇒ **[Start](' . $context->getUrl(['scope' => 1], false) . ')**' . PHP_EOL;
    $msg .= '- **Vollständig** (Tabellen und Tablesets entfernen) ⇒ **[Start](' . $context->getUrl(['scope' => 2], false) . ')**' . PHP_EOL;
    $msg = rex_markdown::factory()->parse($msg);
    throw new rex_functional_exception($msg);
}

$tables = [
    rex::getTable('wenns_sein_muss_domain'),
    rex::getTable('wenns_sein_muss_entry'),
    rex::getTable('wenns_sein_muss_group'),
    rex::getTable('wenns_sein_muss_service'),
    rex::getTable('wenns_sein_muss_iframe'),
    rex::getTable('wenns_sein_muss_protocol'),
];

/**
 * Minimale Lösch-Aktivitäten: scope in [1,2]
 * - YForm-Tablesets entfernen.
 * Komplett löschen: scope in [2]
 * - Tabellen löschen.
 */
foreach ($tables as $table) {
    rex_yform_manager_table_api::removeTable($table);
    if (2 === $scope) {
        rex_sql_table::get($table)->drop();
    }
}
