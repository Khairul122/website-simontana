<?php


require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/AuthService.php';

class WilayahService
{
    private function normalizeAdmCode($value): string
    {
        $raw = trim((string)$value);
        if ($raw === '') {
            return '';
        }

        if (strpos($raw, '.') !== false) {
            return $raw;
        }

        if (preg_match('/^\d{10}$/', $raw)) {
            return substr($raw, 0, 2) . '.' . substr($raw, 2, 2) . '.' . substr($raw, 4, 2) . '.' . substr($raw, 6, 4);
        }

        if (preg_match('/^\d{8}$/', $raw)) {
            return substr($raw, 0, 2) . '.' . substr($raw, 2, 2) . '.' . substr($raw, 4, 2);
        }

        if (preg_match('/^\d{4}$/', $raw)) {
            return substr($raw, 0, 2) . '.' . substr($raw, 2, 2);
        }

        return $raw;
    }

    private function withAdmHierarchy(array $row): array
    {
        $id = $this->normalizeAdmCode($row['id'] ?? '');
        $kodeWilayah = $this->normalizeAdmCode($row['kode_wilayah'] ?? $id);
        $base = $kodeWilayah !== '' ? $kodeWilayah : $id;

        $parts = $base !== '' ? explode('.', $base) : [];
        $adm1 = $parts[0] ?? null;
        $adm2 = isset($parts[1]) ? ($parts[0] . '.' . $parts[1]) : null;
        $adm3 = isset($parts[2]) ? ($parts[0] . '.' . $parts[1] . '.' . $parts[2]) : null;
        $adm4 = isset($parts[3]) ? ($parts[0] . '.' . $parts[1] . '.' . $parts[2] . '.' . $parts[3]) : null;

        if ($id !== '') {
            $row['id'] = $id;
        }
        if ($kodeWilayah !== '') {
            $row['kode_wilayah'] = $kodeWilayah;
        }

        $row['adm1'] = $row['adm1'] ?? $adm1;
        $row['adm2'] = $row['adm2'] ?? $adm2;
        $row['adm3'] = $row['adm3'] ?? $adm3;
        $row['adm4'] = $row['adm4'] ?? $adm4;

        return $row;
    }

    private function normalizeWilayahList(array $rows): array
    {
        return array_map(function ($item) {
            if (!is_array($item)) {
                return $item;
            }
            return $this->withAdmHierarchy($item);
        }, $rows);
    }

    


    private function getHeaders()
    {
        $token = $_SESSION['token'] ?? null;
        return getAuthHeaders($token);
    }

    


    public function getAllProvinsi()
    {
        $url = API_WILAYAH_PROVINSI;
        $headers = $this->getHeaders();

        $response = apiRequest($url, 'GET', null, $headers);
        
        
        if (!$response['success'] || empty($response['data'])) {
            $publicUrl = "https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json";
            $publicRes = file_get_contents($publicUrl);
            if ($publicRes) {
                $data = json_decode($publicRes, true);
                if ($data) {
                    $formatted = array_map(function($item) {
                        return $this->withAdmHierarchy(['id' => $item['id'], 'nama' => $item['name']]);
                    }, $data);
                    return ['success' => true, 'data' => $formatted];
                }
            }
        }

        if ($response['success']) {
            $response['data'] = $this->normalizeWilayahList(apiDataList($response['data']));
        }
        return $response;
    }

    


    public function getAllKabupaten($provinsiId)
    {
        $url = str_replace('{provinsi_id}', $provinsiId, API_WILAYAH_KABUPATEN);
        $headers = $this->getHeaders();

        $response = apiRequest($url, 'GET', null, $headers);
        
        
        if (!$response['success'] || empty($response['data'])) {
            $publicUrl = "https://www.emsifa.com/api-wilayah-indonesia/api/regencies/{$provinsiId}.json";
            $publicRes = @file_get_contents($publicUrl);
            if ($publicRes) {
                $data = json_decode($publicRes, true);
                if ($data) {
                    $formatted = array_map(function($item) {
                        $id = $item['id'];
                        $name = $item['name'];
                        
                        if ($id == 1173) { $id = 1174; } 
                        elseif ($id == 1174) { $id = 1173; } 
                        return $this->withAdmHierarchy(['id' => $id, 'nama' => $name]);
                    }, $data);
                    return ['success' => true, 'data' => $formatted];
                }
            }
        }

        if ($response['success']) {
            $response['data'] = $this->normalizeWilayahList(apiDataList($response['data']));
        }
        return $response;
    }

    


