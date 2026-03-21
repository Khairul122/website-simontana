<?php
require_once __DIR__ . '/../config/koneksi.php';

class WeatherService {

    



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
        
        $url = 'https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4=' . urlencode($formattedId);
        
        $response = apiRequest($url, 'GET', null, []);

        if (!$response['success']) {
            return $response;
        }

        
        
        $rawPayload = $response['raw'] ?? [];
        if (is_array($rawPayload) && isset($rawPayload['lokasi']) && isset($rawPayload['data'])) {
            $response['data'] = $rawPayload;
            return $response;
        }

        
        if (is_array($response['data']) && isset($response['data']['lokasi']) && isset($response['data']['data'])) {
            return $response;
        }

        $response['success'] = false;
        $response['message'] = 'Format respons prakiraan cuaca BMKG tidak sesuai.';
        return $response;
    }

    


    public function getPeringatanDiniCuaca() {
        $url = API_BASE_URL . '/bmkg/peringatan-dini-cuaca';
        $headers = getAuthHeaders($_SESSION['token'] ?? null);
        return apiRequest($url, 'GET', null, $headers);
    }
}
