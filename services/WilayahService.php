<?php

// Require konfigurasi dan service otentikasi
require_once dirname(__DIR__) . '/config/koneksi.php';

class WilayahService
{
    /**
     * Ambil semua provinsi
     */
    public function getAllProvinsi()
    {
        return apiRequest(API_WILAYAH_PROVINSI, 'GET', null, getAuthHeaders());
    }

    /**
     * Ambil provinsi berdasarkan ID
     */
    public function getProvinsiById($id)
    {
        $url = str_replace('{id}', $id, API_WILAYAH_PROVINSI_BY_ID);
        return apiRequest($url, 'GET', null, getAuthHeaders());
    }

    /**
     * Ambil kabupaten berdasarkan ID provinsi
     */
    public function getKabupatenByProvinsi($provinsiId)
    {
        $url = str_replace('{provinsi_id}', $provinsiId, API_WILAYAH_KABUPATEN);
        return apiRequest($url, 'GET', null, getAuthHeaders());
    }

    /**
     * Ambil kecamatan berdasarkan ID kabupaten
     */
    public function getKecamatanByKabupaten($kabupatenId)
    {
        $url = str_replace('{kabupaten_id}', $kabupatenId, API_WILAYAH_KECAMATAN);
        return apiRequest($url, 'GET', null, getAuthHeaders());
    }

    /**
     * Ambil desa berdasarkan ID kecamatan
     */
    public function getDesaByKecamatan($kecamatanId)
    {
        $url = str_replace('{kecamatan_id}', $kecamatanId, API_WILAYAH_DESA);
        return apiRequest($url, 'GET', null, getAuthHeaders());
    }

    /**
     * Ambil detail wilayah lengkap berdasarkan ID desa
     * Endpoint: /wilayah/detail/{desa_id}
     */
    public function getWilayahDetailByDesa($desaId)
    {
        $url = str_replace('{desa_id}', $desaId, API_WILAYAH_DETAIL);
        return apiRequest($url, 'GET', null, getAuthHeaders());
    }

    /**
     * Ambil hierarki wilayah lengkap berdasarkan ID desa
     * Endpoint: /wilayah/hierarchy/{desa_id}
     */
    public function getWilayahHierarchyByDesa($desaId)
    {
        $url = str_replace('{desa_id}', $desaId, API_WILAYAH_HIERARCHY);
        return apiRequest($url, 'GET', null, getAuthHeaders());
    }

    /**
     * Ambil semua wilayah dengan filter
     * Endpoint: GET /wilayah?jenis={jenis}&page={page}&per_page={per_page}
     */
    public function getAllWilayah($jenis = null, $params = [])
    {
        $url = API_WILAYAH_ALL;

        // Add jenis parameter if provided
        if ($jenis) {
            $params['jenis'] = $jenis;
        }

        // Add pagination defaults if not provided
        if (!isset($params['page'])) {
            $params['page'] = 1;
        }
        if (!isset($params['per_page'])) {
            $params['per_page'] = 15; // Default pagination
        }

        // Support search parameter
        if (isset($params['nama']) && !empty($params['nama'])) {
            $params['q'] = $params['nama']; // Use 'q' for search as per API convention
            unset($params['nama']); // Remove 'nama' since API uses 'q' for search
        }

        // Build query string
        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }

