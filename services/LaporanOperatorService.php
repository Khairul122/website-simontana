<?php
require_once 'config/koneksi.php';

class LaporanOperatorService
{
    /**
     * Get authentication headers
     *
     * @return array Authentication headers
     */
    private function getHeaders()
    {
        $token = $_SESSION['token'] ?? null;
        return getAuthHeaders($token);
    }
    /**
     * Get all reports with pagination
     * 
     * @param int $page Page number
     * @return array Response from API
     */
    public function getAll($page = 1, $id_desa = null)
    {
        try {
            // Build URL with pagination and desa filter
            $params = ['page' => $page];

            // If the id_desa is provided, filter reports for that desa
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

    /**
     * Get report by ID
     * 
     * @param int $id Report ID
     * @return array Response from API
     */
    public function getById($id)
    {
        try {
            $url = buildApiUrlLaporansById($id);
            $response = apiRequest($url, 'GET', null, $this->getHeaders());
            if ($response['success']) {
                $response['data'] = apiDataEntity($response['data']);
            }

            // Additional check: ensure the report belongs to the operator's desa if needed
            $current_user = $_SESSION['user'] ?? null;
            $user_desa_id = $current_user['id_desa'] ?? null;

            if ($response['success'] && $user_desa_id) {
                $report = $response['data'];
                $report_desa_id = $report['desa']['id'] ?? $report['id_desa'] ?? null;

                // If the report doesn't belong to the operator's desa, return an error
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

    /**
     * Update report status
     *
     * @param int $id Report ID
     * @param array $data Update data (status, hasil_monitoring, etc.)
     * @return array Response from API
     */
    public function updateStatus($id, $data)
    {
        try {
            // First, verify that the operator has access to this report
            $report_response = $this->getById($id);
            if (!$report_response['success']) {
                return $report_response; // Return the error from access check
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
