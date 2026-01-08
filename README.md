# RockyBotICE - Der drei ![Fragezeichen-Logo](https://sig.rondev.de/logos/dreifragezeichen.svg) Bot
<div align="center">

![Created](https://mini-badges.rondevhub.de/forgejo/RonDevHub/RockyBotICE/created-at/*/*/de) ![GitHub Repo stars](https://mini-badges.rondevhub.de/forgejo/RonDevHub/RockyBotICE/lastcommit/*/*/de) ![GitHub Repo stars](https://mini-badges.rondevhub.de/github/RonDevHub/RockyBotICE/stars/*/*/de) ![GitHub Repo stars](https://mini-badges.rondevhub.de/github/RonDevHub/RockyBotICE/issues/*/*/de) ![GitHub Repo language](https://mini-badges.rondevhub.de/forgejo/RonDevHub/RockyBotICE/language/*/*/de) ![GitHub Repo license](https://mini-badges.rondevhub.de/github/RonDevHub/RockyBotICE/license/*/*/de) ![GitHub Repo release](https://mini-badges.rondevhub.de/github/RonDevHub/RockyBotICE/release/*/*/de) ![GitHub Repo release](https://mini-badges.rondevhub.de/github/RonDevHub/RockyBotICE/forks/*/*/de) ![GitHub Repo downlods](https://mini-badges.rondevhub.de/github/RonDevHub/RockyBotICE/downloads/*/*/de) ![GitHub Repo stars](https://mini-badges.rondevhub.de/github/RonDevHub/RockyBotICE/watchers)

[![Buy me a coffee](https://mini-badges.rondevhub.de/icon/cuptogo/Buy_me_a_Coffee-c1d82f-222/social "Buy me a coffee")](https://www.buymeacoffee.com/RonDev)
[![Buy me a coffee](https://mini-badges.rondevhub.de/icon/cuptogo/ko--fi.com-c1d82f-222/social "Buy me a coffee")](https://ko-fi.com/U6U31EV2VS)
[![Sponsor me](https://mini-badges.rondevhub.de/icon/hearts-red/Sponsor_me/social "Sponsor me")](https://github.com/sponsors/RonDevHub)
[![Pizza Power](https://mini-badges.rondevhub.de/icon/pizzaslice/Buy_me_a_pizza/social "Pizza Power")](https://www.paypal.com/paypalme/Depressionist1/4,99)
</div>

---
> „Die drei ??? übernehmen jeden Fall – und RockyBotICE übernimmt die tägliche Empfehlung.“
---
🎙️ Ein liebevoll gebauter Mastodon-Bot, der täglich eine zufällige Folge der drei ??? auf <a rel="me" href="https://mastodon.social/@RockyBotICE">@RockyBotICE</a> postet – inklusive Cover, Titel, Anbieter-Links und einem passenden Text von Justus, Peter oder Bob.

---

## 🔍 Was macht RockyBotICE?

- Wählt täglich eine zufällige Folge aus allen regulären, Spezial- und Kurzgeschichten
- Vermeidet Wiederholungen (mindestens 100 Tage Abstand)
- Postet einen Toot mit Cover, Titel, Anbieter-Links und einem passenden Text von Justus, Peter oder Bob
- Erstellt eine Zusatzseite mit Informationen und allen Streaming-Anbietern zur Folge (`folge123`)

---

## 🛠️ Wie funktioniert das?

RockyBotICE basiert auf PHP und nutzt die JSON-Daten von [dreimetadaten.de](https://dreimetadaten.de). Die Architektur ist modular aufgebaut:
```
RockyBotICE/ 
├── config/ # Konfiguration inkl. API-Token und Testmodus
├── data/ # JSON-Daten, Logs, Debug-Ausgaben 
├── templates/ # Textbausteine mit Platzhaltern 
├── src/ # Bot-Logik, API-Anbindung, Helferklassen 
├── public/ # Weboberfläche (index.php, folge.php) 
├── cron.php # Einstiegspunkt für den Botlauf 
└── README.md # Diese Datei
```

---

## 🧪 Features

- ✅ Testmodus für sichere Entwicklung
- 🐞 Debug-Log für Fehleranalyse
- 🧩 Platzhaltertexte für individuelle Toots
- 🔐 Cronjob-Schutz via Secret-Token
- 🧵 Erweiterbar mit eigenen Texten, Regeln, Linkseiten oder Statistiken

---

## 📦 Installation

1. Repository klonen
2. `config/config.php` anpassen (Token, Secret, Testmodus)
3. JSON-Dateien in `data/` ablegen oder regelmäßig aktualisieren
4. Cronjob einrichten:
   ```bash
   curl "https://deinserver.de/dreibot/cron.php?secret=DEIN_SECRET"
   ```

---

## 💡 Credits
- Metadaten: [dreimetadaten.de](https://dreimetadaten.de)
- Idee & Umsetzung:
   - [RonDevHub](https://commitcloud.net/RonDevHub)

---

## Verwendung
Bei Verwendung genügt als Namensnennung "RockyBotICE".

Sämtlicher Quellcode steht unter der [MIT License](https://opensource.org/license/MIT).

## 📣 Kontakt
Fragen, Ideen oder Nerdliebe? Melde dich auf [**Matrix Chat**](https://matrix.to/#/#RockyBotICE:matrix.s3cr.net), [**Github Issues**](https://github.com/RonDevHub/RockyBotICE/issues), <a href="https://mastodon.social/@herrstoeckchen">**@herrstoeckchen**</a>, <a rel="me" href="https://mastodon.social/@RockyBotICE">**@RockyBotICE**</a> *(kein Support)*