<?php

class CuacaWilayahDatasetService
{
    private const DATASET_URL = 'https://raw.githubusercontent.com/cahyadsn/wilayah/master/db/wilayah.sql';
    private const CACHE_TTL_SECONDS = 86400;

    private $cacheFile;

    public function __construct()
    {
        $this->cacheFile = dirname(__DIR__) . '/storage/cuaca_wilayah_dataset.json';
    }

    public function getProvinsi(): array
    {
        $dataset = $this->getDataset();
        if (!$dataset['success']) {
            return $dataset;
        }

        return [
            'success' => true,
            'message' => 'Data provinsi berhasil diambil dari dataset wilayah.',
            'data' => $dataset['data']['provinsi'] ?? []
        ];
    }

    public function getKabupatenByProvinsi(string $kodeProvinsi): array
    {
        $kodeProvinsi = trim($kodeProvinsi);
        if (!preg_match('/^\d{2}$/', $kodeProvinsi)) {
            return [
                'success' => false,
                'message' => 'Kode provinsi tidak valid.',
                'data' => []
            ];
        }

        $dataset = $this->getDataset();
        if (!$dataset['success']) {
            return $dataset;
        }

        return [
            'success' => true,
            'message' => 'Data kabupaten/kota berhasil diambil dari dataset wilayah.',
            'data' => $dataset['data']['kabupaten_by_provinsi'][$kodeProvinsi] ?? []
        ];
    }

    public function getKecamatanByKabupaten(string $kodeKabupaten): array
    {
        $kodeKabupaten = trim($kodeKabupaten);
        if (!preg_match('/^\d{2}\.\d{2}$/', $kodeKabupaten)) {
            return [
                'success' => false,
                'message' => 'Kode kabupaten/kota tidak valid.',
                'data' => []
            ];
        }

        $dataset = $this->getDataset();
        if (!$dataset['success']) {
            return $dataset;
        }

        return [
            'success' => true,
            'message' => 'Data kecamatan berhasil diambil dari dataset wilayah.',
            'data' => $dataset['data']['kecamatan_by_kabupaten'][$kodeKabupaten] ?? []
        ];
    }

    public function getDesaByKecamatan(string $kodeKecamatan): array
    {
        $kodeKecamatan = trim($kodeKecamatan);
        if (!preg_match('/^\d{2}\.\d{2}\.\d{2}$/', $kodeKecamatan)) {
            return [
                'success' => false,
                'message' => 'Kode kecamatan tidak valid.',
                'data' => []
            ];
        }

        $dataset = $this->getDataset();
        if (!$dataset['success']) {
            return $dataset;
        }

        return [
            'success' => true,
            'message' => 'Data desa/kelurahan berhasil diambil dari dataset wilayah.',
            'data' => $dataset['data']['desa_by_kecamatan'][$kodeKecamatan] ?? []
        ];
    }

    public function sync(): array
    {
        return $this->syncFromRemote();
    }

    private function getDataset(): array
    {
        if ($this->isCacheValid()) {
            $cached = $this->readCache();
            if ($cached['success']) {
                return $cached;
            }
        }

        $synced = $this->syncFromRemote();
        if ($synced['success']) {
            return [
                'success' => true,
                'message' => 'Dataset wilayah berhasil disinkronkan dari repo.',
                'data' => $synced['data']
            ];
        }

        $cached = $this->readCache();
        if ($cached['success']) {
            return [
                'success' => true,
                'message' => 'Dataset terbaru tidak tersedia, menggunakan cache dataset repo terakhir.',
                'data' => $cached['data']
            ];
        }

        return [
            'success' => false,
            'message' => $synced['message'] ?? 'Gagal memuat dataset wilayah.',
            'data' => []
        ];
    }

    private function syncFromRemote(): array
    {
        $raw = @file_get_contents(self::DATASET_URL);
        if ($raw === false || $raw === '') {
            return [
                'success' => false,
                'message' => 'Gagal mengambil dataset wilayah dari repo sumber.',
                'data' => []
            ];
        }

        $parsed = $this->parseSqlDataset($raw);
        if (!$parsed['success']) {
            return $parsed;
        }

        $persisted = $this->writeCache($parsed['data']);
        if (!$persisted['success']) {
            return $persisted;
        }

        return [
            'success' => true,
            'message' => 'Sinkronisasi dataset wilayah berhasil.',
            'data' => $parsed['data']
        ];
    }

