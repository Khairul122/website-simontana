<?php

// Require konfigurasi dan service otentikasi
require_once __DIR__ . '/../config/koneksi.php';

class TindakLanjutService
{
    private $apiEndpoint;

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

        return apiRequest($url, 'GET', null, $headers);
    }

    /**
     * Ambil tindak lanjut berdasarkan ID
     */
    public function getById($id)
    {
        $url = buildApiUrlTindakLanjutById($id);
        $headers = $this->getHeaders();

        return apiRequest($url, 'GET', null, $headers);
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

            return apiRequest($this->apiEndpoint, 'POST', $requestData);
        } else {
            // No files, send as JSON
            $headers = $this->getHeaders();
            return apiRequest($this->apiEndpoint, 'POST', $data, $headers);
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

            return apiRequest($url, 'PUT', $requestData);
        } else {
            // No files, send as JSON
            $headers = $this->getHeaders();
            return apiRequest($url, 'PUT', $data, $headers);
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
        return apiRequest(API_LAPORANS, 'GET', null, $headers);
    }

    /**
     * Ambil semua petugas untuk dropdown
     */
    public function getAllPetugas()
    {
        $headers = $this->getHeaders();
        return apiRequest(API_USERS . '?role=PetugasBPBD', 'GET', null, $headers);
    }
}