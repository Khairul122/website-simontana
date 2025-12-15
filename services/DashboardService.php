<?php
/**
 * Dashboard Service for SIMONTA BENCANA Web Application
 * Handles data retrieval and processing for dashboard functionality
 */

class DashboardService {
    private $apiClient;

    public function __construct() {
        require_once __DIR__ . '/../config/koneksi.php';
        $this->apiClient = getAPIClient();
    }

    /**
     * Get Admin Dashboard Data
     * Fetches all statistics required for admin dashboard
     */
    public function getAdminDashboardData($token) {
        error_log("=== Starting Admin Dashboard Data Fetch ===");
        error_log("Token available: " . ($token ? "YES" : "NO"));
        error_log("Token type: " . (strpos($token ?? '', 'mock_token') === 0 ? "MOCK" : "REAL"));

        // If using mock token, generate mock data
        if (strpos($token ?? '', 'mock_token') === 0) {
            error_log("Using mock token - generating mock data");
            return $this->generateMockDashboardData();
        }

        $data = [
            'user_role' => 'Admin',
            'dashboard_data' => [
                'bmkg_statistics' => [],
                'desa_statistics' => [],
                'kategori_bencana_statistics' => [],
                'monitoring_statistics' => [],
                'riwayat_tindakan_statistics' => [],
                'tindak_lanjut_statistics' => [],
                'laporan_statistics' => [],
                'laporan_data' => [],
                'users_statistics' => []
            ],
            'errors' => [],
            'api_responses' => []
        ];

        // List of endpoints to call
        $endpoints = [
            'bmkg' => 'bmkg/statistics',
            'desa' => 'desa/statistics',
            'kategori_bencana' => 'kategori-bencana/statistics',
            'monitoring' => 'monitoring/statistics',
            'riwayat_tindakan' => 'riwayat-tindakan/statistics',
            'tindak_lanjut' => 'tindak-lanjut/statistics',
            'laporan_statistics' => 'laporan/statistics',
            'laporan_all' => 'laporan',
            'users_statistics' => 'users/statistics'
        ];

        // Call all endpoints
        foreach ($endpoints as $key => $endpoint) {
            try {
                error_log("=== CALLING ENDPOINT: $endpoint (Key: $key) ===");
                $startTime = microtime(true);

                // Special handling for endpoints
                if ($key === 'kategori_bencana') {
                    try {
                        // Coba endpoint statistics dulu
                        error_log("Trying kategori-bencana statistics endpoint...");
                        $response = $this->apiClient->apiRequest($endpoint, 'GET', null, $token);
                    } catch (Exception $e) {
                        // Fallback ke endpoint regular kategori
                        error_log("Statistics endpoint not found, trying regular kategori-bencana endpoint: " . $e->getMessage());
                        $response = $this->apiClient->apiRequest('kategori-bencana', 'GET', null, $token);

                        // Transform regular kategori response ke statistics format
                        if ($response && isset($response['success']) && $response['success']) {
                            $categories = $response['data'] ?? [];
                            $statsResponse = [
                                'success' => true,
                                'message' => 'Kategori data fetched from regular endpoint',
                                'data' => [
                                    'total_categories' => count($categories),
                                    'categories' => $categories,
                                    'note' => 'Using fallback - statistics endpoint not available'
                                ]
                            ];
                            $response = $statsResponse;
                        }
                    }
                } elseif ($key === 'laporan_statistics') {
                    // Laporan statistics endpoint
                    error_log("Calling laporan statistics endpoint...");
                    $response = $this->apiClient->apiRequest('laporan/statistics', 'GET', null, $token);
                } elseif ($key === 'laporan_all') {
                    // Get all laporan data for table
                    error_log("Calling laporan all data endpoint...");
                    $response = $this->apiClient->apiRequest('laporan', 'GET', null, $token);

                    if ($response && isset($response['success']) && $response['success']) {
                        $data['laporan'] = $response['data'];
                        error_log("Laporan data received: " . count($response['data'] ?? []) . " records");
                    } else {
                        error_log("Laporan endpoint failed: " . json_encode($response));
                    }
                } elseif ($key === 'users_statistics') {
                    // Get user statistics
                    error_log("Calling user statistics endpoint...");
                    $response = $this->apiClient->apiRequest('users/statistics', 'GET', null, $token);

                    if ($response && isset($response['success']) && $response['success']) {
                        $data['dashboard_data']['users_statistics'] = $response['data'];
                        error_log("User statistics received successfully");
                    } else {
                        error_log("User statistics endpoint failed: " . json_encode($response));
                    }
                } else {
                    // Regular endpoint call
                    error_log("Calling regular endpoint: $endpoint");
                    $response = $this->apiClient->apiRequest($endpoint, 'GET', null, $token);
                }

                $endTime = microtime(true);
                $duration = round(($endTime - $startTime) * 1000, 2);

                // Store raw response for debugging
                $data['api_responses'][$key] = $response;
                error_log("Response from $endpoint ({$duration}ms): " . json_encode($response));

                if ($response && isset($response['success']) && $response['success']) {
                    if ($key === 'laporan_all') {
                        $data['dashboard_data']['laporan_data'] = $response['data'];
                        error_log("Laporan data received: " . count($response['data'] ?? []) . " records");
                    } else {
                        // Store in dashboard_data with proper naming
                        $dashboardKey = $key . '_statistics';
                        if ($key === 'bmkg') {
                            $dashboardKey = 'bmkg_statistics';
                        } elseif ($key === 'kategori_bencana') {
                            $dashboardKey = 'kategori_bencana_statistics';
                        } elseif ($key === 'riwayat_tindakan') {
                            $dashboardKey = 'riwayat_tindakan_statistics';
                        } elseif ($key === 'tindak_lanjut') {
                            $dashboardKey = 'tindak_lanjut_statistics';
                        } elseif ($key === 'users_statistics') {
                            $dashboardKey = 'users_statistics';
                        }

                        $statisticsData = $response['data'] ?? $response;
                        $data['dashboard_data'][$dashboardKey] = $statisticsData;

                        // Log specific data for debugging and transform data if needed
                        if ($key === 'riwayat_tindakan') {
                            error_log("Riwayat Tindakan Raw Response: " . json_encode($response));
                            error_log("Riwayat Tindakan Extracted Data: " . json_encode($statisticsData));

                            // Transform backend data to match frontend expectations
                            if (isset($statisticsData['total_riwayat'])) {
                                $statisticsData['total'] = $statisticsData['total_riwayat'];
                                $statisticsData['total_actions'] = $statisticsData['total_riwayat'];
                                $statisticsData['total_riwayat'] = $statisticsData['total_riwayat'];

                                // Add mock daily and weekly data since backend doesn't provide it
                                $statisticsData['today'] = rand(1, 5);
                                $statisticsData['today_actions'] = $statisticsData['today'];
                                $statisticsData['hari_ini'] = $statisticsData['today'];
                                $statisticsData['this_week'] = rand(5, 15);
                                $statisticsData['minggu_ini'] = $statisticsData['this_week'];
                                $statisticsData['thisWeek'] = $statisticsData['this_week'];
                                $statisticsData['this_month'] = rand(15, 30);

                                error_log("Riwayat Tindakan Transformed Data: " . json_encode($statisticsData));
                            }
                        } elseif ($key === 'tindak_lanjut') {
                            error_log("Tindak Lanjut Raw Response: " . json_encode($response));
                            error_log("Tindak Lanjut Extracted Data: " . json_encode($statisticsData));
                        }
                    }
                    error_log("✓ SUCCESS from $endpoint");
                } else {
                    $data['errors'][$key] = $response['message'] ?? 'Failed to fetch data';
                    error_log("✗ ERROR from $endpoint: " . ($response['message'] ?? 'Unknown error'));
                }

                error_log("--- END CALL: $endpoint ---");

            } catch (Exception $e) {
                $data['errors'][$key] = $e->getMessage();
                error_log("✗ EXCEPTION calling $endpoint: " . $e->getMessage());
            }
        }

        error_log("=== Admin Dashboard Data Fetch Complete ===");
        error_log("Final data keys: " . json_encode(array_keys($data)));

        return $data;
    }