    public function getAllKecamatan($kabupatenId)
    {
        $url = str_replace('{kabupaten_id}', $kabupatenId, API_WILAYAH_KECAMATAN);
        $headers = $this->getHeaders();

        $response = apiRequest($url, 'GET', null, $headers);
        
        
        if (!$response['success'] || empty($response['data'])) {
            
            $apiId = $kabupatenId;
            if ($kabupatenId == 1174) $apiId = 1173; 
            elseif ($kabupatenId == 1173) $apiId = 1174; 
            
            $publicUrl = "https://www.emsifa.com/api-wilayah-indonesia/api/districts/{$apiId}.json";
            $publicRes = @file_get_contents($publicUrl);
            if ($publicRes) {
                $data = json_decode($publicRes, true);
                if ($data) {
                    $formatted = array_map(function($item) use ($kabupatenId) {
                        $id = $item['id'];
                        
                        if ($kabupatenId == 1174 && substr($id, 0, 4) == '1173') {
                            $id = '1174' . substr($id, 4);
                        } elseif ($kabupatenId == 1173 && substr($id, 0, 4) == '1174') {
                            $id = '1173' . substr($id, 4);
                        }
                        return $this->withAdmHierarchy(['id' => $id, 'nama' => $item['name']]);
                    }, $data);
                    return ['success' => true, 'data' => $formatted];
                }
            }
        }

        if ($response['success']) {
            $response['data'] = $this->normalizeWilayahList(apiDataList($response['data']));
        }
        return $response;
    }

    


    public function getAllDesa($kecamatanId)
    {
        $url = str_replace('{kecamatan_id}', $kecamatanId, API_WILAYAH_DESA);
        $headers = $this->getHeaders();

        $response = apiRequest($url, 'GET', null, $headers);
        
        
        if (!$response['success'] || empty($response['data'])) {
            
            $apiId = $kecamatanId;
            if (substr($kecamatanId, 0, 4) == '1174') $apiId = '1173' . substr($kecamatanId, 4);
            elseif (substr($kecamatanId, 0, 4) == '1173') $apiId = '1174' . substr($kecamatanId, 4);

            $publicUrl = "https://www.emsifa.com/api-wilayah-indonesia/api/villages/{$apiId}.json";
            $publicRes = @file_get_contents($publicUrl);
            if ($publicRes) {
                $data = json_decode($publicRes, true);
                if ($data) {
                    $formatted = array_map(function($item) use ($kecamatanId) {
                        $id = $item['id'];
                        
                        if (substr($kecamatanId, 0, 4) == '1174' && substr($id, 0, 4) == '1173') {
                            $id = '1174' . substr($id, 4);
                        } elseif (substr($kecamatanId, 0, 4) == '1173' && substr($id, 0, 4) == '1174') {
                            $id = '1173' . substr($id, 4);
                        }
                        
                        
                        $dotted = substr($id, 0, 2) . '.' . substr($id, 2, 2) . '.' . substr($id, 4, 2) . '.' . substr($id, 6, 4);
                        return $this->withAdmHierarchy(['id' => $dotted, 'nama' => $item['name'], 'kode_wilayah' => $dotted]);
                    }, $data);
                    return ['success' => true, 'data' => $formatted];
                }
            }
        }

        if ($response['success']) {
            $response['data'] = $this->normalizeWilayahList(apiDataList($response['data']));
        }
        return $response;
    }

    


