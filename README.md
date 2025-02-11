# WSM Consent Manager für REDAXO 5 CMS

**Die moderne schlanke Alternative zum REDAXO Consent Manager, um Einwilligungen vom Nutzer abzufragen und Drittanbieter-Dienste einzusetzen.**

![image](https://github.com/user-attachments/assets/b2a61498-45fb-479d-87bd-b422267d007e)


## Vorteile 

* Geringe Dateigröße
* Kompatibel zu (IE10+ *)
* Keine Abhängigkeiten zu Frameworks wie jQuery
* DSGVO-kompatibel (bei korrekter Einrichtung / Verwendung)
* Mehrsprachigkeit
* Barrierearm (WAI-ARIA compliant)
* Kontrolliertes Revisions-Management (seit 5.0.0)

Außerdem angepasst an REDAXO:

* Unkomplizierte Verwendung und Einrichtung mit REX_VARs
* Basiert auf YForm - einfacher Import/Export von Drittanbieter-Informationen
* Schlanker Addon-Code - und damit einfacher zu warten und weiterzuentwickeln
* Kompatibel zu YRewrite - verwende bestehende Domains und Sprachen
* Kompatibel zu Sprog & Wildcard - verwende Übersetzungen wie gewohnt aus Sprog

Das Addon war ein großer 🌵 an Aufwand, deshalb unterstütze die Entwicklung nachträglich mit einer Beauftraung des Addon-Autors.

### Vergleich zu FriendsOfREDAXO\consent_manager

| Feature                                  | Consent Manager      | WSM Consent Manager |
|------------------------------------------|----------------------|---------------------|
| Opt-In für einzelne Kategorien           | ✅                   | ✅                  |
| Opt-Out für einzelne Kategorien          | ✅                   | ✅                  |
| Opt-In für einzelne Services             | ❌                   | ✅                  |
| Opt-Out für einzelne Services            | ❌                   | ✅                  |
| Informationen zu einzelnen Cookies       | ❌                   | ✅                  |
| Mehrsprachigkeit                         | ✅ Eigene Oberfläche | ✅ Sprog / Wildcard |
| Multidomain                              | ✅ Eigene Verwaltung | ✅ Durch YRewrite   |
| Anpassung der Texte                      | ✅                   | ✅                  |
| Vorgefertigte Themes                     | ✅ (siehe Addon)     | ✅ (z.B. Darkmode)  |
| Iframe-Manager                           | ❌                   | ✅                  |
| Adhoc-Einwilligung                       | ❌                   | ✅                  |
| Laden von Skripten ohne Seiten-Reload    | ❌                   | ✅                  |
| Revisions-Management und Protokollierung | ❌                   | ✅ (teilweise)      |
| Sprog-Platzhalter mit einem Klick        | ❌                   | ✅                  |

### Cookie-Consent-Hinweis

Einwiligungen mit einem einfachen Cookie-Consent-Hinweis abfragen - flexibel einsetzbar und kompatibel zu YRewrite. Auf Wunsch Transparenz und individuelle Einstellungen tätigen.

![image](https://github.com/user-attachments/assets/659d76be-0ffb-4f77-9653-9f495d21be23)

Demos: Siehe <https://github.com/orestbida/cookieconsent>.

### nachträgliche Adhoc-Einwilligung mit 2-Klick-Lösung

Einwilligungen direkt an Ort und Stelle abfragen - z.B. von eingebetteten Inhalten wie Videos (YouTube, Vimeo, etc.), Social Media Postings (Twitter, Instagram, Facebook), interaktiven Karten (z.B. Google Maps) u.a.

![image](https://github.com/user-attachments/assets/2c0a34ea-2c04-46f1-92f0-0c4eb9cef0da)

Demos: Siehe <https://github.com/orestbida/iframemanager>.

### Einstellungen

![image](https://github.com/user-attachments/assets/631df790-ff1c-4407-a455-5ca1f6c38da2)

#### Gruppen

Erstelle Gruppen nach dem gewohnten Muster "Verpflichtend", "Tracking", "Analyse", "Statistik", etc.

#### Drittanbieter

Erstelle Einträge von erforderlichen und optionalen Drittanbieter-Diensten und weise ihnen die gewünschten Domains zu.

#### Weitere Einstellungen

Unter "Einstellungen" lassen sich Voreinstellungen anpassen und Textbausteine definieren, darunter:

* Artikel-ID der Kontakt- und Impressums-Seite (wird verlinkt innerhalb des Cookie-Banners)
* Artikel-ID der Datenschutz-Seite (wird verlinkt innerhalb des Cookie-Banners)

Sowie grundsätzliche Layout-Einstellungen des Benachrichtigungs- und Einstellungsfensters

#### Mehrsprachigkeit

Das REDAXO-Addon Sprog eigenet sich hervoragend bei mehrsprachigen Websites, um Textbausteine in unterschiedlichen Sprachen zu verwalten. Trage anstelle der deutschen voreigenstellten Texte einen Sprog-Schlüssel ein, z.B. `{{ wsm.accept.all }}` und hinterlege die Übersetzung in Sprog. Die passende Sprache wird im Frontend anhand des aktuell gewählten clang-Codes gewählt und kann in `<html lang="XX">` überschrieben werden, falls nötig.

### Integration

Füge CSS, eigene Skritpe und JS in dein Template ein, z.B. vor `</body>`. Die eigenen Skripte werden über einen Callback erst nach Einwilligung geladen.

```php
if (rex_addon::get('wenns_sein_muss') && rex_addon::get('wenns_sein_muss')->isAvailable()) {
    echo Alexplusde\Wsm\Fragment::getCss();
    echo Alexplusde\Wsm\Fragment::getScripts();
    echo Alexplusde\Wsm\Fragment::getJs();
} ?>
```

Optional: Stelle deinen HTML-Ausgabe-Code in Templates, Modulen und Fragmenten auf den in <https://github.com/orestbida/cookieconsent> und <https://github.com/orestbida/iframemanager> empfohlenen Code um.

Mit `REX_WSM[type="manage"]` erhält der Nutzer - bspw. auf der Datenschutz-Seite - nachträglich Kontrollmöglichkeiten.

#### Beispiel-Scriptcode

##### Consent-basiertes Laden von eigenem JS (ohne Nutzung des Eingabefelds im Backend)

```html
<script type="text/plain" data-cookiecategory="analytics" src="analytics.js" defer></script>

<script type="text/plain" data-cookiecategory="ads">
    console.log('"ads" category accepted');
</script>
```

##### Nachladen von Fonts nach Einwilligung (hinterlegt in den Einstellungen)

```js
link = document.createElement('link');
link.href = 'https://fonts.googleapis.com/css2?family=Rubik+Vinyl&display=swap';
link.rel = 'stylesheet';

document.getElementsByTagName('head')[0].appendChild(link);
```

```js
script = document.createElement('script');
script.src = 'https://example.org/js/script.js';

document.getElementsByTagName('head')[0].appendChild(script);
```

Siehe <https://github.com/orestbida/cookieconsent#how-to-blockmanage-scripts>.

##### Adhoc iFrame-Einwilligung

```html
<div
    data-service="<service-name>"
    data-id="<resource-id>"
    data-params="<iframe-query-parameters>"
    data-thumbnail="<path-to-image>"
    data-autoscale>
</div>
```

z.B. für YouTube

```html
<div class="video"
    data-service="youtube"
    data-id="dQw4w9WgXcQ"
    data-params="loop=1&autoplay=0&mute=1"
    data-thumbnail=""
    data-autoscale data-ratio="16:9">
</div>
```

z.B. für YouTube Thumbnail-Proxy

```html
<div class="video"
    data-service="youtube"
    data-id="dQw4w9WgXcQ"
    data-params="loop=1&autoplay=0&mute=1"
    data-autoscale data-ratio="16:9">
</div>
```

z.B. für Google Maps

```html
<div class="maps"
    data-service="google_maps" 
    data-id="!1m14!.....................de"
    data-autoscale>
</div>
```

Siehe <https://github.com/orestbida/iframemanager#configuration-options>.

#### Themes

Siehe <https://cookieconsent.orestbida.com/advanced/ui-customization.html#color-schemes>

#### Weitere API-Methoden

Siehe <https://github.com/orestbida/cookieconsent#api-methods> und <https://github.com/orestbida/iframemanager#apis>.

## Lizenz

(c) 2024 alex+ Digitales Marketing - Alexander Walther. Alle Rechte vorbehalten.

## Autoren

**Alexander Walther**  
<http://www.alexplus.de>  
<https://github.com/alexplusde>  

**Projekt-Lead**  
[Alexander Walther](https://github.com/alexplusde)

## Credits

* <https://github.com/orestbida/cookieconsent>
* <https://github.com/orestbida/iframemanager>
