<?php


require_once dirname(__DIR__) . '/config/koneksi.php';

class UserService
{
    private $apiEndpoint;

    public function __construct()
    {
        
        $this->apiEndpoint = API_BASE_URL . '/users';
    }

    


    private function getHeaders()
    {
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $token = $_SESSION['token'] ?? null;

        
        if (!$token) {
            return null;
        }

        return getAuthHeaders($token);
    }

    


    public function getAll()
    {
        $headers = $this->getHeaders();

        
        if (!$headers) {
            return [
                'success' => false,
                'message' => 'Sesi login habis. Silakan login kembali.',
                'http_code' => 401
            ];
        }

        $url = $this->apiEndpoint;
        $response = apiRequest($url, 'GET', null, $headers);
        if ($response['success']) {
            $response['data'] = apiDataList($response['data']);
        }
        return $response;
    }

    


    public function getById($id)
    {
        $headers = $this->getHeaders();

        
        if (!$headers) {
            return [
                'success' => false,
                'message' => 'Sesi login habis. Silakan login kembali.',
                'http_code' => 401
            ];
        }

        $url = $this->apiEndpoint . '/' . $id;
        return apiRequest($url, 'GET', null, $headers);
    }

    


    public function create($data)
    {
        $headers = $this->getHeaders();

        
        if (!$headers) {
            return [
                'success' => false,
                'message' => 'Sesi login habis. Silakan login kembali.',
                'http_code' => 401
            ];
        }

        $url = $this->apiEndpoint;
        return apiRequest($url, 'POST', $data, $headers);
    }

    


    public function update($id, $data)
    {
        $headers = $this->getHeaders();

        
        if (!$headers) {
            return [
                'success' => false,
                'message' => 'Sesi login habis. Silakan login kembali.',
                'http_code' => 401
            ];
        }

        $url = $this->apiEndpoint . '/' . $id;
        return apiRequest($url, 'PUT', $data, $headers);
    }

    


    public function delete($id)
    {
        $headers = $this->getHeaders();

        
        if (!$headers) {
            return [
                'success' => false,
                'message' => 'Sesi login habis. Silakan login kembali.',
                'http_code' => 401
            ];
        }

        $url = $this->apiEndpoint . '/' . $id;
        return apiRequest($url, 'DELETE', null, $headers);
    }
}