    public function getById($id, $jenis)
    {
        $url = str_replace('{id}', urlencode((string)$id), API_WILAYAH_BY_ID);
        $url .= '?jenis=' . $jenis;
        $headers = $this->getHeaders();

        $response = apiRequest($url, 'GET', null, $headers);
        if ($response['success']) {
            $response['data'] = $this->withAdmHierarchy(apiDataEntity($response['data']));
        }
        return $response;
    }

    public function getWilayahDetailByDesa($desaId)
    {
        $url = str_replace('{desa_id}', urlencode((string)$desaId), API_WILAYAH_DETAIL);
        $headers = $this->getHeaders();
        $response = apiRequest($url, 'GET', null, $headers);
        if ($response['success']) {
            $response['data'] = $this->withAdmHierarchy(apiDataEntity($response['data']));
        }
        return $response;
    }

    


    public function store($data, $jenis)
    {
        
        switch ($jenis) {
            case 'provinsi':
                $url = API_WILAYAH_PROVINSI;
                
                unset($data['jenis']);
                unset($data['id_parent']);
                break;
            case 'kabupaten':
                $url = API_WILAYAH_KABUPATEN_CREATE;
                
                unset($data['jenis']);
                if (isset($data['id_parent'])) {
                    $data['id_provinsi'] = $data['id_parent'];
                    unset($data['id_parent']);
                }
                break;
            case 'kecamatan':
                $url = API_WILAYAH_KECAMATAN_CREATE;
                
                unset($data['jenis']);
                if (isset($data['id_parent'])) {
                    $data['id_kabupaten'] = $data['id_parent'];
                    unset($data['id_parent']);
                }
                break;
            case 'desa':
                $url = API_WILAYAH_DESA_CREATE;
                
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

    


    public function update($id, $data, $jenis)
    {
        
        switch ($jenis) {
            case 'provinsi':
                $url = str_replace('{id}', $id, API_WILAYAH_PROVINSI_BY_ID);
                
                unset($data['jenis']);
                unset($data['id_parent']);
                break;
            case 'kabupaten':
                $url = str_replace('{id}', $id, API_WILAYAH_KABUPATEN_BY_ID);
                
                unset($data['jenis']);
                if (isset($data['id_parent'])) {
                    $data['id_provinsi'] = $data['id_parent'];
                    unset($data['id_parent']);
                }
                break;
            case 'kecamatan':
                $url = str_replace('{id}', $id, API_WILAYAH_KECAMATAN_BY_ID);
                
                unset($data['jenis']);
                if (isset($data['id_parent'])) {
                    $data['id_kabupaten'] = $data['id_parent'];
                    unset($data['id_parent']);
                }
                break;
            case 'desa':
                $url = str_replace('{id}', $id, API_WILAYAH_DESA_BY_ID);
                
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

    


    public function searchWilayah($query)
    {
        $url = API_WILAYAH_SEARCH . '?q=' . urlencode($query);
        $headers = $this->getHeaders();

        $response = apiRequest($url, 'GET', null, $headers);
        if ($response['success']) {
            $data = apiDataList($response['data']);
            if (isset($data['data']) && is_array($data['data'])) {
                $data['data'] = $this->normalizeWilayahList($data['data']);
            }
            foreach (['provinsi', 'kabupaten', 'kecamatan', 'desa'] as $key) {
                if (isset($data[$key]) && is_array($data[$key])) {
                    $data[$key] = $this->normalizeWilayahList($data[$key]);
                }
            }
            if (!isset($data['data']) && array_values($data) === $data) {
                $data = $this->normalizeWilayahList($data);
            }
            $response['data'] = $data;
        }
        return $response;
    }

    


    public function delete($id, $jenis)
    {
        $url = str_replace('{id}', $id, API_WILAYAH_DELETE);
        $url .= '?jenis=' . $jenis; 
        $headers = $this->getHeaders();

        return apiRequest($url, 'DELETE', null, $headers);
    }
}
