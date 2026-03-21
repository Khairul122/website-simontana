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

    


    public function updateStatus($id, $data)
    {
        $headers = $this->getHeaders();
        $status = $data['status'] ?? '';

        if (in_array($status, ['Diverifikasi', 'Ditolak'], true)) {
            $url = buildApiUrlLaporansVerifikasiById($id);
            return apiRequest($url, 'POST', $data, $headers);
        }

        if (in_array($status, ['Diproses', 'Selesai'], true)) {
            $url = buildApiUrlLaporansProsesById($id);
            return apiRequest($url, 'POST', $data, $headers);
        }

        $url = buildApiUrlLaporansById($id);
        return apiRequest($url, 'PUT', $data, $headers);
    }

    


    public function updateToProses($id, $data = [])
    {
        $url = buildApiUrlLaporansProsesById($id);
        $headers = $this->getHeaders();

        return apiRequest($url, 'POST', $data, $headers);
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

        return apiRequest($url, 'POST', $updateData, $headers);
    }

    


    public function addTindakLanjut($id, $data)
    {
        $url = buildApiUrlLaporansById($id);
        $headers = $this->getHeaders();

        
        $updateData = array_merge([
            'status' => 'Tindak Lanjut'
        ], $data);

        return apiRequest($url, 'PUT', $updateData, $headers);
    }

    


    public function addMonitoring($id, $data)
    {
        $url = buildApiUrlLaporansRiwayatById($id);
        $headers = $this->getHeaders();

        return apiRequest($url, 'POST', $data, $headers);
    }
}
