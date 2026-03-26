<?php

use DreiBot\Utils;
use DreiBot\Logger;

require_once __DIR__ . '/../src/Utils.php';
require_once __DIR__ . '/../src/Logger.php';

$config = require __DIR__ . '/../config/config.php';
Logger::init($config);

$logPath = __DIR__ . '/../data/log.json';
$currentCaseId = null;

if (file_exists($logPath)) {
    $logData = json_decode(file_get_contents($logPath), true);
    if (!empty($logData)) {
        ksort($logData);
        $currentCaseId = end($logData);
    }
}

$href = $currentCaseId ? "/folge" . $currentCaseId : "#";
?>
<!DOCTYPE html>
<html lang="de" class="scroll-smooth">

<head>
  <meta charset="UTF-8">
  <title><?php echo htmlspecialchars($config['botname']); ?> - Zentrale Rocky Beach</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" type="image/png" href="/public/favicon.png"><meta name="description" content="Die drei ??? übernehmen jeden Fall – und RockyBotICE übernimmt die tägliche Empfehlung.">
  <meta name="keywords" content="drei ???, mastodon, mastodon bot, bot, die drei fragezeichen">
  <link rel="canonical" href="https://rockybotice.rondev.de/">
  <link rel="icon" type="image/png" href="/public/favicon.png">
  <link rel="stylesheet" href="/public/assets/style-v.2.css">
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body x-data="{ infoOpen: false, donateOpen: false, contactOpen: false }" class="min-h-screen flex items-center justify-center p-4 md:p-10">

  <?php require_once __DIR__ . '/../public/_modals.php'; ?>

  <main class="max-w-5xl w-full trailer-shell rounded-[2rem] overflow-hidden relative">

    <div class="absolute top-4 left-4 w-2 h-2 rounded-full bg-zinc-700 shadow-inner"></div>
    <div class="absolute top-4 right-4 w-2 h-2 rounded-full bg-zinc-700 shadow-inner"></div>
    <div class="absolute bottom-4 left-4 w-2 h-2 rounded-full bg-zinc-700 shadow-inner"></div>
    <div class="absolute bottom-4 right-4 w-2 h-2 rounded-full bg-zinc-700 shadow-inner"></div>

    <header class="pt-12 px-8 md:px-16 pb-8 border-b border-zinc-800">
      <div class="inline-block bg-zinc-800 px-8 py-2 file-tab mb-4">
        <span class="text-[10px] uppercase tracking-[0.3em] text-zinc-400 font-sans">Streng Geheim // Fallakte: <?php echo date('Y'); ?></span>
      </div>

      <h1 class="text-4xl md:text-7xl font-black italic uppercase tracking-tighter">
        <span class="text-white">Die drei</span>
        <span class="text-white">?</span><span class="text-[var(--ddf-red)]">?</span><span class="text-[var(--ddf-blue)]">?</span>
      </h1>
      <p class="mt-4 text-zinc-500 max-w-xl text-lg italic">
        "Die drei ??? übernehmen jeden Fall - und <?php echo htmlspecialchars($config['botname']); ?> übernimmt die tägliche Empfehlung." – Zentrale Rocky Beach, Telefon 017...
      </p>
    </header>

    <div class="flex flex-col md:flex-row">
      <div class="flex-1 p-8 md:p-16 space-y-10 border-r border-zinc-800">

        <section class="relative">
          <div class="absolute -left-4 -top-4 opacity-10 pointer-events-none">
            <svg width="100" height="100" viewBox="0 0 512 512" fill="white">
              <path d="M256 0c-141.4 0-256 114.6-256 256s114.6 256 256 256 256-114.6 256-256-114.6-256-256-256zm0 464c-114.7 0-208-93.3-208-208s93.3-208 208-208 208 93.3 208 208-93.3 208-208 208z" />
            </svg>
          </div>
          <h2 class="text-xl font-bold border-b border-zinc-700 pb-2 mb-4 text-zinc-300">🔍 Sachverhalt</h2>
          <p class="text-zinc-400 leading-relaxed">
            Der Bot <?php echo htmlspecialchars($config['botname']); ?> ermittelt täglich in der Hörspiel-Datenbank.
            Ergebnisse werden unmittelbar via Mastodon-Funkspruch an die Öffentlichkeit weitergegeben.
          </p>
        </section>

        <section>
          <h2 class="text-xl font-bold border-b border-zinc-700 pb-2 mb-4 text-zinc-300">📋 Protokoll</h2>
          <ul class="space-y-3 text-sm text-zinc-400">
            <li class="flex items-start gap-3"><span class="text-[var(--ddf-red)]">■</span> 150 Tage Sperrfrist für Wiederholungen.</li>
            <li class="flex items-start gap-3"><span class="text-[var(--ddf-blue)]">■</span> Vollständige Metadaten-Analyse (<a href="https://dreimetadaten.de" target="_blank" class="text-zinc-300 hover:text-[var(--ddf-blue)] underline decoration-zinc-700 hover:decoration-[var(--ddf-blue)] transition-all duration-300">dreimetadaten.de</a>).</li>
            <li class="flex items-start gap-3"><span class="text-white">■</span> Inklusive volständige Fallakte (Cover-Art).</li>
          </ul>
        </section>

        <section class="mt-8">
          <div class="inline-block bg-zinc-800 px-6 py-1 file-tab mb-4">
            <span class="text-[10px] uppercase tracking-widest text-zinc-400 font-sans">System // Repository</span>
          </div>

          <h2 class="text-xl font-bold border-b border-zinc-700 pb-2 mb-4 text-zinc-300">
            🗂️ Quellcode-Archiv
          </h2>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <a href="https://github.com/RonDevHub/RockyBotICE" target="_blank"
              class="flex items-center justify-between p-3 bg-zinc-900/50 border border-zinc-800 rounded-lg hover:border-white transition-all group">
              <div class="flex items-center gap-3">
                <span class="text-xl grayscale group-hover:grayscale-0 transition">🐙</span>
                <span class="text-xs font-bold uppercase tracking-wider">GitHub</span>
              </div>
              <span class="text-[10px] text-zinc-500 font-mono group-hover:text-white">src/main</span>
            </a>

            <a href="https://codeberg.org/RonDevHub/RockyBotICE" target="_blank"
              class="flex items-center justify-between p-3 bg-zinc-900/50 border border-zinc-800 rounded-lg hover:border-blue-400 transition-all group">
              <div class="flex items-center gap-3">
                <span class="text-xl grayscale group-hover:grayscale-0 transition">🏔️</span>
                <span class="text-xs font-bold uppercase tracking-wider">Codeberg</span>
              </div>
              <span class="text-[10px] text-zinc-500 font-mono group-hover:text-blue-400">mirror/git</span>
            </a>
          </div>

          <p class="mt-4 text-[10px] text-zinc-400 italic font-mono leading-tight">
            Hinweis: Der Code ist Open-Source unter der CC-BY-4.0 license archiviert. Zugriff für befugte Ermittler gestattet.
          </p>
        </section>

      </div>

      <aside class="w-full md:w-72 bg-black/30 p-8 flex flex-col justify-between">
        <div class="space-y-6">
          <h3 class="text-xs font-sans font-bold uppercase tracking-widest text-zinc-400">Schaltkonsole</h3>

          <div class="space-y-4">
            <a href="https://mastodon.social/@RockyBotICE"
              target="_blank"
              rel="noopener noreferrer"
              class="block w-full group relative overflow-hidden bg-zinc-800 p-4 rounded-lg border-b-4 border-white active:border-b-0 active:translate-y-1 transition-all text-center">

              <div class="absolute inset-0 bg-gray-50/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300 z-10"></div>

              <span class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-40 transition-all duration-300 pointer-events-none transform group-hover:scale-110 -rotate-12 z-20">
                <span class="border-4 border-white px-2 py-1 text-2xl font-black uppercase text-white tracking-tighter leading-none">Streng Geheim</span>
              </span>

              <span class="relative z-30 text-xs font-bold uppercase text-white">Funksprüche/Mastodon</span>
            </a>

            <button @click="donateOpen = true" class="w-full group relative overflow-hidden bg-zinc-800 p-4 rounded-lg border-b-4 border-red-700 active:border-b-0 active:translate-y-1 transition-all">

              <div class="absolute inset-0 bg-red-600 translate-y-full group-hover:translate-y-0 transition-transform duration-300 z-10"></div>

              <span class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-40 transition-all duration-500 pointer-events-none transform group-hover:scale-125 rotate-12 z-20">
                <span class="border-4 border-white/60 px-2 py-1 text-2xl font-black uppercase text-white tracking-tighter leading-none">Top Secret</span>
              </span>

              <span class="relative z-30 text-xs font-bold uppercase text-white">Kaffeekasse</span>
            </button>

            <button @click="contactOpen = true" class="w-full group relative overflow-hidden bg-zinc-800 p-4 rounded-lg border-b-4 border-blue-700 active:border-b-0 active:translate-y-1 transition-all">

              <div class="absolute inset-0 bg-blue-600 translate-y-full group-hover:translate-y-0 transition-transform duration-300 z-10"></div>

              <span class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-40 transition-all duration-300 pointer-events-none transform group-hover:rotate-[-15deg] group-hover:scale-110 z-20">
                <span class="border-4 border-white/60 px-2 py-1 text-2xl font-black uppercase text-white tracking-tighter leading-none">Eilt Sehr!</span>
              </span>

              <span class="relative z-30 text-xs font-bold uppercase text-white">Funkkontakt</span>
            </button>

            <a href="<?= htmlspecialchars($href) ?>"
               target="_blank"
               rel="noopener noreferrer"
               class="block w-full group relative overflow-hidden bg-zinc-800 p-4 rounded-lg border-b-4 border-purple-700 active:border-b-0 active:translate-y-1 transition-all text-center">

              <div class="absolute inset-0 bg-purple-600 translate-y-full group-hover:translate-y-0 transition-transform duration-300 z-10"></div>

            <span class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-40 transition-all duration-300 pointer-events-none transform group-hover:scale-110 -rotate-12 z-20">
              <span class="border-4 border-white/60 px-2 py-1 text-2xl font-black uppercase text-white tracking-tighter leading-none">Fast gelöst</span>
            </span>

            <span class="relative z-30 text-xs font-bold uppercase text-white tracking-widest">Aktueller Fall 
              <?php if($currentCaseId): ?>
                <span class="opacity-50 ml-1">#<?= $currentCaseId ?></span>
              <?php endif; ?>
            </span>
            </a>

            <button @click="$dispatch('open-info-modal')" class="group relative overflow-hidden w-full bg-zinc-900 p-4 rounded-lg border border-zinc-700 hover:bg-zinc-800 transition-colors text-xs uppercase font-bold text-zinc-500">

              <span class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-20 transition-all duration-300 pointer-events-none transform rotate-6 z-20">
                <span class="border-2 border-zinc-500 px-2 py-1 text-xl font-black uppercase text-zinc-500">Archiviert</span>
              </span>

              <span class="relative z-30 text-xs font-bold uppercase text-white tracking-widest">Archiv-Infos</span>
            </button>

          </div>
        </div>

        <div class="mt-12 pt-6 border-t border-zinc-800 text-[10px] text-zinc-400 uppercase leading-loose">
          Standort: Rocky Beach<br>
          1. Detektiv: Justus Jonas<br>
          2. Detektiv: Peter Shaw<br>
          Recherchen & Archiv: Bob Andrews
        </div>
      </aside>
    </div>

    <footer class="bg-black/40 p-4 flex flex-col items-center gap-4">
      <div class="flex items-center justify-center gap-2">
        <span class="text-[10px] text-zinc-400 uppercase tracking-[0.1em]">
            Made with ❤️ and ☕️ - powered by 
            <a href="https://rondev.de" target="_blank" class="animate-ddf font-black">RonDev</a>
        </span>
      </div>

      <div class="w-full flex items-center justify-center gap-4">
        <div class="h-[1px] flex-1 bg-zinc-800"></div>
        <span class="text-[10px] text-zinc-400 uppercase tracking-[0.5em] whitespace-nowrap">Ende der Akte</span>
        <div class="h-[1px] flex-1 bg-zinc-800"></div>
      </div>
    </footer>
  </main>

  
</body>

</html>