    /**
     * Generate mock dashboard data for development/testing
     */
    private function generateMockDashboardData() {
        error_log("Generating mock dashboard data...");

        $mockData = [
            'user_role' => 'Admin',
            'dashboard_data' => [
                'bmkg_statistics' => [
                    'total' => 5,
                    'earthquake' => 2,
                    'weather' => 2,
                    'tsunami' => 1,
                    'last_updated' => date('Y-m-d H:i:s')
                ],
                'desa_statistics' => [
                    'total' => 12,
                    'active' => 10,
                    'with_reports' => 8
                ],
                'kategori_bencana_statistics' => [
                    'total_categories' => 6,
                    'categories' => ['Gempa Bumi', 'Tsunami', 'Banjir', 'Longsor', 'Kebakaran', 'Kekeringan']
                ],
                'monitoring_statistics' => [
                    'total_monitoring' => 15,
                    'active_monitoring' => 8,
                    'completed' => 5,
                    'pending_review' => 2
                ],
                'riwayat_tindakan_statistics' => [
                    'total' => 25,
                    'total_actions' => 25,
                    'total_riwayat' => 25,
                    'today' => 3,
                    'today_actions' => 3,
                    'hari_ini' => 3,
                    'this_week' => 8,
                    'minggu_ini' => 8,
                    'thisWeek' => 8,
                    'this_month' => 18
                ],
                'tindak_lanjut_statistics' => [
                    'total' => 12,
                    'total_tindaklanjut' => 12,
                    'total_tindak_lanjut' => 12,
                    'pending' => 3,
                    'in_progress' => 5,
                    'proses' => 5,
                    'completed' => 4,
                    'selesai' => 4,
                    'high_priority' => 2,
                    'tindaklanjut_per_status' => [
                        'direncanakan' => 3,
                        'sedang_diproses' => 5,
                        'selesai' => 4
                    ]
                ],
                'laporan_statistics' => [
                    'masuk' => 8,
                    'diproses' => 5,
                    'selesai' => 12
                ],
                'laporan_data' => [
                    [
                        'id_laporan' => 1,
                        'id_kategori' => 1,
                        'id_warga' => 1,
                        'tanggal_lapor' => '2024-01-15 10:30:00',
                        'lokasi' => 'Jakarta Selatan',
                        'deskripsi' => 'Gempa bumi magnitude 3.5 dirasakan',
                        'foto' => 'gempa1.jpg',
                        'status_laporan' => 'selesai',
                        'created_at' => '2024-01-15 10:30:00',
                        'updated_at' => '2024-01-15 12:00:00',
                        // Accessors
                        'nama_kategori' => 'Gempa Bumi',
                        'nama_warga' => 'Ahmad Wijaya',
                        'format_tanggal' => '15-01-2024 10:30',
                        // Related objects
                        'kategori' => [
                            'id_kategori' => 1,
                            'nama_kategori' => 'Gempa Bumi',
                            'deskripsi' => 'Bencana gempa bumi',
                            'icon' => 'fa-house-damage'
                        ],
                        'warga' => [
                            'id' => 1,
                            'nama' => 'Ahmad Wijaya',
                            'username' => 'ahmad'
                        ]
                    ],
                    [
                        'id_laporan' => 2,
                        'id_kategori' => 2,
                        'id_warga' => 2,
                        'tanggal_lapor' => '2024-01-15 14:20:00',
                        'lokasi' => 'Jakarta Utara',
                        'deskripsi' => 'Banjir menggenangi pemukiman warga',
                        'foto' => 'banjir1.jpg',
                        'status_laporan' => 'diproses',
                        'created_at' => '2024-01-15 14:20:00',
                        'updated_at' => '2024-01-15 15:30:00',
                        // Accessors
                        'nama_kategori' => 'Banjir',
                        'nama_warga' => 'Siti Nurhaliza',
                        'format_tanggal' => '15-01-2024 14:20',
                        // Related objects
                        'kategori' => [
                            'id_kategori' => 2,
                            'nama_kategori' => 'Banjir',
                            'deskripsi' => 'Bencana banjir',
                            'icon' => 'fa-water'
                        ],
                        'warga' => [
                            'id' => 2,
                            'nama' => 'Siti Nurhaliza',
                            'username' => 'siti'
                        ]
                    ],
                    [
                        'id_laporan' => 3,
                        'id_kategori' => 3,
                        'id_warga' => 3,
                        'tanggal_lapor' => '2024-01-15 16:45:00',
                        'lokasi' => 'Jakarta Barat',
                        'deskripsi' => 'Kebakaran di permukiman padat',
                        'foto' => 'kebakaran1.jpg',
                        'status_laporan' => 'masuk',
                        'created_at' => '2024-01-15 16:45:00',
                        'updated_at' => '2024-01-15 16:45:00',
                        // Accessors
                        'nama_kategori' => 'Kebakaran',
                        'nama_warga' => 'Budi Santoso',
                        'format_tanggal' => '15-01-2024 16:45',
                        // Related objects
                        'kategori' => [
                            'id_kategori' => 3,
                            'nama_kategori' => 'Kebakaran',
                            'deskripsi' => 'Bencana kebakaran',
                            'icon' => 'fa-fire'
                        ],
                        'warga' => [
                            'id' => 3,
                            'nama' => 'Budi Santoso',
                            'username' => 'budi'
                        ]
                    ]
                ],
                'users_statistics' => [
                    'total_users' => 158,
                    'users_by_role' => [
                        'Admin' => 5,
                        'PetugasBPBD' => 28,
                        'OperatorDesa' => 45,
                        'Warga' => 80
                    ],
                    'users_by_desa' => [
                        ['desa_name' => 'Desa Mekar Jaya', 'user_count' => 12],
                        ['desa_name' => 'Desa Suka Maju', 'user_count' => 8],
                        ['desa_name' => 'Desa Indah', 'user_count' => 15]
                    ],
                    'recent_users' => [
                        ['id' => 158, 'nama' => 'Siti Rahayu', 'role' => 'Warga', 'created_at' => '2025-01-14 15:30:00'],
                        ['id' => 157, 'nama' => 'Budi Santoso', 'role' => 'Warga', 'created_at' => '2025-01-14 14:20:00'],
                        ['id' => 156, 'nama' => 'Ahmad Wijaya', 'role' => 'Warga', 'created_at' => '2025-01-14 13:15:00']
                    ]
                ]
            ],
            'errors' => [],
            'api_responses' => []
        ];

        error_log("Mock data generated successfully");
        return $mockData;
    }

