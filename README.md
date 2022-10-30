# Wenn's sein muss? - REDAXO 5 Addon für Einwilligungen und Drittanbieter

Die neue Alternative, um Einwilligungen vom Nutzer abzufragen und Drittanbieter-Dienste einzusetzen.

* Geringe Dateigröße
* Kompatibel zu (IE10+ *)
* Keine Abhängigkeiten zu Frameworks wie jQuery
* DSGVO-kompatibel (bei korrekter Einrichtung / Verwendung)
* Mehrsprachen-Kompatibel
* Barrierearm (WAI-ARIA compliant)

Außerdem angepasst an REDAXO

* Unkomplizierte Verwendung und Einrichtung mit REX_VARs
* Kompatibel zu YRewrite - verwende bestehende Domains und Sprachen
* Kompatibel zu Sprog - verwende Übersetzungen wie gewohnt aus Sprog

Das Addon war ein großer 🌵 an Aufwand, deshalb unterstütze die Entwicklung nachträglich mit einer Beauftraung des Addon-Autors.

## Features

### Cookie-Consent-Hinweis

Einwiligungen mit einem einfachen Cookie-Consent-Hinweis abfragen - flexibel einsetzbar und kompatibel zu YRewrite. 

Demos: Siehe <https://github.com/orestbida/cookieconsent>.

### nachträgliche Adhoc-Einwilligung mit 2-Klick-Lösung

Einwilligungen direkt an Ort und Stelle abfragen - z.B. von eingebetteten Inhalten wie Videos (YouTube, Vimeo, etc.), Social Media Postings (Twitter, Instagram, Facebook), interaktiven Karten (z.B. Google Maps) u.a.

Demos: Siehe <https://github.com/orestbida/iframemanager>.

### Einstellungen

folgt...

### Integration

1. Integriere `REX_WSM[css="1"]` im Template im `<head>`-Bereich, um das benötigte CSS zu laden.
2. Integriere `REX_WSM[js="1"]` im Template vor dem schließenden `</body>`-Tag, um das benötigte JS zu laden.
3. (optional): Stelle deinen HTML-Ausgabe-Code in Templates, Modulen und Fragmenten auf den in <https://github.com/orestbida/cookieconsent> und <https://github.com/orestbida/iframemanager> empfohlenen Code um.

#### Beispiel-Scriptcode

##### Consent-basiertes Laden von JS

```html
<script type="text/plain" data-cookiecategory="analytics" src="analytics.js" defer></script>

<script type="text/plain" data-cookiecategory="ads">
    console.log('"ads" category accepted');
</script>
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

Siehe <https://github.com/orestbida/iframemanager#configuration-options>.

#### Weitere API-Methoden

Siehe <https://github.com/orestbida/cookieconsent#api-methods> und <https://github.com/orestbida/iframemanager#apis>.

## Lizenz

MIT Lizenz, siehe [LICENSE.md](https://github.com/alexplusde/wenns_sein_muss/blob/master/LICENSE.md)  

## Autoren

**Alexander Walther**  
http://www.alexplus.de  
https://github.com/alexplusde  

**Projekt-Lead**  
[Alexander Walther](https://github.com/alexplusde)

## Credits

* <https://github.com/orestbida/cookieconsent>
* <https://github.com/orestbida/iframemanager>