        return apiRequest($url, 'GET', null, getAuthHeaders());
    }

    /**
     * Ambil semua desa dengan pagination
     * Endpoint: GET /wilayah?jenis=desa&page={page}&per_page={per_page}
     */
    public function getAllDesa($params = [])
    {
        return $this->getAllWilayah('desa', $params);
    }

    /**
     * Ambil semua kecamatan dengan pagination
     * Endpoint: GET /wilayah?jenis=kecamatan&page={page}&per_page={per_page}
     */
    public function getAllKecamatan($params = [])
    {
        return $this->getAllWilayah('kecamatan', $params);
    }

    /**
     * Ambil semua kabupaten dengan pagination
     * Endpoint: GET /wilayah?jenis=kabupaten&page={page}&per_page={per_page}
     */
    public function getAllKabupaten($params = [])
    {
        return $this->getAllWilayah('kabupaten', $params);
    }

    /**
     * Ambil semua provinsi dengan pagination
     * Endpoint: GET /wilayah?jenis=provinsi&page={page}&per_page={per_page}
     */
    public function getAllProvinsiWithPagination($params = [])
    {
        return $this->getAllWilayah('provinsi', $params);
    }

    /**
     * Ambil detail wilayah berdasarkan ID
     * Endpoint: GET /wilayah/{id}
     */
    public function getWilayahById($id)
    {
        $url = str_replace('{id}', $id, API_WILAYAH_BY_ID);
        return apiRequest($url, 'GET', null, getAuthHeaders());
    }

    /**
     * Ambil detail desa berdasarkan ID
     * Endpoint: GET /wilayah/{id}
     */
    public function getDesaDetail($id)
    {
        return $this->getWilayahById($id);
    }

    /**
     * Ambil detail kecamatan berdasarkan ID
     * Endpoint: GET /wilayah/{id}
     */
    public function getKecamatanDetail($id)
    {
        return $this->getWilayahById($id);
    }

    /**
     * Ambil detail kabupaten berdasarkan ID
     * Endpoint: GET /wilayah/{id}
     */
    public function getKabupatenDetail($id)
    {
        return $this->getWilayahById($id);
    }

    /**
     * Ambil detail provinsi berdasarkan ID
     * Endpoint: GET /wilayah/{id}
     */
    public function getProvinsiDetail($id)
    {
        return $this->getWilayahById($id);
    }

    /**
     * Create wilayah baru
     * Endpoint: POST /wilayah
     * Payload: { jenis: 'desa|kecamatan|kabupaten|provinsi', nama: '...', id_parent: parent_id }
     */
    public function createWilayah($data)
    {
        return apiRequest(API_WILAYAH_ALL, 'POST', $data, getAuthHeaders());
    }

    /**
     * Create desa baru
     * Endpoint: POST /wilayah/desa
     * Payload: { jenis: 'desa', nama: '...', id_parent: kecamatan_id }
     */
    public function createDesa($data)
    {
        $payload = [
            'jenis' => 'desa',
            'nama' => $data['nama'] ?? '',
            'id_parent' => $data['id_kecamatan'] ?? null, // Mapping: id_kecamatan -> id_parent
        ];

        return apiRequest(API_WILAYAH_DESA_CREATE, 'POST', $payload, getAuthHeaders());
    }

    /**
     * Create kecamatan baru
     * Endpoint: POST /wilayah/kecamatan
     * Payload: { jenis: 'kecamatan', nama: '...', id_parent: kabupaten_id }
     */
    public function createKecamatan($data)
    {
        $payload = [
            'jenis' => 'kecamatan',
            'nama' => $data['nama'] ?? '',
            'id_parent' => $data['id_kabupaten'] ?? null, // Mapping: id_kabupaten -> id_parent
        ];

        return apiRequest(API_WILAYAH_KECAMATAN_CREATE, 'POST', $payload, getAuthHeaders());
    }

    /**
     * Create kabupaten baru
     * Endpoint: POST /wilayah/kabupaten
     * Payload: { jenis: 'kabupaten', nama: '...', id_parent: provinsi_id }
     */
    public function createKabupaten($data)
    {
        $payload = [
            'jenis' => 'kabupaten',
            'nama' => $data['nama'] ?? '',
            'id_parent' => $data['id_provinsi'] ?? null, // Mapping: id_provinsi -> id_parent
        ];

        return apiRequest(API_WILAYAH_KABUPATEN_CREATE, 'POST', $payload, getAuthHeaders());
    }

    /**
     * Create provinsi baru
     * Endpoint: POST /wilayah
     * Payload: { jenis: 'provinsi', nama: '...' }
     */
    public function createProvinsi($data)
    {
        $payload = [
            'jenis' => 'provinsi',
            'nama' => $data['nama'] ?? '',
        ];

        return apiRequest(API_WILAYAH_PROVINSI, 'POST', $payload, getAuthHeaders());
    }

    /**
     * Update wilayah
     * Endpoint: PUT /wilayah/{id}
     * Payload: { jenis: 'desa|kecamatan|kabupaten|provinsi', nama: '...', id_parent: parent_id }
     */
    public function updateWilayah($id, $data)
    {
        $url = str_replace('{id}', $id, API_WILAYAH_BY_ID);
        return apiRequest($url, 'PUT', $data, getAuthHeaders());
    }

    /**
     * Update desa
     * Endpoint: PUT /wilayah/desa/{id}
     * Payload: { jenis: 'desa', nama: '...', id_parent: kecamatan_id }
     */
    public function updateDesa($id, $data)
    {
        $payload = [
            'jenis' => 'desa',
            'nama' => $data['nama'] ?? '',
            'id_parent' => $data['id_kecamatan'] ?? null, // Mapping: id_kecamatan -> id_parent
        ];

        $url = str_replace('{id}', $id, API_WILAYAH_DESA_BY_ID);
        return apiRequest($url, 'PUT', $payload, getAuthHeaders());
    }

    /**
     * Update kecamatan
     * Endpoint: PUT /wilayah/kecamatan/{id}
     * Payload: { jenis: 'kecamatan', nama: '...', id_parent: kabupaten_id }
     */
    public function updateKecamatan($id, $data)
    {
        $payload = [
            'jenis' => 'kecamatan',
            'nama' => $data['nama'] ?? '',
            'id_parent' => $data['id_kabupaten'] ?? null, // Mapping: id_kabupaten -> id_parent
        ];

        $url = str_replace('{id}', $id, API_WILAYAH_KECAMATAN_BY_ID);
        return apiRequest($url, 'PUT', $payload, getAuthHeaders());
    }

    /**
     * Update kabupaten
     * Endpoint: PUT /wilayah/kabupaten/{id}
     * Payload: { jenis: 'kabupaten', nama: '...', id_parent: provinsi_id }
     */
    public function updateKabupaten($id, $data)
    {
        $payload = [
            'jenis' => 'kabupaten',
            'nama' => $data['nama'] ?? '',
            'id_parent' => $data['id_provinsi'] ?? null, // Mapping: id_provinsi -> id_parent
        ];

        $url = str_replace('{id}', $id, API_WILAYAH_KABUPATEN_BY_ID);
        return apiRequest($url, 'PUT', $payload, getAuthHeaders());
    }

    /**
     * Update provinsi
     * Endpoint: PUT /wilayah/{id}
     * Payload: { jenis: 'provinsi', nama: '...' }
     */
    public function updateProvinsi($id, $data)
    {
        $payload = [
            'jenis' => 'provinsi',
            'nama' => $data['nama'] ?? '',
        ];

        $url = str_replace('{id}', $id, API_WILAYAH_PROVINSI_BY_ID);
        return apiRequest($url, 'PUT', $payload, getAuthHeaders());
    }

    /**
     * Delete wilayah
     * Endpoint: DELETE /wilayah/{id}
     */
    public function deleteWilayah($id)
    {
        $url = str_replace('{id}', $id, API_WILAYAH_BY_ID);
        return apiRequest($url, 'DELETE', null, getAuthHeaders());
    }

    /**
     * Delete desa
     * Endpoint: DELETE /wilayah/{id}
     */
    public function deleteDesa($id)
    {
        return $this->deleteWilayah($id);
    }

    /**
     * Delete kecamatan
     * Endpoint: DELETE /wilayah/{id}
     */
    public function deleteKecamatan($id)
    {
        return $this->deleteWilayah($id);
    }

    /**
     * Delete kabupaten
     * Endpoint: DELETE /wilayah/{id}
     */
    public function deleteKabupaten($id)
    {
        return $this->deleteWilayah($id);
    }

    /**
     * Delete provinsi
     * Endpoint: DELETE /wilayah/{id}
     */
    public function deleteProvinsi($id)
    {
        return $this->deleteWilayah($id);
    }

    /**
     * Search wilayah by name
     * Endpoint: GET /wilayah/search?q={query}
     */
    public function searchWilayah($query)
    {
        $url = API_WILAYAH_SEARCH . '?' . http_build_query(['q' => $query]);
        return apiRequest($url, 'GET', null, getAuthHeaders());
    }
}
