<?php

// Require konfigurasi dan service otentikasi
require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/AuthService.php';

class WilayahService
{
    /**
     * Mendapatkan headers otentikasi
     */
    private function getHeaders()
    {
        $token = $_SESSION['token'] ?? null;
        return getAuthHeaders($token);
    }

    /**
     * Ambil semua provinsi
     */
    public function getAllProvinsi()
    {
        $url = API_WILAYAH_PROVINSI;
        $headers = $this->getHeaders();

        return apiRequest($url, 'GET', null, $headers);
    }

    /**
     * Ambil semua kabupaten berdasarkan provinsi ID
     */
    public function getAllKabupaten($provinsiId)
    {
        $url = str_replace('{provinsi_id}', $provinsiId, API_WILAYAH_KABUPATEN);
        $headers = $this->getHeaders();

        return apiRequest($url, 'GET', null, $headers);
    }

    /**
     * Ambil semua kecamatan berdasarkan kabupaten ID
     */
    public function getAllKecamatan($kabupatenId)
    {
        $url = str_replace('{kabupaten_id}', $kabupatenId, API_WILAYAH_KECAMATAN);
        $headers = $this->getHeaders();

        return apiRequest($url, 'GET', null, $headers);
    }

    /**
     * Ambil semua desa berdasarkan kecamatan ID
     */
    public function getAllDesa($kecamatanId)
    {
        $url = str_replace('{kecamatan_id}', $kecamatanId, API_WILAYAH_DESA);
        $headers = $this->getHeaders();

        return apiRequest($url, 'GET', null, $headers);
    }

    /**
     * Ambil detail wilayah berdasarkan ID dan jenis
     */
    public function getById($id, $jenis)
    {
        $url = str_replace('{id}', $id, API_WILAYAH_BY_ID);
        $url .= '?jenis=' . $jenis;
        $headers = $this->getHeaders();

        return apiRequest($url, 'GET', null, $headers);
    }

    /**
     * Buat wilayah baru berdasarkan jenis
     */
    public function store($data, $jenis)
    {
        // Pilih endpoint berdasarkan jenis
        switch ($jenis) {
            case 'provinsi':
                $url = API_WILAYAH_PROVINSI;
                // For provinsi, we don't send jenis or id_parent
                unset($data['jenis']);
                unset($data['id_parent']);
                break;
            case 'kabupaten':
                $url = API_WILAYAH_KABUPATEN_CREATE;
                // For kabupaten, we don't send jenis, but we do send id_parent
                unset($data['jenis']);
                if (isset($data['id_parent'])) {
                    $data['id_provinsi'] = $data['id_parent'];
                    unset($data['id_parent']);
                }
                break;
            case 'kecamatan':
                $url = API_WILAYAH_KECAMATAN_CREATE;
                // For kecamatan, we don't send jenis, but we do send id_parent
                unset($data['jenis']);
                if (isset($data['id_parent'])) {
                    $data['id_kabupaten'] = $data['id_parent'];
                    unset($data['id_parent']);
                }
                break;
            case 'desa':
                $url = API_WILAYAH_DESA_CREATE;
                // For desa, we don't send jenis, but we do send id_parent
                unset($data['jenis']);
                if (isset($data['id_parent'])) {
                    $data['id_kecamatan'] = $data['id_parent'];
                    unset($data['id_parent']);
                }
                break;
            default:
                return [
                    'success' => false,
                    'message' => 'Jenis wilayah tidak valid',
                    'data' => null
                ];
        }

        $headers = $this->getHeaders();

        return apiRequest($url, 'POST', $data, $headers);
    }

    /**
     * Update wilayah berdasarkan ID dan jenis
     */
    public function update($id, $data, $jenis)
    {
        // Pilih endpoint berdasarkan jenis
        switch ($jenis) {
            case 'provinsi':
                $url = str_replace('{id}', $id, API_WILAYAH_PROVINSI_BY_ID);
                // For provinsi, we don't send jenis
                unset($data['jenis']);
                unset($data['id_parent']);
                break;
            case 'kabupaten':
                $url = str_replace('{id}', $id, API_WILAYAH_KABUPATEN_BY_ID);
                // For kabupaten, we don't send jenis, but we do send id_parent
                unset($data['jenis']);
                if (isset($data['id_parent'])) {
                    $data['id_provinsi'] = $data['id_parent'];
                    unset($data['id_parent']);
                }
                break;
            case 'kecamatan':
                $url = str_replace('{id}', $id, API_WILAYAH_KECAMATAN_BY_ID);
                // For kecamatan, we don't send jenis, but we do send id_parent
                unset($data['jenis']);
                if (isset($data['id_parent'])) {
                    $data['id_kabupaten'] = $data['id_parent'];
                    unset($data['id_parent']);
                }
                break;
            case 'desa':
                $url = str_replace('{id}', $id, API_WILAYAH_DESA_BY_ID);
                // For desa, we don't send jenis, but we do send id_parent
                unset($data['jenis']);
                if (isset($data['id_parent'])) {
                    $data['id_kecamatan'] = $data['id_parent'];
                    unset($data['id_parent']);
                }
                break;
            default:
                return [
                    'success' => false,
                    'message' => 'Jenis wilayah tidak valid',
                    'data' => null
                ];
        }

        $headers = $this->getHeaders();

        return apiRequest($url, 'PUT', $data, $headers);
    }

    /**
     * Hapus wilayah berdasarkan ID dan jenis
     */
    public function delete($id, $jenis)
    {
        $url = str_replace('{id}', $id, API_WILAYAH_DELETE);
        $url .= '?jenis=' . $jenis; // Pass jenis as query parameter for DELETE request
        $headers = $this->getHeaders();

        return apiRequest($url, 'DELETE', null, $headers);
    }
}