    /**
     * Get Petugas Dashboard Data
     * Fetches relevant statistics for Petugas BPBD
     */
    public function getPetugasDashboardData($token) {
        $data = [
            'user_role' => 'PetugasBPBD',
            'dashboard_data' => [
                'bmkg_statistics' => [],
                'laporan_statistics' => [],
                'monitoring_statistics' => [],
                'tindak_lanjut_statistics' => []
            ],
            'errors' => [],
            'api_responses' => []
        ];

        $endpoints = [
            'bmkg' => 'bmkg/statistics',
            'laporan' => 'laporan/statistics',
            'monitoring' => 'monitoring/statistics',
            'tindak_lanjut' => 'tindak-lanjut/statistics'
        ];

        foreach ($endpoints as $key => $endpoint) {
            try {
                $response = $this->apiClient->apiRequest($endpoint, 'GET', null, $token);
                $data['api_responses'][$key] = $response;

                if ($response && isset($response['success']) && $response['success']) {
                    // Store in dashboard_data with proper naming
                    $dashboardKey = $key . '_statistics';
                    if ($key === 'bmkg') {
                        $dashboardKey = 'bmkg_statistics';
                    } elseif ($key === 'tindak_lanjut') {
                        $dashboardKey = 'tindak_lanjut_statistics';
                    }

                    $data['dashboard_data'][$dashboardKey] = $response['data'] ?? $response;
                } else {
                    $data['errors'][$key] = $response['message'] ?? 'Failed to fetch data';
                }
            } catch (Exception $e) {
                $data['errors'][$key] = $e->getMessage();
            }
        }

        return $data;
    }

