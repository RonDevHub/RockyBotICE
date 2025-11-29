<?php
use DreiBot\Utils;
use DreiBot\Logger;

require_once __DIR__ . '/../src/Utils.php';
require_once __DIR__ . '/../src/Logger.php';

$config = require __DIR__ . '/../config/config.php';
Logger::init($config);

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    echo "<h1>Ungültige ID</h1>";
    exit;
}

$map = [
    'Serie.json' => 'serie',
    'Spezial.json' => 'spezial',
    'Kurzgeschichten.json' => 'kurzgeschichten'
];

$folge = null;
$typ = 'Unbekannt';
$typBadgeColor = '#888';

foreach ($map as $file => $key) {
    $path = $config['data_path'] . $file;
    $json = json_decode(file_get_contents($path), true);
    $list = $json[$key] ?? [];

    foreach ($list as $f) {
        if (($f['ids']['dreimetadaten'] ?? null) == $id) {
            $folge = $f;

            // Typ bestimmen
            $typMap = [
                'serie' => 'Serie',
                'spezial' => 'Spezial',
                'kurzgeschichten' => 'Kurzgeschichte'
            ];
            $typ = $typMap[$key] ?? 'Unbekannt';

            // Farbe für Badge setzen
            $typColor = [
                'Serie' => '#1DB954',           // grün
                'Spezial' => '#FF9900',         // orange
                'Kurzgeschichte' => '#009ee0',  // blau
                'Unbekannt' => '#888'
            ];
            $typBadgeColor = $typColor[$typ] ?? '#888';

            break 2;
        }
    }
}

if (!$folge) {
    echo "<h1>Folge nicht gefunden</h1>";
    exit;
}

$titel = htmlspecialchars($folge['titel'] ?? 'Unbekannt');
$nummer = $folge['nummer'] ?? '-';
$cover = $folge['links']['cover'] ?? null;
$beschreibung = $folge['beschreibung'] ?? '';
$datum = $folge['veröffentlichungsdatum'] ?? '';
$links = $folge['links'] ?? [];
$dauer = $folge['gesamtdauer'] ?? 0; // Millisekunden

// Umrechnung
$sekunden = floor($dauer / 1000);
$stunden  = floor($sekunden / 3600);
$minuten  = floor(($sekunden % 3600) / 60);

function linkButton($name, $url, $svg) {
    if (!$url) return '';
    $safe = htmlspecialchars($url);
    return "<a href=\"$safe\" target=\"_blank\" class=\"link\">
        <span class=\"icon\">$svg</span>
        <span class=\"label\">$name</span>
    </a>";
}

