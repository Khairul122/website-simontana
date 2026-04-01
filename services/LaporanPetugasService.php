<?php


require_once __DIR__ . '/../config/koneksi.php';

class LaporanPetugasService
{
    private $apiEndpoint;

    public function __construct()
    {
        
        $this->apiEndpoint = API_LAPORANS;
    }

    


    private function getHeaders()
    {
        $token = $_SESSION['token'] ?? null;
        return getAuthHeaders($token);
    }

    


    public function getAll($filters = [])
    {
        $url = $this->apiEndpoint;

        
        if (!empty($filters)) {
            $url .= '?' . http_build_query($filters);
        }

        $headers = $this->getHeaders();

        $response = apiRequest($url, 'GET', null, $headers);
        if ($response['success']) {
            $response['data'] = apiDataList($response['data']);
        }
        return $response;
    }

    


    public function getById($id)
    {
        $url = buildApiUrlLaporansById($id);
        $headers = $this->getHeaders();

        $response = apiRequest($url, 'GET', null, $headers);
        if ($response['success']) {
            $response['data'] = apiDataEntity($response['data']);
        }
        return $response;
    }

    public function getRiwayatByLaporanId($id)
    {
        $url = buildApiUrlLaporansRiwayatById((int)$id);
        $headers = $this->getHeaders();

        $response = apiRequest($url, 'GET', null, $headers);
        if ($response['success']) {
            $response['data'] = apiDataList($response['data']);
        }
        return $response;
    }

    


    public function updateStatus($id, $data)
    {
        $headers = $this->getHeaders();
        $status = $data['status'] ?? '';

        if (in_array($status, ['Diverifikasi', 'Ditolak'], true)) {
            $url = buildApiUrlLaporansVerifikasiById($id);
            $payload = ['status' => $status];
            $catatan = trim((string) ($data['catatan_verifikasi'] ?? $data['keterangan'] ?? ''));
            if ($catatan !== '') {
                $payload['catatan_verifikasi'] = $catatan;
            }
            return apiRequest($url, 'POST', $payload, $headers);
        }

        if (in_array($status, ['Diproses', 'Selesai'], true)) {
            $url = buildApiUrlLaporansProsesById($id);
            $payload = ['status' => $status];
            $keterangan = trim((string) ($data['keterangan'] ?? ''));
            if ($keterangan !== '') {
                $payload['keterangan'] = $keterangan;
            }
            return apiRequest($url, 'POST', $payload, $headers);
        }

        $url = buildApiUrlLaporansById($id);
        return apiRequest($url, 'PUT', $data, $headers);
    }

    


    public function updateToProses($id, $data = [])
    {
        $url = buildApiUrlLaporansProsesById($id);
        $headers = $this->getHeaders();

        $payload = array_merge([
            'status' => 'Diproses'
        ], $data);

        return apiRequest($url, 'POST', $payload, $headers);
    }

    


    public function updateToSelesai($id, $data = [])
    {
        $url = buildApiUrlLaporansProsesById($id);
        $headers = $this->getHeaders();

        
        $updateData = array_merge([
            'status' => 'Selesai'
        ], $data);

        return apiRequest($url, 'POST', $updateData, $headers);
    }

    


    public function updateToDitolak($id, $data = [])
    {
        $url = buildApiUrlLaporansVerifikasiById($id);
        $headers = $this->getHeaders();

        $updateData = array_merge([
            'status' => 'Ditolak'
        ], $data);

        if (isset($updateData['keterangan']) && !isset($updateData['catatan_verifikasi'])) {
            $updateData['catatan_verifikasi'] = $updateData['keterangan'];
        }
        unset($updateData['keterangan']);

        return apiRequest($url, 'POST', $updateData, $headers);
    }

    


    public function addTindakLanjut($id, $data)
    {
        $url = API_TINDAK_LANJUT;
        $headers = $this->getHeaders();

        if (!isset($data['laporan_id'])) {
            $data['laporan_id'] = (int) $id;
        }

        return apiRequest($url, 'POST', $data, $headers);
    }

    


    public function addMonitoring($id, $data)
    {
        $url = API_MONITORING;
        $headers = $this->getHeaders();

        if (!isset($data['id_laporan'])) {
            $data['id_laporan'] = (int) $id;
        }

        return apiRequest($url, 'POST', $data, $headers);
    }
}