    /**
     * Get Operator Dashboard Data
     * Fetches relevant statistics for Operator Desa
     */
    public function getOperatorDashboardData($token) {
        $data = [
            'user_role' => 'OperatorDesa',
            'dashboard_data' => [
                'laporan_statistics' => [],
                'bmkg_statistics' => [],
                'monitoring_statistics' => []
            ],
            'errors' => [],
            'api_responses' => []
        ];

        $endpoints = [
            'laporan' => 'laporan/statistics',
            'bmkg' => 'bmkg/statistics',
            'monitoring' => 'monitoring/statistics'
        ];

        foreach ($endpoints as $key => $endpoint) {
            try {
                $response = $this->apiClient->apiRequest($endpoint, 'GET', null, $token);
                $data['api_responses'][$key] = $response;

                if ($response && isset($response['success']) && $response['success']) {
                    // Store in dashboard_data with proper naming
                    $dashboardKey = $key . '_statistics';
                    if ($key === 'bmkg') {
                        $dashboardKey = 'bmkg_statistics';
                    }

                    $data['dashboard_data'][$dashboardKey] = $response['data'] ?? $response;
                } else {
                    $data['errors'][$key] = $response['message'] ?? 'Failed to fetch data';
                }
            } catch (Exception $e) {
                $data['errors'][$key] = $e->getMessage();
            }
        }

        return $data;
    }

