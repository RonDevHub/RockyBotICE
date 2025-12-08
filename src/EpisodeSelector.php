<?php

namespace DreiBot;

require_once __DIR__ . '/Logger.php';

class EpisodeSelector
{
    private $config;
    private $dataPath;
    private $logFile;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->dataPath = $config['data_path'];
        $this->logFile = $this->dataPath . 'log.json';
    }

    public function getRandomEpisode(): ?array
    {
        $episodes = $this->loadEpisodes();
        $valid = array_filter($episodes, [$this, 'isPlayable']);

        if (empty($valid)) {
            Logger::log("Keine spielbaren Folgen gefunden.");
            return null;
        }

        $recentIds = $this->getRecentIds();

        // Zufall mit Wiederholungsprüfung
        $tries = 0;
        do {
            $zufall = $valid[array_rand($valid)];
            $id = $zufall['ids']['dreimetadaten'] ?? null;
            $tries++;
        } while (($id === null || in_array($id, $recentIds)) && $tries < 50);

        if ($id === null || in_array($id, $recentIds)) {
            Logger::log("Keine neue Folge gefunden nach $tries Versuchen.");
            return null;
        }

        return $zufall;
    }

    public function logEpisode(int $id): void
    {
        $log = $this->getLog();
        $heute = date('Y-m-d');
        // Nur loggen, wenn noch kein Eintrag für heute existiert
        if (!isset($log[$heute])) {
            $log[$heute] = $id;
            file_put_contents($this->logFile, json_encode($log, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            Logger::log("Folge $id wurde für $heute ins Log geschrieben.");
        } else {
            Logger::log("Für $heute existiert bereits ein Logeintrag: Folge {$log[$heute]}.");
        }
    }


    private function loadEpisodes(): array
    {
        $map = [
            'Serie.json' => 'serie',
            'Spezial.json' => 'spezial',
            'Kurzgeschichten.json' => 'kurzgeschichten'
        ];

        $all = [];

        foreach ($map as $file => $key) {
            $path = $this->dataPath . $file;
            if (!file_exists($path)) {
                Logger::log("Datei fehlt: $file");
                continue;
            }

            $json = json_decode(file_get_contents($path), true);
            if (!is_array($json[$key] ?? null)) {
                Logger::log("Fehler beim Parsen oder Schlüssel '$key' fehlt in: $file");
                continue;
            }

            $all = array_merge($all, $json[$key]);
        }

        Logger::log("Geladene Folgen insgesamt: " . count($all));
        return $all;
    }


    private function isPlayable(array $f): bool
    {
        if (!empty($f['unvollständig'])) return false;

        $links = $f['links'] ?? [];
        $cover = $links['cover'] ?? null;
        $anbieter = ['spotify', 'deezer', 'appleMusic', 'amazonMusic', 'youTubeMusic'];
        $hatLink = array_filter($anbieter, fn($a) => !empty($links[$a]));

        return $cover || count($hatLink) > 0;
    }

    private function getLog(): array
    {
        if (!file_exists($this->logFile)) return [];
        $json = json_decode(file_get_contents($this->logFile), true);
        return is_array($json) ? $json : [];
    }

    private function getRecentIds(): array
    {
        $log = $this->getLog();
        $cutoff = (new \DateTime())->modify("-{$this->config['log_days']} days");
        $ids = [];

        foreach ($log as $date => $id) {
            $d = \DateTime::createFromFormat('Y-m-d', $date);
            if ($d && $d >= $cutoff) {
                $ids[] = $id;
            }
        }

        return $ids;
    }
}
