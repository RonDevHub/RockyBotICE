<?php

namespace DreiBot;

require_once __DIR__ . '/Logger.php';

class TextGenerator
{
    private array $texts;
    private array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
        $path = $config['templates_path'] . 'texts.json';
        if (!file_exists($path)) {
            Logger::error("Textbaustein-Datei fehlt: texts.json");
            $this->texts = [];
            return;
        }

        $json = json_decode(file_get_contents($path), true);
        if (!is_array($json)) {
            Logger::error("Fehler beim Parsen von texts.json");
            $this->texts = [];
            return;
        }

        $this->texts = $json;
    }

    public function generateText(array $folge): string
    {
        if (empty($this->texts)) {
            return "Heute gibt es Folge: " . ($folge['titel'] ?? 'Unbekannt');
        }

        $template = $this->texts[array_rand($this->texts)];

        $platzhalter = [
            '{titel}'     => $folge['titel'] ?? '',
            '{nummer}'    => $folge['nummer'] ?? '',
            '{typ}'       => $folge['typ'] ?? '',
            '{reihe}'     => $folge['reihe'] ?? '',
            '{sprecher}'  => is_array($folge['sprecher'] ?? null) ? implode(', ', $folge['sprecher']) : ($folge['sprecher'] ?? ''),
            '{autor}'     => is_array($folge['autor'] ?? null) ? implode(', ', $folge['autor']) : ($folge['autor'] ?? ''),
            '{id}'        => $folge['ids']['dreimetadaten'] ?? '',
        ];

        // Typ automatisch bestimmen, falls nicht vorhanden
        if (empty($folge['typ']) && !empty($folge['ids']['dreimetadaten'])) {

            // Datei → Typ Mapping
            $typMap = [
                'Serie.json'           => 'Serie',
                'Spezial.json'         => 'Spezial',
                'Kurzgeschichten.json' => 'Kurzgeschichte'
            ];

            // Herausfinden, aus welcher Datei die Folge stammt
            foreach ($typMap as $file => $typName) {
                $path = $this->config['data_path'] . $file;

                if (file_exists($path)) {
                    $json = json_decode(file_get_contents($path), true);

                    // Schlüssel im JSON bestimmen
                    $key = strtolower(pathinfo($file, PATHINFO_FILENAME)); // serie, spezial, kurzgeschichten

                    $list = $json[$key] ?? [];

                    foreach ($list as $f) {
                        if (($f['ids']['dreimetadaten'] ?? null) == ($folge['ids']['dreimetadaten'] ?? null)) {
                            $folge['typ'] = $typName;
                            break 2;
                        }
                    }
                }
            }
        }

        // Dynamische Hashtags
        $dynamischeHashtags = [];
        $dyn = $this->config['dynamic_hashtags'] ?? [];

        // Typ-Hashtag
        if (($dyn['typ'] ?? false) && !empty($folge['typ'])) {
            $typTag = '#' . preg_replace('/[^A-Za-z0-9]/', '', $folge['typ']);
            $dynamischeHashtags[] = $typTag;
        }

        // Erscheinungsjahr
        if (($dyn['jahr'] ?? false) && !empty($folge['veröffentlichungsdatum'])) {
            $jahr = substr($folge['veröffentlichungsdatum'], 0, 4);
            if (ctype_digit($jahr)) {
                $dynamischeHashtags[] = '#Jahr' . $jahr;
            }
        }

        // Folgenummer
        if (($dyn['nummer'] ?? false) && !empty($folge['nummer'])) {
            $nummer = preg_replace('/[^0-9]/', '', $folge['nummer']);
            if ($nummer !== '') {
                $dynamischeHashtags[] = '#Folge' . $nummer;
            }
        }

        // Autoren-Hashtags (Initiale + Nachname, max. 3)
        if (($dyn['autor'] ?? false) && !empty($folge['autor'])) {

            $autoren = is_array($folge['autor'])
                ? $folge['autor']
                : [$folge['autor']];

            $initialenTags = [];
            $count = 0;

            foreach ($autoren as $au) {

                // Split nach Komma, "und", "&", "/", "|"
                $parts = preg_split('/,| und | & |\/|\|/i', $au);

                foreach ($parts as $name) {
                    $name = trim($name);
                    if ($name === '') continue;

                    if ($count >= 3) break 2;

                    // Namen in Teile splitten
                    $nameParts = preg_split('/\s+|-/', $name);

                    if (count($nameParts) >= 2) {
                        $vorname = $nameParts[0];
                        $initial = strtoupper(substr($vorname, 0, 1));

                        $nachname = implode('', array_slice($nameParts, 1));
                        $nachnameClean = preg_replace('/[^A-Za-z0-9]/', '', $nachname);

                        $initialenTags[] = "#{$initial}{$nachnameClean}";
                    } else {
                        $clean = preg_replace('/[^A-Za-z0-9]/', '', $name);
                        $initialenTags[] = "#{$clean}";
                    }

                    $count++;
                }
            }

            $dynamischeHashtags = array_merge($dynamischeHashtags, $initialenTags);
        }

        // Basis-Hashtags aus config.php
        $basisTags = $this->config['hashtags'] ?? [];

        // Zusammenführen
        $alleTags = array_unique(array_merge($basisTags, $dynamischeHashtags));
        $hashtags = implode(' ', $alleTags);


        $text = str_replace(array_keys($platzhalter), array_values($platzhalter), $template);
        $link = $this->config['base_url'] . 'folge' . ($folge['ids']['dreimetadaten'] ?? '');

        return $text . "\n\n🔗 " . $link . "\n\n" . $hashtags;
    }
}