// SVG-Icons (minimalistisch, inline)
$icons = [
    'Spotify' => '<svg width="32" height="32" xmlns="http://www.w3.org/2000/svg" xml:space="preserve" viewBox="0 0 512 512"><path d="M256 0C114.7 0 0 114.7 0 256s114.7 256 256 256 256-114.7 256-256S397.3 0 256 0" style="fill:#1ed760"/><path d="M419.7 230.3c-5.4 0-8.7-1.3-13.3-4-73.5-43.9-204.9-54.4-290-30.7-3.7 1-8.4 2.7-13.3 2.7-13.6 0-24.1-10.6-24.1-24.4 0-14 8.7-22 18-24.7 36.3-10.6 77-15.7 121.3-15.7 75.4 0 154.3 15.7 212 49.3 8.1 4.6 13.3 11 13.3 23.3.1 14.2-11.3 24.2-23.9 24.2m-32 78.7c-5.4 0-9-2.4-12.7-4.3-64.5-38.2-160.7-53.6-246.3-30.3-5 1.3-7.6 2.7-12.3 2.7-11 0-20-9-20-20s5.4-18.4 16-21.4c28.7-8.1 58-14 101-14 67 0 131.7 16.6 182.7 47 8.4 5 11.7 11.4 11.7 20.3-.2 11-8.8 20-20.1 20m-27.8 67.7c-4.3 0-7-1.3-11-3.7-64.4-38.8-139.4-40.5-213.4-25.3-4 1-9.3 2.7-12.3 2.7-10 0-16.3-7.9-16.3-16.3 0-10.6 6.3-15.7 14-17.3 84.5-18.7 170.9-17 244.6 27 6.3 4 10 7.6 10 17s-7.2 15.9-15.6 15.9"/></svg>',
    'Deezer' => '<svg width="32" height="32" xmlns="http://www.w3.org/2000/svg" xml:space="preserve" id="Layer_1" x="0" y="0" version="1.1" viewBox="-0.02 0 277.13 277.12"><style id="style2" type="text/css">.st0{fill:#a238ff}</style><g id="g10" transform="translate(-13.9)"><path id="path4" d="M21.9 115.7c4.4 0 8-14.5 8-32.4s-3.6-32.4-8-32.4-8 14.5-8 32.4 3.6 32.4 8 32.4" class="st0"/><path id="path6" d="M256.8 18c-4.2 0-7.9 9.3-10.5 24.2C242.1 16.7 235.4 0 227.8 0c-9 0-16.9 23.5-20.6 57.7C203.5 32.9 198 17 191.9 17c-8.6 0-16 31.2-18.7 74.7-5.1-22.3-12.5-36.3-20.7-36.3s-15.6 14-20.7 36.3C129 48.2 121.7 17 113 17c-6.2 0-11.7 15.9-15.3 40.8C94 23.5 86.2 0 77.1 0c-7.6 0-14.4 16.7-18.5 42.3C56 27.4 52.3 18 48.1 18 40.3 18 34 50.5 34 90.5s6.3 72.4 14.1 72.4c3.2 0 6.2-5.5 8.5-14.7 3.7 33.8 11.5 57 20.5 57 7 0 13.2-13.9 17.4-35.9 2.9 41.8 10.1 71.5 18.5 71.5 5.3 0 10.1-11.8 13.7-30.9 4.3 39.5 14.2 67.2 25.8 67.2s21.5-27.7 25.8-67.2c3.6 19.1 8.4 30.9 13.7 30.9 8.4 0 15.6-29.7 18.5-71.5 4.2 22 10.4 35.9 17.4 35.9 9 0 16.8-23.2 20.5-57 2.4 9.2 5.3 14.7 8.5 14.7 7.8 0 14.1-32.4 14.1-72.4-.2-40-6.5-72.5-14.2-72.5" class="st0"/><path id="path8" d="M283 115.7c4.4 0 8-14.5 8-32.4s-3.6-32.4-8-32.4-8 14.5-8 32.4 3.6 32.4 8 32.4" class="st0"/></g></svg>',
    'Apple Music' => '<svg width="32" height="32" xmlns="http://www.w3.org/2000/svg" xml:space="preserve" viewBox="0 0 512 512"><linearGradient id="a" x1="256" x2="256" y1="2.978" y2="501.959" gradientTransform="matrix(1 0 0 -1 0 513)" gradientUnits="userSpaceOnUse"><stop offset="0" style="stop-color:#fa233b"/><stop offset="1" style="stop-color:#fb5c74"/></linearGradient><path d="M512 160.2v-18.3c0-5.1-.1-10.3-.2-15.4-.3-11.2-1-22.5-3-33.6-2-11.3-5.3-21.7-10.5-32-5.1-10.1-11.8-19.2-19.8-27.2S461.3 19 451.3 13.9c-10.2-5.2-20.7-8.5-32-10.5-11.1-2-22.4-2.7-33.6-3-5.1-.1-10.3-.2-15.4-.2H141.9c-5.1 0-10.3.1-15.4.2-11.2.3-22.5 1-33.6 3-11.3 2-21.7 5.3-32 10.5C50.8 19 41.6 25.7 33.7 33.7s-14.8 17-19.9 27.1C8.5 71 5.2 81.5 3.2 92.8c-2 11.1-2.7 22.4-3 33.6-.1 5.1-.2 10.3-.2 15.4v228.3c0 5.1.1 10.3.2 15.4.3 11.2 1 22.5 3 33.6 2 11.3 5.3 21.7 10.5 32 5.1 10.1 11.8 19.2 19.8 27.2s17.2 14.7 27.2 19.8c10.2 5.2 20.7 8.5 32 10.5 11.1 2 22.4 2.7 33.6 3 5.1.1 10.3.2 15.4.2H370c5.1 0 10.3-.1 15.4-.2 11.2-.3 22.5-1 33.6-3 11.3-2 21.7-5.3 32-10.5 10.1-5.1 19.3-11.8 27.2-19.8s14.7-17.2 19.8-27.2c5.2-10.2 8.5-20.7 10.5-32 2-11.1 2.7-22.4 3-33.6.1-5.1.2-10.3.2-15.4v-18.3z" style="fill-rule:evenodd;clip-rule:evenodd;fill:url(#a)"/><path d="M362 78.2c-1.2.1-12.2 2.1-13.6 2.3l-152.2 30.7h-.1c-4 .8-7.1 2.2-9.5 4.3-2.9 2.4-4.5 5.9-5.1 9.9-.1.9-.3 2.6-.3 5.1V321c0 4.5-.4 8.8-3.4 12.5s-6.7 4.8-11.1 5.7c-3.3.7-6.6 1.3-9.9 2-12.6 2.5-20.8 4.3-28.2 7.1-7.1 2.7-12.4 6.2-16.6 10.7-8.4 8.8-11.8 20.7-10.6 31.8 1 9.5 5.3 18.6 12.6 25.3 5 4.6 11.2 8 18.5 9.5 7.6 1.5 15.7 1 27.5-1.4 6.3-1.3 12.2-3.2 17.8-6.6 5.5-3.3 10.3-7.6 14-13 3.7-5.3 6.1-11.3 7.5-17.6 1.4-6.5 1.7-12.4 1.7-18.9v-165c0-8.8 2.5-11.2 9.6-12.9 0 0 126.5-25.5 132.4-26.7 8.2-1.6 12.1.8 12.1 9.4v112.8c0 4.5 0 9-3.1 12.7-3 3.7-6.7 4.8-11.1 5.7-3.3.7-6.6 1.3-9.9 2-12.6 2.5-20.8 4.3-28.2 7.1-7.1 2.7-12.4 6.2-16.6 10.7-8.4 8.8-12.1 20.7-10.9 31.8 1 9.5 5.6 18.6 12.9 25.3 5 4.6 11.2 7.9 18.5 9.4 7.6 1.5 15.7 1 27.5-1.4 6.3-1.3 12.2-3.2 17.8-6.5 5.5-3.3 10.3-7.6 14-13 3.7-5.3 6.1-11.3 7.5-17.6 1.4-6.5 1.4-12.4 1.4-18.9V91.7c-.1-8.8-4.7-14.2-12.9-13.5" style="fill-rule:evenodd;clip-rule:evenodd;fill:#fff"/></svg>',
    'Amazon Music' => '<svg width="32" height="32" xmlns="http://www.w3.org/2000/svg" xml:space="preserve" id="Layer_1" x="0" y="0" version="1.1" viewBox="0 0 512 512"><style>.st0{fill:#f90}.st1{fill-rule:evenodd;clip-rule:evenodd}</style><path fill="#fff" d="M443.4 421.5C232.1 522 100.9 437.9 16.9 386.8c-5.2-3.2-14 .8-6.4 9.6C38.6 430.3 130.2 512 249.9 512s191-65.3 199.9-76.7c8.8-11.3 2.5-17.6-6.4-13.8m59.3-32.8c-5.7-7.4-34.5-8.8-52.7-6.5-18.2 2.2-45.5 13.3-43.1 19.9 1.2 2.5 3.7 1.4 16.2.3 12.5-1.2 47.6-5.7 54.9 3.9s-11.2 55.4-14.6 62.8c-3.3 7.4 1.2 9.3 7.4 4.4 6.1-4.9 17-17.7 24.4-35.7 7.4-18.2 11.8-43.5 7.5-49.1" class="st0"/><path fill="#fff" d="M301.3 216.3c0 26.4.7 48.4-12.7 71.8-10.8 19.1-27.8 30.8-46.9 30.8-26 0-41.2-19.8-41.2-49.1 0-57.7 51.7-68.2 100.7-68.2v14.7zm68.3 165.1c-4.5 4-11 4.3-16 1.6-22.5-18.7-26.5-27.3-38.9-45.2-37.2 37.9-63.4 49.3-111.7 49.3-57 0-101.4-35.2-101.4-105.6 0-55 29.8-92.4 72.2-110.7 36.8-16.2 88.1-19.1 127.4-23.5v-8.8c0-16.1 1.2-35.2-8.2-49.1-8.3-12.5-24.1-17.6-38-17.6-25.8 0-48.9 13.2-54.5 40.7-1.1 6.1-5.6 12.1-11.7 12.4l-65.7-7c-5.5-1.2-11.6-5.7-10.1-14.2C128.2 24 200.1 0 264.5 0c33 0 76 8.8 102 33.7 33 30.8 29.8 71.8 29.8 116.5v105.6c0 31.7 13.1 45.6 25.5 62.8 4.4 6.1 5.3 13.4-.2 18-13.8 11.5-38.4 33-51.9 45z" class="st1"/><path fill="#fff" d="M443.4 421.5C232.1 522 100.9 437.9 16.9 386.8c-5.2-3.2-14 .8-6.4 9.6C38.6 430.3 130.2 512 249.9 512s191-65.3 199.9-76.7c8.8-11.3 2.5-17.6-6.4-13.8m59.3-32.8c-5.7-7.4-34.5-8.8-52.7-6.5-18.2 2.2-45.5 13.3-43.1 19.9 1.2 2.5 3.7 1.4 16.2.3 12.5-1.2 47.6-5.7 54.9 3.9s-11.2 55.4-14.6 62.8c-3.3 7.4 1.2 9.3 7.4 4.4 6.1-4.9 17-17.7 24.4-35.7 7.4-18.2 11.8-43.5 7.5-49.1" class="st0"/><path fill="#fff" d="M301.3 216.3c0 26.4.7 48.4-12.7 71.8-10.8 19.1-27.8 30.8-46.9 30.8-26 0-41.2-19.8-41.2-49.1 0-57.7 51.7-68.2 100.7-68.2v14.7zm68.3 165.1c-4.5 4-11 4.3-16 1.6-22.5-18.7-26.5-27.3-38.9-45.2-37.2 37.9-63.4 49.3-111.7 49.3-57 0-101.4-35.2-101.4-105.6 0-55 29.8-92.4 72.2-110.7 36.8-16.2 88.1-19.1 127.4-23.5v-8.8c0-16.1 1.2-35.2-8.2-49.1-8.3-12.5-24.1-17.6-38-17.6-25.8 0-48.9 13.2-54.5 40.7-1.1 6.1-5.6 12.1-11.7 12.4l-65.7-7c-5.5-1.2-11.6-5.7-10.1-14.2C128.2 24 200.1 0 264.5 0c33 0 76 8.8 102 33.7 33 30.8 29.8 71.8 29.8 116.5v105.6c0 31.7 13.1 45.6 25.5 62.8 4.4 6.1 5.3 13.4-.2 18-13.8 11.5-38.4 33-51.9 45z" class="st1"/></svg>',
    'YouTube Music' => '<svg width="32" height="32" xmlns="http://www.w3.org/2000/svg" xml:space="preserve" viewBox="0 0 176 176"><circle cx="88" cy="88" r="88" fill="red"/><path fill="#FFF" d="M88 46c23.1 0 42 18.8 42 42s-18.8 42-42 42-42-18.8-42-42 18.9-42 42-42m0-4c-25.4 0-46 20.6-46 46s20.6 46 46 46 46-20.6 46-46-20.6-46-46-46"/><path fill="#FFF" d="m72 111 39-24-39-22z"/></svg>',
    'BookBeat' => '<svg width="32" height="32" viewBox="0 0 920.2 143.2" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><path d="M10.4 127.7V14.1c0-7.4-4.4-9-9.4-9.6V.9h50.4c24.8 0 50.4 7 50.4 27.8 0 14.6-13 25.2-28.8 25.8 27.8 0 47.4 16.8 47.4 41.8 0 28.2-22.6 44.6-62.8 44.6H1v-3.6c4.8-.6 9.4-2.2 9.4-9.6m62.2-98.6C72.6 13.9 62 6.7 51.8 6.7H48v46.8c11.2 0 24.6-6.8 24.6-24.4M53 135.1c8.2 0 27-5.8 27-38.8 0-33.6-25.6-37-32-37v75.8zM130.6 86.5c0-33.8 24.4-57.6 59.2-57.6 32.6 0 53.6 23 53.6 55.6 0 34.2-25.6 57.4-59 57.4-31.8 0-53.8-22.8-53.8-55.4m56.8 50c11.4 0 16.4-27.4 16.2-52.6-.2-25.8-5.6-49.6-16.8-49.6-12.4 0-16 24.2-16.4 52.8-.4 22.6 4.8 49.4 17 49.4M254 86.5c0-33.8 24.4-57.6 59.2-57.6 32.6 0 53.6 23 53.6 55.6 0 34.2-25.6 57.4-59 57.4-31.8 0-53.8-22.8-53.8-55.4m56.8 50c11.4 0 16.4-27.4 16.2-52.6-.2-25.8-5.6-49.6-16.8-49.6-12.4 0-16 24.2-16.4 52.8-.4 22.6 4.8 49.4 17 49.4M378.6 127.5V25.9c0-4.8-1.2-8.8-9.4-9.6v-3.6L411 1.5h3.6v64.8l30.8-23.4c6.2-4.8 2.2-8.4-4.6-9.2v-3.6h42v3.6c-10 0-22.2 7.4-33.4 15.4l29.4 75.4c3.6 9.2 9.4 11.6 17 12.8v3.6H436v-3.6c4.4-1 8.4-4.6 6-11l-21.6-55.6-5.8 4.4v52.4c0 7.4 4 9.2 9.4 9.8v3.6h-54.8v-3.6c5.2-.6 9.4-2.4 9.4-9.8M507.8 127.7V14.1c0-7.4-4.4-9-9.4-9.6V.9h50.4c24.8 0 50.4 7 50.4 27.8 0 14.6-13 25.2-28.8 25.8 27.8 0 47.4 16.8 47.4 41.8 0 28.2-22.6 44.6-62.8 44.6h-56.6v-3.6c4.8-.6 9.4-2.2 9.4-9.6M570 29.1c0-15.2-10.6-22.4-20.8-22.4h-3.8v46.8c11.2 0 24.6-6.8 24.6-24.4m-19.6 106c8.2 0 27-5.8 27-38.8 0-33.6-25.6-37-32-37v75.8zM626 88.3c0-34.2 26.8-59.4 56.2-59.4 30.4 0 43 17.4 42.8 43.8h-62.2c.2 29.2 11.2 45 34 45 11 0 19.4-4.2 25-13l3 2c-7.8 19.8-20.6 35.4-46 35.4-32.2 0-52.8-25.2-52.8-53.8m67.2-22c-.6-17-4.8-32-13.8-32-9.8 0-16.2 17.6-16.6 32zM786.8 74.5V56.9c0-14.2-4-22.2-10.8-22.2-11.2 0-15.8 18.6-12.8 37.8H733c-1.2-20.2 9-43.6 44.4-43.6 28.6 0 45.4 12.6 45.4 37.4v47.2c0 6.6 2.6 12.2 9.2 12.2 2.6 0 4.6-.8 6.6-2.2l2.2 2.4c-6.4 9.8-17 16-31.2 16-9 0-17.2-3-22.4-15.6-12.2 11.2-22.8 15.6-33.4 15.6-15.6 0-22.2-11.8-22.2-22 0-15 9.4-25.8 55.2-45.4m-25 32.8c0 18.8 18.6 18.4 25 14.2V80.7c-12.6 6.2-25 13.2-25 26.6M885.8 30.1h26.8v14h-27.2v60.6c0 11 4.4 15.8 15.4 15.8 5.4 0 11.8-1.8 16.2-5l2.2 2.4c-7.6 14.2-23 24-38.4 24-10.8 0-18.8-2.8-23.6-7.6-5.6-5.6-7.8-12.6-7.8-23.8V44.1h-13v-3.8l45.8-29h3.6z"></path></svg>',
    'Produktseite' => '<svg width="32" height="32" xmlns="http://www.w3.org/2000/svg" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 512 512.001"><path fill="#EF4136" d="M145.306 0h221.391C446.616 0 512 65.384 512 145.306v221.392c0 79.918-65.384 145.303-145.303 145.303H145.306C65.384 512.001 0 446.616 0 366.698V145.306C0 65.384 65.384 0 145.306 0z"/><path fill="#FF7C73" d="M145.306 0h221.391c71.688 0 131.669 52.627 143.267 121.139-21.611-57.815-77.517-99.278-142.629-99.278H135.471c-48.991 0-92.773 23.473-120.653 59.722C38.534 33.379 88.206 0 145.306 0z"/><path fill="#fff" fill-rule="nonzero" d="M155.74 260.236v-12.714c0-27.581 11.28-52.652 29.444-70.815 18.163-18.164 43.236-29.444 70.814-29.444 27.582 0 52.652 11.28 70.816 29.444 18.168 18.168 29.445 43.236 29.445 70.815v12.714c24.474.68 44.108 20.73 44.108 45.369 0 25.065-20.321 45.387-45.387 45.387-19.416 0-25.938-3.824-25.938-21.074v-39.109c0-14.616-1.012-23.743 7.945-27.916v-15.371c0-22.259-9.117-42.508-23.799-57.19-14.682-14.681-34.928-23.796-57.187-23.796-22.262 0-42.511 9.115-57.192 23.796-14.682 14.682-23.796 34.928-23.796 57.19v15.322c8.408 3.897 7.944 12.288 7.944 26.214v42.601c0 16.262-8.847 19.333-25.937 19.333-25.066 0-45.388-20.322-45.388-45.387 0-24.639 19.635-44.689 44.108-45.369z"/></svg>',
    'datum' => '<svg width="14" height="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 432 540"><path fill="currentColor" d="M234 36c0-9.9-8.1-18-18-18s-18 8.1-18 18l0 18-72 0 0-18c0-9.9-8.1-18-18-18S90 26.1 90 36l0 18-18 0C32.2 54 0 86.2 0 126L0 432c0 39.8 32.2 72 72 72l288 0c39.8 0 72-32.2 72-72l0-306c0-39.8-32.2-72-72-72l-18 0 0-18c0-9.9-8.1-18-18-18s-18 8.1-18 18l0 18-72 0 0-18zM90 90l0 18c0 9.9 8.1 18 18 18s18-8.1 18-18l0-18 72 0 0 18c0 9.9 8.1 18 18 18s18-8.1 18-18l0-18 72 0 0 18c0 9.9 8.1 18 18 18s18-8.1 18-18l0-18 18 0c19.9 0 36 16.1 36 36l0 54-360 0 0-54c0-19.9 16.1-36 36-36l18 0zM36 216l360 0 0 180c0 19.9-16.1 36-36 36L72 432c-19.9 0-36-16.1-36-36l0-180z"/></svg>',
    'time' => '<svg width="14" height="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 504 540"><path fill="currentColor" d="M270 108c0-9.9-8.1-18-18-18s-18 8.1-18 18l0 129.1c0 14.3 5.7 28.1 15.8 38.2l61.5 61.5c7 7 18.4 7 25.5 0s7-18.4 0-25.5l-61.5-61.5c-3.4-3.4-5.3-8-5.3-12.7L270 108zM252 0C112.8 0 0 112.8 0 252l0 36C0 427.2 112.8 540 252 540S504 427.2 504 288l0-36C504 112.8 391.2 0 252 0zm0 468a216 216 0 1 1 0-432 216 216 0 1 1 0 432z"/></svg>',
];
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title><?php echo $titel; ?> - Drei ???</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="/public/favicon.png">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: system-ui, sans-serif;
            background: radial-gradient(circle at top, #1a1a1a, #000);
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            padding: 2em;
            max-width: 500px;
            width: 90%;
            box-shadow: 0 0 30px rgba(0,0,0,0.4);
            text-align: center;
        }
        .card h1 {
            font-size: 1.4em;
            margin-bottom: 0.3em;
        }
        .card p.meta {
            font-size: 0.9em;
            color: #ccc;
            margin-bottom: 1em;
        }
        .cover {
            width: 100%;
            border-radius: 10px;
            margin-bottom: 1em;
        }
        .beschreibung {
            font-size: 0.95em;
            color: #ddd;
            margin-bottom: 1.5em;
            text-align: left;
            white-space: pre-line;
        }
        .link {
            display: flex;
            align-items: center;
            gap: 0.6em;
            background: rgba(255,255,255,0.1);
            padding: 0.6em 1em;
            margin: 0.4em 0;
            border-radius: 10px;
            text-decoration: none;
            color: #fff;
            transition: background 0.2s ease;
        }
        .link:hover {
            background: rgba(255,255,255,0.2);
        }
        .icon svg {
            vertical-align: middle;
        }
        .label {
            flex: 1;
            text-align: left;
        }
        .back {
            margin-top: 2em;
            font-size: 0.8em;
            color: #aaa;
        }
        .back a {
            color: #aaa;
            text-decoration: underline;
        }
        .badge {
            display: inline-block;
            padding: 0.3em 0.7em;
            border-radius: 999px;
            font-size: 0.75em;
            font-weight: bold;
            color: #fff;
            margin-bottom: 1em;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        @media (max-width: 600px) {
            .card {
                padding: 1.2em;
            }
            .card h1 {
                font-size: 1.2em;
            }
            .beschreibung {
                font-size: 0.9em;
            }
        }
    </style>
</head>
<body>
    <div class="card">
        <h1><?php echo $titel; ?></h1>
        <p class="meta">
            Folge <?php echo $nummer; ?> · <span class="badge" style="background-color: <?php echo $typBadgeColor; ?>;">
                <?php echo $typ; ?>
            </span>
        </p>

        <?php if ($cover): ?>
            <img src="<?php echo htmlspecialchars($cover); ?>" alt="Cover" class="cover">
        <?php endif; ?>

        <?php if ($datum): ?>
            <span class="badge" style="background-color: #7345fdff; margin-right: 10px;"><?php echo $icons['datum']; ?> <?php echo date('d.m.Y', strtotime($datum)); ?></span> <span class="badge" style="background-color: #b233f7ff;"><?php echo $icons['time']; ?> <?php echo $stunden . " Std " . $minuten . " Min"; ?></span>
        <?php endif; ?>

        <?php if ($beschreibung): ?>
            <div class="beschreibung"><?php echo nl2br(htmlspecialchars($beschreibung)); ?></div>
        <?php endif; ?>

        <?php
            echo linkButton('Spotify', $links['spotify'] ?? null, $icons['Spotify']);
            echo linkButton('Deezer', $links['deezer'] ?? null, $icons['Deezer']);
            echo linkButton('Apple Music', $links['appleMusic'] ?? null, $icons['Apple Music']);
            echo linkButton('Amazon Music', $links['amazonMusic'] ?? null, $icons['Amazon Music']);
            echo linkButton('YouTube Music', $links['youTubeMusic'] ?? null, $icons['YouTube Music']);
            echo linkButton('BookBeat', $links['bookbeat'] ?? null, $icons['BookBeat']);
            echo linkButton('Produktseite', $links['dreifragezeichen'] ?? null, $icons['Produktseite']);
        ?>

        <div class="back">
            <a href="<?php echo htmlspecialchars($config['base_url']); ?>">Zurück zur Startseite</a>
        </div>
        <div class="footer">
           <?php echo date("Y"); ?> - <?php echo htmlspecialchars($config['botname']); ?><br>
           <small><strong>Die drei ??? übernehmen jeden Fall - und <?php echo htmlspecialchars($config['botname']); ?> übernimmt die tägliche Empfehlung.</strong></small>
        </div>
    </div>
</body>
</html>
