<?php

// Require konfigurasi dan service otentikasi
require_once dirname(__DIR__) . '/config/koneksi.php';

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
        $url = API_PROVINSI;
        $headers = $this->getHeaders();

        return apiRequest($url, 'GET', null, $headers);
    }

    /**
     * Ambil provinsi berdasarkan ID
     */
    public function getProvinsiById($id)
    {
        $url = API_PROVINSI . '/' . $id;
        $headers = $this->getHeaders();

        return apiRequest($url, 'GET', null, $headers);
    }

    /**
     * Ambil kabupaten berdasarkan ID provinsi
     */
    public function getKabupatenByProvinsi($provinsiId)
    {
        $url = API_KABUPATEN . '/' . $provinsiId;
        $headers = $this->getHeaders();

        return apiRequest($url, 'GET', null, $headers);
    }

    /**
     * Ambil kecamatan berdasarkan ID kabupaten
     */
    public function getKecamatanByKabupaten($kabupatenId)
    {
        $url = API_KECAMATAN . '/' . $kabupatenId;
        $headers = $this->getHeaders();

        return apiRequest($url, 'GET', null, $headers);
    }

    /**
     * Ambil desa berdasarkan ID kecamatan
     */
    public function getDesaByKecamatan($kecamatanId)
    {
        $url = API_DESA . '/' . $kecamatanId;
        $headers = $this->getHeaders();

        return apiRequest($url, 'GET', null, $headers);
    }

    /**
     * Ambil detail wilayah lengkap berdasarkan ID desa
     */
    public function getWilayahDetailByDesa($desaId)
    {
        // Ambil data desa
        $desaResponse = $this->getDesaById($desaId);
        if (!$desaResponse['success'] || empty($desaResponse['data'])) {
            return $desaResponse;
        }

        $desa = $desaResponse['data'];

        // Ambil data kecamatan jika belum ada dan ada id_kecamatan
        if (!isset($desa['kecamatan']) && !empty($desa['id_kecamatan'])) {
            $kecamatanResponse = $this->getKecamatanById($desa['id_kecamatan']);
            if ($kecamatanResponse['success'] && !empty($kecamatanResponse['data'])) {
                $desa['kecamatan'] = $kecamatanResponse['data'];

                // Ambil data kabupaten jika belum ada dan ada id_kabupaten
                if (!isset($desa['kecamatan']['kabupaten']) && !empty($desa['kecamatan']['id_kabupaten'])) {
                    $kabupatenResponse = $this->getKabupatenById($desa['kecamatan']['id_kabupaten']);
                    if ($kabupatenResponse['success'] && !empty($kabupatenResponse['data'])) {
                        $desa['kecamatan']['kabupaten'] = $kabupatenResponse['data'];

                        // Ambil data provinsi jika belum ada dan ada id_provinsi
                        if (!isset($desa['kecamatan']['kabupaten']['provinsi']) && !empty($desa['kecamatan']['kabupaten']['id_provinsi'])) {
                            $provinsiResponse = $this->getProvinsiById($desa['kecamatan']['kabupaten']['id_provinsi']);
                            if ($provinsiResponse['success'] && !empty($provinsiResponse['data'])) {
                                $desa['kecamatan']['kabupaten']['provinsi'] = $provinsiResponse['data'];
                            }
                        }
                    }
                }
            }
        }

        return [
            'success' => true,
            'data' => $desa
        ];
    }

    /**
     * Ambil desa berdasarkan ID
     */
    private function getDesaById($id)
    {
        $url = API_DESA . '/' . $id;
        $headers = $this->getHeaders();
        return apiRequest($url, 'GET', null, $headers);
    }

    /**
     * Ambil kecamatan berdasarkan ID
     */
    private function getKecamatanById($id)
    {
        $url = API_KECAMATAN . '/' . $id;
        $headers = $this->getHeaders();
        return apiRequest($url, 'GET', null, $headers);
    }

    /**
     * Ambil kabupaten berdasarkan ID
     */
    private function getKabupatenById($id)
    {
        $url = API_KABUPATEN . '/' . $id;
        $headers = $this->getHeaders();
        return apiRequest($url, 'GET', null, $headers);
    }
}