    private function parseSqlDataset(string $sql): array
    {
        $pattern = "/\\('([0-9.]+)'\\s*,\\s*'((?:[^']|(?:''))*)'\\)/";
        if (!preg_match_all($pattern, $sql, $matches, PREG_SET_ORDER)) {
            return [
                'success' => false,
                'message' => 'Format dataset tidak dikenali atau tidak berisi data wilayah.',
                'data' => []
            ];
        }

        $provinsi = [];
        $kabupatenByProvinsi = [];
        $kecamatanByKabupaten = [];
        $desaByKecamatan = [];

        foreach ($matches as $row) {
            $kode = trim($row[1]);
            $nama = str_replace("''", "'", trim($row[2]));

            if ($kode === '' || $nama === '') {
                continue;
            }

            $dotCount = substr_count($kode, '.');

            if ($dotCount === 0 && strlen($kode) === 2) {
                $provinsi[$kode] = [
                    'id' => $kode,
                    'nama' => $nama
                ];
                continue;
            }

            if ($dotCount === 1 && strlen($kode) === 5) {
                $kodeProv = substr($kode, 0, 2);
                if (!isset($kabupatenByProvinsi[$kodeProv])) {
                    $kabupatenByProvinsi[$kodeProv] = [];
                }
                $kabupatenByProvinsi[$kodeProv][$kode] = [
                    'id' => $kode,
                    'nama' => $nama
                ];
                continue;
            }

            if ($dotCount === 2 && strlen($kode) === 8) {
                $kodeKab = substr($kode, 0, 5);
                if (!isset($kecamatanByKabupaten[$kodeKab])) {
                    $kecamatanByKabupaten[$kodeKab] = [];
                }
                $kecamatanByKabupaten[$kodeKab][$kode] = [
                    'id' => $kode,
                    'nama' => $nama
                ];
                continue;
            }

            if ($dotCount === 3 && strlen($kode) === 13) {
                $kodeKec = substr($kode, 0, 8);
                if (!isset($desaByKecamatan[$kodeKec])) {
                    $desaByKecamatan[$kodeKec] = [];
                }
                $desaByKecamatan[$kodeKec][$kode] = [
                    'id' => $kode,
                    'nama' => $nama,
                    'kode_wilayah' => $kode
                ];
            }
        }

        $provinsi = $this->sortAssocRows($provinsi);
        foreach ($kabupatenByProvinsi as $kodeProv => $rows) {
            $kabupatenByProvinsi[$kodeProv] = $this->sortAssocRows($rows);
        }
        foreach ($kecamatanByKabupaten as $kodeKab => $rows) {
            $kecamatanByKabupaten[$kodeKab] = $this->sortAssocRows($rows);
        }
        foreach ($desaByKecamatan as $kodeKec => $rows) {
            $desaByKecamatan[$kodeKec] = $this->sortAssocRows($rows);
        }

        return [
            'success' => true,
            'message' => 'Dataset wilayah berhasil diparsing.',
            'data' => [
                'source_url' => self::DATASET_URL,
                'synced_at' => date('c'),
                'provinsi' => $provinsi,
                'kabupaten_by_provinsi' => $kabupatenByProvinsi,
                'kecamatan_by_kabupaten' => $kecamatanByKabupaten,
                'desa_by_kecamatan' => $desaByKecamatan
            ]
        ];
    }

    private function sortAssocRows(array $rows): array
    {
        uasort($rows, function ($a, $b) {
            return strcasecmp((string) ($a['nama'] ?? ''), (string) ($b['nama'] ?? ''));
        });

        return array_values($rows);
    }

    private function readCache(): array
    {
        if (!is_file($this->cacheFile)) {
            return [
                'success' => false,
                'message' => 'Cache dataset wilayah belum tersedia.',
                'data' => []
            ];
        }

        $json = @file_get_contents($this->cacheFile);
        if ($json === false || $json === '') {
            return [
                'success' => false,
                'message' => 'Cache dataset wilayah tidak dapat dibaca.',
                'data' => []
            ];
        }

        $decoded = json_decode($json, true);
        if (!is_array($decoded) || !isset($decoded['data']) || !is_array($decoded['data'])) {
            return [
                'success' => false,
                'message' => 'Format cache dataset wilayah tidak valid.',
                'data' => []
            ];
        }

        return [
            'success' => true,
            'message' => 'Cache dataset wilayah berhasil dibaca.',
            'data' => $decoded['data']
        ];
    }

    private function writeCache(array $data): array
    {
        $dir = dirname($this->cacheFile);
        if (!is_dir($dir) && !@mkdir($dir, 0777, true) && !is_dir($dir)) {
            return [
                'success' => false,
                'message' => 'Gagal membuat direktori cache dataset wilayah.',
                'data' => []
            ];
        }

        $payload = [
            'meta' => [
                'source' => self::DATASET_URL,
                'cached_at' => date('c')
            ],
            'data' => $data
        ];

        $encoded = json_encode($payload, JSON_UNESCAPED_UNICODE);
        if ($encoded === false) {
            return [
                'success' => false,
                'message' => 'Gagal mengubah dataset wilayah ke format JSON.',
                'data' => []
            ];
        }

        if (@file_put_contents($this->cacheFile, $encoded) === false) {
            return [
                'success' => false,
                'message' => 'Gagal menyimpan cache dataset wilayah.',
                'data' => []
            ];
        }

        return [
            'success' => true,
            'message' => 'Cache dataset wilayah berhasil disimpan.',
            'data' => []
        ];
    }

    private function isCacheValid(): bool
    {
        if (!is_file($this->cacheFile)) {
            return false;
        }

        $modified = @filemtime($this->cacheFile);
        if ($modified === false) {
            return false;
        }

        return (time() - $modified) < self::CACHE_TTL_SECONDS;
    }
}
