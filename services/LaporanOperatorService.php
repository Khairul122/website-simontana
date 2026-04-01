<?php
require_once 'config/koneksi.php';

class LaporanOperatorService
{
    




    private function getHeaders()
    {
        $token = $_SESSION['token'] ?? null;
        return getAuthHeaders($token);
    }
    





    public function getAll($page = 1, $id_desa = null)
    {
        try {
            
            $params = ['page' => $page];

            
            if ($id_desa) {
                $params['id_desa'] = $id_desa;
            }

            $url = API_LAPORANS . '?' . http_build_query($params);
            $response = apiRequest($url, 'GET', null, $this->getHeaders());

            if ($response['success']) {
                $response['pagination'] = $response['meta']['pagination'] ?? [];
                $response['data'] = apiDataList($response['data']);
            }
            return $response;
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Error fetching reports: ' . $e->getMessage(),
                'data' => null
            ];
        }
    }

    





    public function getById($id)
    {
        try {
            $url = buildApiUrlLaporansById($id);
            $response = apiRequest($url, 'GET', null, $this->getHeaders());
            if ($response['success']) {
                $response['data'] = apiDataEntity($response['data']);
            }

            
            $current_user = $_SESSION['user'] ?? null;
            $user_desa_id = $current_user['id_desa'] ?? null;

            if ($response['success'] && $user_desa_id) {
                $report = $response['data'];
                $report_desa_id = $report['desa']['id'] ?? $report['id_desa'] ?? null;

                
                if ($report_desa_id != $user_desa_id) {
                    return [
                        'success' => false,
                        'message' => 'Anda tidak memiliki akses ke laporan ini',
                        'data' => null
                    ];
                }
            }

            return $response;
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Error fetching report: ' . $e->getMessage(),
                'data' => null
            ];
        }
    }

    public function getRiwayatByLaporanId($id)
    {
        try {
            $url = buildApiUrlLaporansRiwayatById((int)$id);
            $response = apiRequest($url, 'GET', null, $this->getHeaders());
            if ($response['success']) {
                $response['data'] = apiDataList($response['data']);
            }
            return $response;
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Error fetching report history: ' . $e->getMessage(),
                'data' => null
            ];
        }
    }

    






    public function updateStatus($id, $data)
    {
        try {
            
            $report_response = $this->getById($id);
            if (!$report_response['success']) {
                return $report_response; 
            }

            $status = $data['status'] ?? '';

            if (in_array($status, ['Diverifikasi', 'Ditolak'], true)) {
                $url = buildApiUrlLaporansVerifikasiById($id);
                $response = apiRequest($url, 'POST', $data, $this->getHeaders());
            } elseif (in_array($status, ['Diproses', 'Selesai'], true)) {
                $url = buildApiUrlLaporansProsesById($id);
                $response = apiRequest($url, 'POST', $data, $this->getHeaders());
            } else {
                $url = buildApiUrlLaporansById($id);
                $response = apiRequest($url, 'PUT', $data, $this->getHeaders());
            }

            return $response;
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Error updating report status: ' . $e->getMessage(),
                'data' => null
            ];
        }
    }
}
