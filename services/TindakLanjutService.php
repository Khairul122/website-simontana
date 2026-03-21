<?php

// Require konfigurasi dan service otentikasi
require_once __DIR__ . '/../config/koneksi.php';

class TindakLanjutService
{
    private $apiEndpoint;
    private array $idKeys = ['id_tindaklanjut', 'tindaklanjut_id', 'id'];

    public function __construct()
    {
        // Gabungkan konstanta global + endpoint spesifik
        $this->apiEndpoint = API_TINDAK_LANJUT;
    }

    /**
     * Mendapatkan headers otentikasi
     */
    private function getHeaders()
    {
        $token = $_SESSION['token'] ?? null;
        return getAuthHeaders($token);
    }

    private function mapItem(array $item): array
    {
        $id = apiResolveId($item, $this->idKeys);
        if ($id > 0) {
            $item['id'] = $id;
            $item['id_tindaklanjut'] = $item['id_tindaklanjut'] ?? $id;
        }

        $laporanId = (int)($item['laporan_id'] ?? ($item['laporan']['id'] ?? 0));
        $petugasId = (int)($item['id_petugas'] ?? ($item['petugas']['id'] ?? 0));

        $item['laporan_id'] = $laporanId > 0 ? $laporanId : null;
        $item['petugas_id'] = $petugasId > 0 ? $petugasId : null;

        $item['laporan_judul'] = $item['laporan']['judul_laporan']
            ?? $item['laporan']['judul']
            ?? null;

        $item['pelapor_nama'] = $item['laporan']['pelapor']['nama']
            ?? $item['pelapor']['nama']
            ?? null;

        $item['petugas_nama'] = $item['petugas']['nama']
            ?? $item['operator']['nama']
            ?? $item['user']['nama']
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

    /**
     * Ambil semua tindak lanjut
     */
    public function getAll($filters = [])
    {
        $url = $this->apiEndpoint;

        // Add query parameters if filters are provided
        if (!empty($filters)) {
            $url .= '?' . http_build_query($filters);
        }

        $headers = $this->getHeaders();

        $response = apiRequest($url, 'GET', null, $headers);
        if ($response['success']) {
            $response['data'] = $this->mapList(apiDataList($response['data']));
        }
        return $response;
    }

    /**
     * Ambil tindak lanjut berdasarkan ID
     */
    public function getById($id)
    {
        $url = buildApiUrlTindakLanjutById($id);
        $headers = $this->getHeaders();

        $response = apiRequest($url, 'GET', null, $headers);
        if ($response['success']) {
            $response['data'] = $this->mapItem(apiDataEntity($response['data']));
        }
        return $response;
    }

    /**
     * Buat tindak lanjut baru
     */
    public function create($data, $files = [])
    {
        // Prepare multipart form data if files are provided
        if (!empty($files)) {
            $multipartData = [];

            // Add regular form fields
            foreach ($data as $key => $value) {
                $multipartData[$key] = $value;
            }

            // Add file fields if provided
            $fileFields = ['foto_kegiatan'];

            foreach ($fileFields as $field) {
                if (isset($files[$field]) && $files[$field]['error'] === UPLOAD_ERR_OK) {
                    $multipartData[$field] = new CURLFile(
                        $files[$field]['tmp_name'],
                        $files[$field]['type'],
                        $files[$field]['name']
                    );
                }
            }

            // Prepare request data for multipart
            $requestData = [
                'is_multipart' => true,
                'data' => $multipartData
            ];

            $response = apiRequest($this->apiEndpoint, 'POST', $requestData);
            if ($response['success']) {
                $response['data'] = $this->mapItem(apiDataEntity($response['data']));
            }
            return $response;
        } else {
            // No files, send as JSON
            $headers = $this->getHeaders();
            $response = apiRequest($this->apiEndpoint, 'POST', $data, $headers);
            if ($response['success']) {
                $response['data'] = $this->mapItem(apiDataEntity($response['data']));
            }
            return $response;
        }
    }

    /**
     * Update tindak lanjut
     */
    public function update($id, $data, $files = [])
    {
        $url = buildApiUrlTindakLanjutById($id);

        // Prepare multipart form data if files are provided
        if (!empty($files)) {
            $multipartData = [];

            // Add regular form fields
            foreach ($data as $key => $value) {
                $multipartData[$key] = $value;
            }

            // Add file fields if provided
            $fileFields = ['foto_kegiatan'];

            foreach ($fileFields as $field) {
                if (isset($files[$field]) && $files[$field]['error'] === UPLOAD_ERR_OK) {
                    $multipartData[$field] = new CURLFile(
                        $files[$field]['tmp_name'],
                        $files[$field]['type'],
                        $files[$field]['name']
                    );
                }
            }

            // Prepare request data for multipart
            $requestData = [
                'is_multipart' => true,
                'data' => $multipartData
            ];

            $response = apiRequest($url, 'PUT', $requestData);
            if ($response['success']) {
                $response['data'] = $this->mapItem(apiDataEntity($response['data']));
            }
            return $response;
        } else {
            // No files, send as JSON
            $headers = $this->getHeaders();
            $response = apiRequest($url, 'PUT', $data, $headers);
            if ($response['success']) {
                $response['data'] = $this->mapItem(apiDataEntity($response['data']));
            }
            return $response;
        }
    }

    /**
     * Hapus tindak lanjut
     */
    public function delete($id)
    {
        $url = buildApiUrlTindakLanjutById($id);
        $headers = $this->getHeaders();

        return apiRequest($url, 'DELETE', null, $headers);
    }

    /**
     * Ambil semua laporan untuk dropdown
     */
    public function getAllLaporan()
    {
        $headers = $this->getHeaders();
        $response = apiRequest(API_LAPORANS, 'GET', null, $headers);
        if ($response['success']) {
            $response['data'] = apiDataList($response['data']);
        }
        return $response;
    }

    /**
     * Ambil semua petugas untuk dropdown
     */
    public function getAllPetugas()
    {
        $headers = $this->getHeaders();
        $response = apiRequest(API_USERS . '?role=PetugasBPBD', 'GET', null, $headers);
        if ($response['success']) {
            $response['data'] = apiDataList($response['data']);
        }
        return $response;
    }
}
