<?php

// Require konfigurasi dan service otentikasi
require_once __DIR__ . '/../config/koneksi.php';

class LaporanAdminService
{
    private $apiEndpoint;

    public function __construct()
    {
        // Gabungkan konstanta global + endpoint spesifik
        $this->apiEndpoint = API_LAPORANS;
    }

    /**
     * Mendapatkan headers otentikasi
     */
    private function getHeaders()
    {
        $token = $_SESSION['token'] ?? null;
        return getAuthHeaders($token);
    }

    /**
     * Ambil semua laporan bencana
     */
    public function getAll($filters = [])
    {
        $url = $this->apiEndpoint;

        // Add query parameters if filters are provided
        if (!empty($filters)) {
            $url .= '?' . http_build_query($filters);
        }

        $headers = $this->getHeaders();

        return apiRequest($url, 'GET', null, $headers);
    }

    /**
     * Ambil laporan bencana berdasarkan ID
     */
    public function getById($id)
    {
        $url = buildApiUrlLaporansById($id);
        $headers = $this->getHeaders();

        return apiRequest($url, 'GET', null, $headers);
    }

    /**
     * Update laporan bencana
     */
    public function update($id, $data, $files = [])
    {
        $url = buildApiUrlLaporansById($id);
        
        // Prepare multipart form data if files are provided
        if (!empty($files)) {
            $multipartData = [];

            // Add regular form fields
            foreach ($data as $key => $value) {
                $multipartData[$key] = $value;
            }

            // Add file fields if provided
            $fileFields = ['foto_bukti_1', 'foto_bukti_2', 'foto_bukti_3', 'video_bukti'];

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

            return apiRequest($url, 'PUT', $requestData);
        } else {
            // No files, send as JSON
            $headers = $this->getHeaders();
            return apiRequest($url, 'PUT', $data, $headers);
        }
    }

    /**
     * Hapus laporan bencana
     */
    public function delete($id)
    {
        $url = buildApiUrlLaporansById($id);
        $headers = $this->getHeaders();

        return apiRequest($url, 'DELETE', null, $headers);
    }
}