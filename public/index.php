<?php

use DreiBot\Utils;
use DreiBot\Logger;

require_once __DIR__ . '/../src/Utils.php';
require_once __DIR__ . '/../src/Logger.php';


$config = require __DIR__ . '/../config/config.php';
Logger::init($config);

?>
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <title><?php echo htmlspecialchars($config['botname']); ?> - Der drei ??? Bot</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Die drei ??? übernehmen jeden Fall – und RockyBotICE übernimmt die tägliche Empfehlung.">
  <meta name="keywords" content="drei ???, mastodon, mastodon bot, bot, die drei fragezeichen">
  <link rel="canonical" href="https://rockybotice.rondev.de/">
  <link rel="icon" type="image/png" href="/public/favicon.png">
  <link rel="stylesheet" href="/public/assets/style.css">
</head>
<?php require_once __DIR__ . '/../public/_modals.php'; ?>
<body>

  <div class="card2">
    <h1>
      <?php echo htmlspecialchars($config['botname']); ?> - Der drei <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 119.24 59.599"><text xml:space="preserve" x="104.119" y="76.886" fill="#2a7fff" fill-opacity=".917" stroke="#000" font-family="'DejaVu Math TeX Gyre'" font-size="81.64" text-anchor="middle" transform="translate(-43.924 -18.384)"><tspan x="104.119" y="76.886" fill-opacity=".918" font-family="'SF Pro Display'" style="font-variant-caps:normal;font-variant-east-asian:normal;font-variant-ligatures:normal;font-variant-numeric:normal"><tspan fill="#e2001a">?</tspan><tspan fill="#009ee0">?</tspan><tspan fill="#fff">?</tspan></tspan></text></svg> Bot
    </h1>

    <p>
      Willkommen auf der Projektseite des <strong>Drei ??? Bots</strong>!<br>
      Dieser kleine Bot postet regelmäßig eine zufällige Folge der <em>drei ???</em> auf <a rel="me" rel="noopener noreferrer" target="_blank" href="https://mastodon.social/@RockyBotICE">@RockyBotICE</a> - inklusive Cover, Titel, Anbieter-Links und einem passenden Text von Justus, Peter oder Bob.
    </p>

    <h2>🔍 Was macht der Bot?</h2>
    <ul>
      <li>Wählt täglich eine zufällige Folge aus allen regulären, Spezial- und Kurzgeschichten</li>
      <li>Vermeidet Wiederholungen (mindestens 150 Tage Abstand)</li>
      <li>Postet einen liebevoll formulierten Toot mit Cover und Streaming-Links</li>
      <li>Erstellt eine <a href="folge123" rel="noopener noreferrer" target="_blank">Zusatzseite mit allen Anbietern</a> zur Folge</li>
    </ul>

    <h2>🛠️ Wie funktioniert das?</h2>
    <p>
      Der Bot nutzt die JSON-Daten von <a href="https://dreimetadaten.de" rel="noopener noreferrer" target="_blank">dreimetadaten.de</a>, kombiniert sie mit eigenen Textbausteinen und postet über die Mastodon-API. Das Ganze läuft automatisiert per Cronjob.
    </p>

    <h2>📦 Open Source</h2>
    <p>
      Der Code ist offen und modular aufgebaut - ideal für eigene Bots oder Projekte rund um Hörspiele. Du findest alles auf GitHub & Co:
      <br>
      <a href="https://commitcloud.net/RonDevHub/RockyBotICE" rel="noopener noreferrer" target="_blank">➡️ CommitCloud</a><br>
      <a href="https://codeberg.org/RonDevHub/RockyBotICE" rel="noopener noreferrer" target="_blank">➡️ Codeberg</a><br>
      <a href="https://github.com/RonDevHub/RockyBotICE" rel="noopener noreferrer" target="_blank">➡️ GitHub</a><br>
      <a href="https://gitlab.com/RonDevHub/RockyBotICE" rel="noopener noreferrer" target="_blank">➡️ GitLab</a>
    </p>

    <h2>⚙️ Verwendung</h2>
    <p>
      Bei Verwendung genügt als Namensnennung "<?php echo htmlspecialchars($config['botname']); ?>" und "dreimetadaten.de".<br>
      <code>&lt;a href="https://rockybotice.rondev.de/"&gt;<?php echo htmlspecialchars($config['botname']); ?>&lt;/a&gt;</code>
    </p>

    <div class="back">
      <a href="<?php echo htmlspecialchars($config['base_url']); ?>" rel="noopener noreferrer" style="margin-right: 20px;"><svg xmlns="http://www.w3.org/2000/svg" height="3em" viewBox="0 0 640 512">
          <path style="fill:#f3f4f7;opacity:.4" d="M48 96c0 85.4 0 170.7 0 256 .1 26.6 21.5 48 48 48l43.3 0c10.4-36.9 44.4-64 84.7-64s74.2 27.1 84.7 64l27.3 0 0-232c0-22.1 17.9-40 40-40l48 0c22.1 0 40 17.9 40 40l0 232 64 0 0-240c0-61.9-50.1-112-112-112L96 48C69.5 48 48 69.5 48 96zm80 72c0-22.1 17.9-40 40-40l48 0c22.1 0 40 17.9 40 40l0 48c0 22.1-17.9 40-40 40l-48 0c-22.1 0-40-17.9-40-40l0-48z" />
          <path style="fill:#f3f4f7;opacity:1" d="M96 48C69.5 48 48 69.5 48 96l0 256c0 26.5 21.5 48 48 48l43.3 0c10.4-36.9 44.4-64 84.7-64s74.2 27.1 84.7 64l27.3 0 0-232c0-22.1 17.9-40 40-40l48 0c22.1 0 40 17.9 40 40l0 232 64 0 0-240c0-61.9-50.1-112-112-112L96 48zm40.4 368L96 416c-35.3 0-64-28.7-64-64L32 96c0-35.3 28.7-64 64-64l320 0c70.7 0 128 57.3 128 128l0 240 88 0c4.4 0 8 3.6 8 8s-3.6 8-8 8l-320.4 0c.2 2.6 .4 5.3 .4 8 0 48.6-39.4 88-88 88s-88-39.4-88-88c0-2.7 .1-5.4 .4-8zM352 400l96 0 0-128-40 0c-4.4 0-8-3.6-8-8s3.6-8 8-8l40 0 0-88c0-13.3-10.7-24-24-24l-48 0c-13.3 0-24 10.7-24 24l0 232zM216 144l-48 0c-13.3 0-24 10.7-24 24l0 48c0 13.3 10.7 24 24 24l48 0c13.3 0 24-10.7 24-24l0-48c0-13.3-10.7-24-24-24zm-48-16l48 0c22.1 0 40 17.9 40 40l0 48c0 22.1-17.9 40-40 40l-48 0c-22.1 0-40-17.9-40-40l0-48c0-22.1 17.9-40 40-40zm56 368a72 72 0 1 0 0-144 72 72 0 1 0 0 144z" />
        </svg></a>
      <a href="#" data-modal="donateModal" target="_blank" style="margin-right: 20px;"><svg xmlns="http://www.w3.org/2000/svg" height="3em" viewBox="0 0 576 512">
          <path style="fill:#ff0000;opacity:.4" d="M.5 148.8c7.1 80.9 85.5 149.2 158.1 197.1-10.4-28.5-15.9-59-13.1-90.7 7.1-81.3 78.8-141.5 160.2-134.4 28 2.5 54.3 12.8 76.2 29.3 1.7-11.5 2.2-23.1 1.2-34.7-4.8-54.9-53.2-95.6-108.2-90.8-31.9 2.8-60.6 20.7-77 48.2l-9.8 16.5-12.6-14.5c-21-24.2-52.3-36.9-84.2-34.1-54.9 4.8-95.6 53.2-90.8 108.2z" />
          <path style="fill:#ff0000;opacity:1" d="M301.5 168.6c31.9 2.8 60.6 20.7 77 48.2l9.8 16.5 12.6-14.5c21-24.2 52.3-36.9 84.2-34.1 54.9 4.8 95.6 53.2 90.8 108.2-8.9 102.2-131.7 184.3-212.9 230.5-72-59.5-178.6-161.7-169.6-263.9 4.8-54.9 53.2-95.6 108.2-90.8z" />
        </svg></a>
        <a href="#" data-modal="contactModal" target="_blank" style="margin-right: 20px;"><svg xmlns="http://www.w3.org/2000/svg" height="3em" viewBox="0 0 512 512">
          <path style="fill:var(--fa-secondary-color,currentColor);opacity:var(--fa-secondary-opacity,.4)" d="M32 122.5c0 8.4 4 16.4 10.8 21.4L227.6 279.3c16.9 12.4 39.9 12.4 56.8 0L469.2 143.8c6.8-5 10.8-12.9 10.8-21.4 0-14.6-11.9-26.5-26.5-26.5l-395 0C43.9 96 32 107.9 32 122.5zm0 53.1L32 384c0 17.7 14.3 32 32 32l384 0c17.7 0 32-14.3 32-32l0-208.4-176.7 129.6c-28.2 20.6-66.5 20.6-94.6 0L32 175.6z"/>
          <path style="fill:var(--fa-primary-color,currentColor);opacity:var(--fa-primary-opacity,1)" d="M0 122.5l0-2.5 .1 0C1.3 88.9 27 64 58.5 64l395 0c31.5 0 57.1 24.9 58.4 56l.1 0 0 264c0 35.3-28.7 64-64 64L64 448c-35.3 0-64-28.7-64-64L0 122.5zm480 53.1L303.3 305.1c-28.2 20.6-66.5 20.6-94.6 0L32 175.6 32 384c0 17.7 14.3 32 32 32l384 0c17.7 0 32-14.3 32-32l0-208.4zm0-53.1c0-14.6-11.9-26.5-26.5-26.5l-395 0c-14.6 0-26.5 11.9-26.5 26.5 0 8.4 4 16.4 10.8 21.4L227.6 279.3c16.9 12.4 39.9 12.4 56.8 0L469.2 143.8c6.8-5 10.8-12.9 10.8-21.4z"/>
        </svg></a>
      <a href="#" data-modal="infoModal" target="_blank" style="margin-right: 20px;"><svg xmlns="http://www.w3.org/2000/svg" height="3em" viewBox="0 0 512 512">
          <path style="fill:var(--fa-secondary-color,currentColor);opacity:var(--fa-secondary-opacity,.4)" d="M16 256a240 240 0 1 0 480 0 240 240 0 1 0 -480 0zm184-40c0-4.4 3.6-8 8-8l48 0c4.4 0 8 3.6 8 8l0 136 40 0c4.4 0 8 3.6 8 8s-3.6 8-8 8l-96 0c-4.4 0-8-3.6-8-8s3.6-8 8-8l40 0 0-128-40 0c-4.4 0-8-3.6-8-8zm72-56a16 16 0 1 1 -32 0 16 16 0 1 1 32 0z" />
          <path style="fill:var(--fa-primary-color,currentColor);opacity:var(--fa-primary-opacity,1)" d="M256 16a240 240 0 1 1 0 480 240 240 0 1 1 0-480zm0 496a256 256 0 1 0 0-512 256 256 0 1 0 0 512zM208 352c-4.4 0-8 3.6-8 8s3.6 8 8 8l96 0c4.4 0 8-3.6 8-8s-3.6-8-8-8l-40 0 0-136c0-4.4-3.6-8-8-8l-48 0c-4.4 0-8 3.6-8 8s3.6 8 8 8l40 0 0 128-40 0zm48-176a16 16 0 1 0 0-32 16 16 0 1 0 0 32z" />
        </svg></a>
    </div>

    <div class="footer">
      <p>Made with ❤️ and ☕️ - powered by <a rel="me" href="https://mastodon.social/@herrstoeckchen" rel="noopener noreferrer" target="_blank">@herrstoeckchen</a>, PHP und den drei ???</p>
    </div>
  </div>
</body>
<script src="/public/assets/scripts.js" crossorigin="anonymous"></script>

</html>