<?php
require_once __DIR__ . '/../config/koneksi.php';

class MonitoringService
{
    private array $idKeys = ['id_monitoring', 'monitoring_id', 'idMonitoring', 'id'];

    private function getHeaders(): array
    {
        $token = $_SESSION['token'] ?? null;
        return getAuthHeaders($token);
    }

    private function mapItem(array $item): array
    {
        $id = apiResolveId($item, $this->idKeys);
        if ($id > 0) {
            $item['id'] = $id;
            $item['id_monitoring'] = $item['id_monitoring'] ?? $id;
        }

        $laporanId = (int)($item['id_laporan'] ?? ($item['laporan']['id'] ?? 0));
        $operatorId = (int)($item['id_operator'] ?? ($item['operator']['id'] ?? 0));

        $item['laporan_id'] = $laporanId > 0 ? $laporanId : null;
        $item['operator_id'] = $operatorId > 0 ? $operatorId : null;

        $item['laporan_judul'] = $item['laporan']['judul_laporan']
            ?? $item['laporan']['judul']
            ?? $item['judul_laporan']
            ?? null;

        $item['operator_nama'] = $item['operator']['nama']
            ?? $item['petugas']['nama']
            ?? $item['user']['nama']
            ?? null;

        $item['pelapor_nama'] = $item['laporan']['pelapor']['nama']
            ?? $item['pelapor']['nama']
            ?? null;

        return $item;
    }

    private function mapList(array $rows): array
    {
        $mapped = [];
        foreach ($rows as $row) {
            if (is_array($row)) {
                $mapped[] = $this->mapItem($row);
            }
        }
        return $mapped;
    }

    public function getAll(array $filters = []): array
    {
        $url = API_MONITORING;
        if (!empty($filters)) {
            $url .= '?' . http_build_query($filters);
        }

        $response = apiRequest($url, 'GET', null, $this->getHeaders());
        if ($response['success']) {
            $response['data'] = $this->mapList(apiDataList($response['data']));
        }
        return $response;
    }

    public function getById(int $id): array
    {
        $url = buildApiUrlMonitoringById($id);
        $response = apiRequest($url, 'GET', null, $this->getHeaders());
        if ($response['success']) {
            $response['data'] = $this->mapItem(apiDataEntity($response['data']));
        }
        return $response;
    }

    public function create(array $data): array
    {
        $response = apiRequest(API_MONITORING, 'POST', $data, $this->getHeaders());
        if ($response['success']) {
            $response['data'] = $this->mapItem(apiDataEntity($response['data']));
        }
        return $response;
    }

    public function update(int $id, array $data): array
    {
        $url = buildApiUrlMonitoringById($id);
        $response = apiRequest($url, 'PUT', $data, $this->getHeaders());
        if ($response['success']) {
            $response['data'] = $this->mapItem(apiDataEntity($response['data']));
        }
        return $response;
    }

    public function delete(int $id): array
    {
        $url = buildApiUrlMonitoringById($id);
        return apiRequest($url, 'DELETE', null, $this->getHeaders());
    }

    public function getAllLaporan(): array
    {
        $response = apiRequest(API_LAPORANS, 'GET', null, $this->getHeaders());
        if ($response['success']) {
            $response['data'] = apiDataList($response['data']);
        }
        return $response;
    }

    public function getAllOperator(): array
    {
        $response = apiRequest(API_USERS . '?role=OperatorDesa', 'GET', null, $this->getHeaders());
        if ($response['success']) {
            $response['data'] = apiDataList($response['data']);
        }
        return $response;
    }
}
