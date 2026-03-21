<?php


require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/AuthService.php';

class KategoriBencanaService
{
    private $apiEndpoint;

    public function __construct()
    {
        
        $this->apiEndpoint = API_BASE_URL . '/kategori-bencana';
    }

    


    private function getHeaders()
    {
        $token = $_SESSION['token'] ?? null;
        return getAuthHeaders($token);
    }

    


    public function getAll()
    {
        $url = $this->apiEndpoint;
        $headers = $this->getHeaders();

        $response = apiRequest($url, 'GET', null, $headers);
        if ($response['success']) {
            $response['data'] = apiDataList($response['data']);
        }
        return $response;
    }

    


    public function getById($id)
    {
        $url = $this->apiEndpoint . '/' . $id;
        $headers = $this->getHeaders();

        return apiRequest($url, 'GET', null, $headers);
    }

    


    public function create($data)
    {
        $url = $this->apiEndpoint;
        $headers = $this->getHeaders();

        return apiRequest($url, 'POST', $data, $headers);
    }

    


    public function update($id, $data)
    {
        $url = $this->apiEndpoint . '/' . $id;
        $headers = $this->getHeaders();

        return apiRequest($url, 'PUT', $data, $headers);
    }

    


    public function delete($id)
    {
        $url = $this->apiEndpoint . '/' . $id;
        $headers = $this->getHeaders();

        return apiRequest($url, 'DELETE', null, $headers);
    }
}
