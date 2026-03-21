<?php
require_once 'config/koneksi.php';

class RiwayatTindakanService {
    private $apiEndpoint;
    private array $idKeys = ['id', 'riwayat_id', 'id_riwayat'];

    public function __construct() {
        $this->apiEndpoint = API_RIWAYAT_TINDAKAN;
    }

    private function getHeaders(): array {
        return getAuthHeaders($_SESSION['token'] ?? null);
    }

    private function mapItem(array $item): array {
        $id = apiResolveId($item, $this->idKeys);
        if ($id > 0) {
            $item['id'] = $id;
        }

        $tindakId = (int)($item['tindaklanjut_id'] ?? ($item['tindak_lanjut']['id_tindaklanjut'] ?? 0));
        $petugasId = (int)($item['id_petugas'] ?? ($item['petugas']['id'] ?? 0));

        $item['tindaklanjut_id'] = $tindakId > 0 ? $tindakId : null;
        $item['petugas_id'] = $petugasId > 0 ? $petugasId : null;

        $item['petugas_nama'] = $item['petugas']['nama']
            ?? $item['tindak_lanjut']['petugas']['nama']
            ?? null;

        $item['laporan_judul'] = $item['tindak_lanjut']['laporan']['judul_laporan']
            ?? $item['laporan']['judul_laporan']
            ?? null;

        $item['pelapor_nama'] = $item['tindak_lanjut']['laporan']['pelapor']['nama']
            ?? $item['pelapor']['nama']
            ?? null;

        return $item;
    }

    private function mapList(array $rows): array {
        $mapped = [];
        foreach ($rows as $row) {
            if (is_array($row)) {
                $mapped[] = $this->mapItem($row);
            }
        }
        return $mapped;
    }

    public function getAll($filters) {
        $url = $this->apiEndpoint;
        
        // Pass filters as query params
        if (!empty($filters)) {
            $url .= '?' . http_build_query($filters);
        }
        
        $response = apiRequest($url, 'GET', null, $this->getHeaders());
        if ($response['success']) {
            $response['data'] = $this->mapList(apiDataList($response['data']));
        }
        return $response;
    }

    public function getById($id) {
        $url = buildApiUrlRiwayatTindakanById((int)$id);
        $response = apiRequest($url, 'GET', null, $this->getHeaders());
        if ($response['success']) {
            $response['data'] = $this->mapItem(apiDataEntity($response['data']));
        }
        return $response;
    }

    public function create($data) {
        $response = apiRequest($this->apiEndpoint, 'POST', $data, $this->getHeaders());
        if ($response['success']) {
            $response['data'] = $this->mapItem(apiDataEntity($response['data']));
        }
        return $response;
    }

    public function update($id, $data) {
        $url = buildApiUrlRiwayatTindakanById((int)$id);
        $response = apiRequest($url, 'PUT', $data, $this->getHeaders());
        if ($response['success']) {
            $response['data'] = $this->mapItem(apiDataEntity($response['data']));
        }
        return $response;
    }

    public function delete($id) {
        $url = buildApiUrlRiwayatTindakanById((int)$id);
        return apiRequest($url, 'DELETE', null, $this->getHeaders());
    }

    public function getAllTindakLanjut() {
        $url = API_TINDAK_LANJUT;
        $response = apiRequest($url, 'GET', null, $this->getHeaders());
        if ($response['success']) {
            $response['data'] = apiDataList($response['data']);
        }
        return $response;
    }
}