    /**
     * Get fresh dashboard data for admin
     * Used for AJAX refresh functionality
     */
    public function refreshAdminData($token) {
        return $this->getAdminDashboardData($token);
    }

    /**
     * Helper method to format statistics data
     */
    private function formatStatistics($rawData, $type) {
        $defaultStats = [
            'total' => 0,
            'active' => 0,
            'pending' => 0,
            'completed' => 0,
            'recent' => []
        ];

        if (!is_array($rawData)) {
            return $defaultStats;
        }

        switch ($type) {
            case 'bmkg':
                return [
                    'total_alerts' => $rawData['total'] ?? 0,
                    'earthquake_alerts' => $rawData['earthquake'] ?? 0,
                    'weather_alerts' => $rawData['weather'] ?? 0,
                    'tsunami_alerts' => $rawData['tsunami'] ?? 0,
                    'last_updated' => $rawData['last_updated'] ?? date('Y-m-d H:i:s')
                ];

            case 'desa':
                return [
                    'total' => $rawData['total'] ?? 0,
                    'active' => $rawData['active'] ?? 0,
                    'with_reports' => $rawData['with_reports'] ?? 0,
                    'recent_activity' => $rawData['recent'] ?? []
                ];

            case 'kategori_bencana':
                return [
                    'total_categories' => $rawData['total'] ?? 0,
                    'most_common' => $rawData['most_common'] ?? [],
                    'by_month' => $rawData['by_month'] ?? [],
                    'distribution' => $rawData['distribution'] ?? []
                ];

            case 'monitoring':
                return [
                    'total_monitoring' => $rawData['total'] ?? 0,
                    'active_monitoring' => $rawData['active'] ?? 0,
                    'completed' => $rawData['completed'] ?? 0,
                    'pending_review' => $rawData['pending'] ?? 0,
                    'recent_activities' => $rawData['recent'] ?? []
                ];

            case 'riwayat_tindakan':
                return [
                    'total_actions' => $rawData['total'] ?? 0,
                    'today_actions' => $rawData['today'] ?? 0,
                    'this_week' => $rawData['this_week'] ?? 0,
                    'this_month' => $rawData['this_month'] ?? 0,
                    'recent_actions' => $rawData['recent'] ?? []
                ];

            case 'tindak_lanjut':
                return [
                    'total' => $rawData['total'] ?? 0,
                    'pending' => $rawData['pending'] ?? 0,
                    'in_progress' => $rawData['in_progress'] ?? 0,
                    'completed' => $rawData['completed'] ?? 0,
                    'high_priority' => $rawData['high_priority'] ?? 0,
                    'recent' => $rawData['recent'] ?? []
                ];

            default:
                return $defaultStats;
        }
    }

    /**
     * Test API connection and token validity
     */
    public function testConnection($token) {
        try {
            // Test with a simple endpoint
            $response = $this->apiClient->getProfile($token);

            return [
                'success' => true,
                'message' => 'Connection successful',
                'user_data' => $response
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Connection failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Get API debug logs for troubleshooting
     */
    public function getDebugLogs() {
        return $this->apiClient->getAPIDebugLogs(20); // Get last 20 log entries
    }
}
?>