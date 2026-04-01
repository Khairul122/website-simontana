<?php
require_once __DIR__ . '/../config/koneksi.php';

class WeatherService {

    private function normalizePrakiraanPayload(array $payload): ?array
    {
        $lokasi = $payload['lokasi'] ?? null;
        if (!is_array($lokasi)) {
            return null;
        }

        if (isset($payload['cuaca']) && is_array($payload['cuaca'])) {
            return [
                'lokasi' => $lokasi,
                'cuaca' => $payload['cuaca']
            ];
        }

        if (isset($payload['data']) && is_array($payload['data'])) {
            $first = $payload['data'][0] ?? null;
            if (is_array($first) && isset($first['cuaca']) && is_array($first['cuaca'])) {
                return [
                    'lokasi' => $lokasi,
                    'cuaca' => $first['cuaca']
                ];
            }
        }

        return null;
    }

    



    private function formatAdm4Code($code) {
        $code = trim((string)$code);
        
        
        if (strpos($code, '.') !== false || strlen($code) !== 10) {
            return $code;
        }

        
        return substr($code, 0, 2) . '.' . 
               substr($code, 2, 2) . '.' . 
               substr($code, 4, 2) . '.' . 
               substr($code, 6, 4);
    }

    


    public function getPrakiraanCuaca($wilayahId) {
        $formattedId = $this->formatAdm4Code($wilayahId);
        $url = API_BMKG_PRAKIRAAN_CUACA . '?wilayah_id=' . urlencode($formattedId);
        $headers = getAuthHeaders();
        
        $response = apiRequest($url, 'GET', null, $headers);

        if (!$response['success']) {
            return $response;
        }

        
        
        $rawPayload = $response['raw'] ?? [];
        if (is_array($rawPayload)) {
            $normalized = $this->normalizePrakiraanPayload($rawPayload);
            if ($normalized !== null) {
                $response['data'] = $normalized;
                return $response;
            }
        }

        if (is_array($response['data'])) {
            $normalized = $this->normalizePrakiraanPayload($response['data']);
            if ($normalized !== null) {
                $response['data'] = $normalized;
                return $response;
            }
        }

        if (is_array($response['data']) && isset($response['data']['lokasi']) && isset($response['data']['cuaca'])) {
            return $response;
        }

        $response['success'] = false;
        $response['message'] = 'Format respons prakiraan cuaca BMKG tidak sesuai.';
        return $response;
    }

    


    public function getPeringatanDiniCuaca() {
        $url = API_BMKG_PERINGATAN_DINI_CUACA;
        $headers = getAuthHeaders();
        return apiRequest($url, 'GET', null, $headers);
    }
}
