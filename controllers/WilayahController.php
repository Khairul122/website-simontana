<?php

require_once dirname(__DIR__) . '/config/koneksi.php';
require_once dirname(__DIR__) . '/services/WilayahService.php';

class WilayahController
{
    private $service;

    public function __construct()
    {
        $this->service = new WilayahService();
    }

    /**
     * Ambil semua provinsi (API endpoint)
     */
    public function getAllProvinsi()
    {
        $response = $this->service->getAllProvinsi();

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    /**
     * Ambil kabupaten berdasarkan provinsi (API endpoint)
     */
    public function getKabupatenByProvinsi()
    {
        $provinsiId = $_GET['provinsi_id'] ?? null;

        if (!$provinsiId) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'ID provinsi tidak ditemukan'
            ]);
            return;
        }

        $response = $this->service->getKabupatenByProvinsi($provinsiId);

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    /**
     * Ambil kecamatan berdasarkan kabupaten (API endpoint)
     */
    public function getKecamatanByKabupaten()
    {
        $kabupatenId = $_GET['kabupaten_id'] ?? null;

        if (!$kabupatenId) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'ID kabupaten tidak ditemukan'
            ]);
            return;
        }

        $response = $this->service->getKecamatanByKabupaten($kabupatenId);

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    /**
     * Ambil desa berdasarkan kecamatan (API endpoint)
     */
    public function getDesaByKecamatan()
    {
        $kecamatanId = $_GET['kecamatan_id'] ?? null;

        if (!$kecamatanId) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'ID kecamatan tidak ditemukan'
            ]);
            return;
        }

        $response = $this->service->getDesaByKecamatan($kecamatanId);

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    /**
     * Ambil detail wilayah lengkap berdasarkan ID desa (API endpoint)
     */
    public function getWilayahDetailByDesa()
    {
        $desaId = $_GET['desa_id'] ?? null;

        if (!$desaId) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'ID desa tidak ditemukan'
            ]);
            return;
        }

        $response = $this->service->getWilayahDetailByDesa($desaId);

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    /**
     * Ambil hierarki wilayah lengkap berdasarkan ID desa (API endpoint)
     */
    public function getWilayahHierarchyByDesa()
    {
        $desaId = $_GET['desa_id'] ?? null;

        if (!$desaId) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'ID desa tidak ditemukan'
            ]);
            return;
        }

        $response = $this->service->getWilayahHierarchyByDesa($desaId);

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    /**
     * Alias untuk getWilayahDetailByDesa untuk kompatibilitas
     */
    public function getWilayahDetailByDesaId()
    {
        $this->getWilayahDetailByDesa();
    }

    /**
     * Display list of all desa
     * Endpoint: /wilayah?jenis=desa&page={page}&per_page={per_page}
     * Response structure: { data: { data: [...], current_page: ..., last_page: ... }, ... }
     */
    public function index()
    {
        // Get pagination parameters from request
        $page = $_GET['page'] ?? 1;
        $perPage = $_GET['per_page'] ?? 15;
        $search = $_GET['search'] ?? '';

        $params = [
            'page' => $page,
            'per_page' => $perPage
        ];

        // Add search filter if provided
        if (!empty($search)) {
            $params['q'] = $search; // Use 'q' for search as per API convention
        }

        $response = $this->service->getAllDesa($params);

        // Handle unauthorized
        if (isset($response['http_code']) && $response['http_code'] === 401) {
            header('Location: index.php?controller=Auth&action=logout');
            exit;
        }

        $desaList = [];
        $pagination = [];

        if ($response['success']) {
            // Parse response dari endpoint /wilayah?jenis=desa
            // Response structure: { data: { data: [...], current_page: X, last_page: Y, ... }, ... }
            $responseData = $response['data'] ?? [];

            // Check if response has pagination structure
            if (isset($responseData['data']) && is_array($responseData['data'])) {
                // API returns paginated data
                $rawData = $responseData['data'];
                $pagination = [
                    'current_page' => $responseData['current_page'] ?? 1,
                    'last_page' => $responseData['last_page'] ?? 1,
                    'per_page' => $responseData['per_page'] ?? 15,
                    'total' => $responseData['total'] ?? 0,
                    'from' => $responseData['from'] ?? 0,
                    'to' => $responseData['to'] ?? 0,
                ];
            } elseif (is_array($responseData)) {
                // API returns non-paginated data (direct array)
                $rawData = $responseData;
                $pagination = [
                    'current_page' => 1,
                    'last_page' => 1,
                    'per_page' => count($responseData),
                    'total' => count($responseData),
                ];
            } else {
                $rawData = [];
            }

            // Transform data wilayah ke format desa untuk view
            if (is_array($rawData)) {
                foreach ($rawData as $item) {
                    // Handle nested parent structure
                    $kecamatanNama = '';
                    $kabupatenNama = '';
                    $provinsiNama = '';

                    // Extract hierarchical data from nested parent structure
                    if (isset($item['parent']) && is_array($item['parent'])) {
                        $kecamatanNama = $item['parent']['nama'] ?? '';

                        if (isset($item['parent']['parent']) && is_array($item['parent']['parent'])) {
                            $kabupatenNama = $item['parent']['parent']['nama'] ?? '';

                            if (isset($item['parent']['parent']['parent']) && is_array($item['parent']['parent']['parent'])) {
                                $provinsiNama = $item['parent']['parent']['parent']['nama'] ?? '';
                            }
                        }
                    }

                    $desaList[] = [
                        'id' => $item['id'] ?? null,
                        'nama' => $item['nama'] ?? '',
                        'id_kecamatan' => $item['id_parent'] ?? null,
                        'nama_kecamatan' => $kecamatanNama,
                        'nama_kabupaten' => $kabupatenNama,
                        'nama_provinsi' => $provinsiNama,
                        'jenis' => $item['jenis'] ?? '',
                    ];
                }
            }
        }

        $title = "Manajemen Wilayah - Daftar Desa";
        include 'views/wilayah/index.php';
    }

    /**
     * Show form for creating new desa
     */
    public function create()
    {
        $isEdit = false;
        $desa = null;

        $title = "Manajemen Wilayah - Tambah Desa";
        include 'views/wilayah/form.php';
    }

    /**
     * Show form for editing existing desa
     */
    public function edit()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: index.php?controller=Wilayah&action=index&error=ID+desa+tidak+ditemukan');
            exit;
        }

        $response = $this->service->getDesaDetail($id);

        // Handle unauthorized
        if (isset($response['http_code']) && $response['http_code'] === 401) {
            header('Location: index.php?controller=Auth&action=logout');
            exit;
        }

        // Handle forbidden
        if (isset($response['http_code']) && $response['http_code'] === 403) {
            header('Location: index.php?controller=Wilayah&action=index&error=' . urlencode('Anda tidak memiliki hak akses untuk mengedit data ini'));
            exit;
        }

        if (!$response['success']) {
            header('Location: index.php?controller=Wilayah&action=index&error=' . urlencode($response['message'] ?? 'Data desa tidak ditemukan'));
            exit;
        }

        $isEdit = true;

        // Parse response dari endpoint /wilayah/{id}
        $rawData = $response['data'];

        // Transform data wilayah ke format desa untuk form
        $desa = [
            'id' => $rawData['id'] ?? null,
            'nama' => $rawData['nama'] ?? '',
            'id_kecamatan' => $rawData['id_parent'] ?? null,
            'jenis' => $rawData['jenis'] ?? '',
            // Data hierarki lengkap untuk pre-fill dropdown
            'kecamatan' => [
                'id' => $rawData['parent']['id'] ?? null,
                'nama' => $rawData['parent']['nama'] ?? '',
            ],
            'kabupaten' => [
                'id' => $rawData['parent']['parent']['id'] ?? null,
                'nama' => $rawData['parent']['parent']['nama'] ?? '',
            ],
            'provinsi' => [
                'id' => $rawData['parent']['parent']['parent']['id'] ?? null,
                'nama' => $rawData['parent']['parent']['parent']['nama'] ?? '',
            ],
        ];

        $title = "Manajemen Wilayah - Edit Desa";
        include 'views/wilayah/form.php';
    }

    /**
     * Store new desa
     */
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=Wilayah&action=index');
            exit;
        }

        $data = [
            'nama' => $_POST['nama'] ?? '',
            'id_kecamatan' => $_POST['id_kecamatan'] ?? null,
        ];

        // Validasi input
        if (empty($data['nama']) || empty($data['id_kecamatan'])) {
            header('Location: index.php?controller=Wilayah&action=create&error=Nama+desa+dan+kecamatan+wajib+diisi');
            exit;
        }

        $response = $this->service->createDesa($data);

        // Handle unauthorized
        if (isset($response['http_code']) && $response['http_code'] === 401) {
            header('Location: index.php?controller=Auth&action=logout');
            exit;
        }

        // Handle forbidden
        if (isset($response['http_code']) && $response['http_code'] === 403) {
            $errorMessage = 'Anda tidak memiliki hak akses untuk menambah data desa.';
            header('Location: index.php?controller=Wilayah&action=create&error=' . urlencode($errorMessage));
            exit;
        }

        if ($response['success']) {
            header('Location: index.php?controller=Wilayah&action=index&success=' . urlencode('Desa berhasil ditambahkan'));
            exit;
        } else {
            $errorMessage = $response['message'] ?? 'Gagal menambahkan desa';
            header('Location: index.php?controller=Wilayah&action=create&error=' . urlencode($errorMessage));
            exit;
        }
    }

    /**
     * Update existing desa
     */
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=Wilayah&action=index');
            exit;
        }

        $id = $_POST['id'] ?? null;

        if (!$id) {
            header('Location: index.php?controller=Wilayah&action=index&error=ID+desa+tidak+ditemukan');
            exit;
        }

        $data = [
            'nama' => $_POST['nama'] ?? '',
            'id_kecamatan' => $_POST['id_kecamatan'] ?? null,
        ];

        // Validasi input
        if (empty($data['nama']) || empty($data['id_kecamatan'])) {
            header('Location: index.php?controller=Wilayah&action=edit&id=' . $id . '&error=Nama+desa+dan+kecamatan+wajib+diisi');
            exit;
        }

        $response = $this->service->updateDesa($id, $data);

        // Handle unauthorized
        if (isset($response['http_code']) && $response['http_code'] === 401) {
            header('Location: index.php?controller=Auth&action=logout');
            exit;
        }

        // Handle forbidden
        if (isset($response['http_code']) && $response['http_code'] === 403) {
            $errorMessage = 'Anda tidak memiliki hak akses untuk mengedit data desa.';
            header('Location: index.php?controller=Wilayah&action=edit&id=' . $id . '&error=' . urlencode($errorMessage));
            exit;
        }

        if ($response['success']) {
            header('Location: index.php?controller=Wilayah&action=index&success=' . urlencode('Desa berhasil diperbarui'));
            exit;
        } else {
            $errorMessage = $response['message'] ?? 'Gagal memperbarui desa';
            header('Location: index.php?controller=Wilayah&action=edit&id=' . $id . '&error=' . urlencode($errorMessage));
            exit;
        }
    }

    /**
     * Delete desa
     */
    public function delete()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: index.php?controller=Wilayah&action=index&error=ID+desa+tidak+ditemukan');
            exit;
        }

        $response = $this->service->deleteDesa($id);

        // Handle unauthorized
        if (isset($response['http_code']) && $response['http_code'] === 401) {
            header('Location: index.php?controller=Auth&action=logout');
            exit;
        }

        // Handle forbidden
        if (isset($response['http_code']) && $response['http_code'] === 403) {
            $errorMessage = 'Anda tidak memiliki hak akses untuk menghapus data desa.';
            header('Location: index.php?controller=Wilayah&action=index&error=' . urlencode($errorMessage));
            exit;
        }

        if ($response['success']) {
            header('Location: index.php?controller=Wilayah&action=index&success=' . urlencode('Desa berhasil dihapus'));
            exit;
        } else {
            $errorMessage = $response['message'] ?? 'Gagal menghapus desa';
            header('Location: index.php?controller=Wilayah&action=index&error=' . urlencode($errorMessage));
            exit;
        }
    }

    /**
     * Display list of all provinsi
     * Endpoint: /wilayah?jenis=provinsi&page={page}&per_page={per_page}
     */
    public function indexProvinsi()
    {
        // Get pagination parameters from request
        $page = $_GET['page'] ?? 1;
        $perPage = $_GET['per_page'] ?? 15;
        $search = $_GET['search'] ?? '';

        $params = [
            'page' => $page,
            'per_page' => $perPage
        ];

        // Add search filter if provided
        if (!empty($search)) {
            $params['q'] = $search; // Use 'q' for search as per API convention
        }

        $response = $this->service->getAllProvinsiWithPagination($params);

        // Handle unauthorized
        if (isset($response['http_code']) && $response['http_code'] === 401) {
            header('Location: index.php?controller=Auth&action=logout');
            exit;
        }

        $provinsiList = [];
        $pagination = [];

        if ($response['success']) {
            // Parse response dari endpoint /wilayah?jenis=provinsi
            // Response structure: { data: { data: [...], current_page: X, last_page: Y, ... }, ... }
            $responseData = $response['data'] ?? [];

            // Check if response has pagination structure
            if (isset($responseData['data']) && is_array($responseData['data'])) {
                // API returns paginated data
                $rawData = $responseData['data'];
                $pagination = [
                    'current_page' => $responseData['current_page'] ?? 1,
                    'last_page' => $responseData['last_page'] ?? 1,
                    'per_page' => $responseData['per_page'] ?? 15,
                    'total' => $responseData['total'] ?? 0,
                    'from' => $responseData['from'] ?? 0,
                    'to' => $responseData['to'] ?? 0,
                ];
            } elseif (is_array($responseData)) {
                // API returns non-paginated data (direct array)
                $rawData = $responseData;
                $pagination = [
                    'current_page' => 1,
                    'last_page' => 1,
                    'per_page' => count($responseData),
                    'total' => count($responseData),
                ];
            } else {
                $rawData = [];
            }

            // Transform data wilayah ke format provinsi untuk view
            if (is_array($rawData)) {
                foreach ($rawData as $item) {
                    $provinsiList[] = [
                        'id' => $item['id'] ?? null,
                        'nama' => $item['nama'] ?? '',
                        'jenis' => $item['jenis'] ?? '',
                    ];
                }
            }
        }

        $title = "Manajemen Wilayah - Daftar Provinsi";
        include 'views/wilayah/index_provinsi.php';
    }

    /**
     * Show form for creating new provinsi
     */
    public function createProvinsi()
    {
        $isEdit = false;
        $provinsi = null;

        $title = "Manajemen Wilayah - Tambah Provinsi";
        include 'views/wilayah/form_provinsi.php';
    }

    /**
     * Show form for editing existing provinsi
     */
    public function editProvinsi()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: index.php?controller=Wilayah&action=indexProvinsi&error=ID+provinsi+tidak+ditemukan');
            exit;
        }

        $response = $this->service->getProvinsiDetail($id);

        // Handle unauthorized
        if (isset($response['http_code']) && $response['http_code'] === 401) {
            header('Location: index.php?controller=Auth&action=logout');
            exit;
        }

        // Handle forbidden
        if (isset($response['http_code']) && $response['http_code'] === 403) {
            header('Location: index.php?controller=Wilayah&action=indexProvinsi&error=' . urlencode('Anda tidak memiliki hak akses untuk mengedit data ini'));
            exit;
        }

        if (!$response['success']) {
            header('Location: index.php?controller=Wilayah&action=indexProvinsi&error=' . urlencode($response['message'] ?? 'Data provinsi tidak ditemukan'));
            exit;
        }

        $isEdit = true;

        // Parse response dari endpoint /wilayah/{id}
        $rawData = $response['data'];

        // Transform data wilayah ke format provinsi untuk form
        $provinsi = [
            'id' => $rawData['id'] ?? null,
            'nama' => $rawData['nama'] ?? '',
            'jenis' => $rawData['jenis'] ?? '',
        ];

        $title = "Manajemen Wilayah - Edit Provinsi";
        include 'views/wilayah/form_provinsi.php';
    }

    /**
     * Store new provinsi
     */
    public function storeProvinsi()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=Wilayah&action=indexProvinsi');
            exit;
        }

        $data = [
            'nama' => $_POST['nama'] ?? '',
        ];

        // Validasi input
        if (empty($data['nama'])) {
            header('Location: index.php?controller=Wilayah&action=createProvinsi&error=Nama+provinsi+wajib+diisi');
            exit;
        }

        $response = $this->service->createProvinsi($data);

        // Handle unauthorized
        if (isset($response['http_code']) && $response['http_code'] === 401) {
            header('Location: index.php?controller=Auth&action=logout');
            exit;
        }

        // Handle forbidden
        if (isset($response['http_code']) && $response['http_code'] === 403) {
            $errorMessage = 'Anda tidak memiliki hak akses untuk menambah data provinsi.';
            header('Location: index.php?controller=Wilayah&action=createProvinsi&error=' . urlencode($errorMessage));
            exit;
        }

        if ($response['success']) {
            header('Location: index.php?controller=Wilayah&action=indexProvinsi&success=' . urlencode('Provinsi berhasil ditambahkan'));
            exit;
        } else {
            $errorMessage = $response['message'] ?? 'Gagal menambahkan provinsi';
            header('Location: index.php?controller=Wilayah&action=createProvinsi&error=' . urlencode($errorMessage));
            exit;
        }
    }

    /**
     * Update existing provinsi
     */
    public function updateProvinsi()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=Wilayah&action=indexProvinsi');
            exit;
        }

        $id = $_POST['id'] ?? null;

        if (!$id) {
            header('Location: index.php?controller=Wilayah&action=indexProvinsi&error=ID+provinsi+tidak+ditemukan');
            exit;
        }

        $data = [
            'nama' => $_POST['nama'] ?? '',
        ];

        // Validasi input
        if (empty($data['nama'])) {
            header('Location: index.php?controller=Wilayah&action=editProvinsi&id=' . $id . '&error=Nama+provinsi+wajib+diisi');
            exit;
        }

        $response = $this->service->updateProvinsi($id, $data);

        // Handle unauthorized
        if (isset($response['http_code']) && $response['http_code'] === 401) {
            header('Location: index.php?controller=Auth&action=logout');
            exit;
        }

        // Handle forbidden
        if (isset($response['http_code']) && $response['http_code'] === 403) {
            $errorMessage = 'Anda tidak memiliki hak akses untuk mengedit data provinsi.';
            header('Location: index.php?controller=Wilayah&action=editProvinsi&id=' . $id . '&error=' . urlencode($errorMessage));
            exit;
        }

        if ($response['success']) {
            header('Location: index.php?controller=Wilayah&action=indexProvinsi&success=' . urlencode('Provinsi berhasil diperbarui'));
            exit;
        } else {
            $errorMessage = $response['message'] ?? 'Gagal memperbarui provinsi';
            header('Location: index.php?controller=Wilayah&action=editProvinsi&id=' . $id . '&error=' . urlencode($errorMessage));
            exit;
        }
    }

    /**
     * Delete provinsi
     */
    public function deleteProvinsi()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: index.php?controller=Wilayah&action=indexProvinsi&error=ID+provinsi+tidak+ditemukan');
            exit;
        }

        $response = $this->service->deleteProvinsi($id);

        // Handle unauthorized
        if (isset($response['http_code']) && $response['http_code'] === 401) {
            header('Location: index.php?controller=Auth&action=logout');
            exit;
        }

        // Handle forbidden
        if (isset($response['http_code']) && $response['http_code'] === 403) {
            $errorMessage = 'Anda tidak memiliki hak akses untuk menghapus data provinsi.';
            header('Location: index.php?controller=Wilayah&action=indexProvinsi&error=' . urlencode($errorMessage));
            exit;
        }

        if ($response['success']) {
            header('Location: index.php?controller=Wilayah&action=indexProvinsi&success=' . urlencode('Provinsi berhasil dihapus'));
            exit;
        } else {
            $errorMessage = $response['message'] ?? 'Gagal menghapus provinsi';
            header('Location: index.php?controller=Wilayah&action=indexProvinsi&error=' . urlencode($errorMessage));
            exit;
        }
    }

    /**
     * Display list of all kabupaten
     * Endpoint: /wilayah?jenis=kabupaten&page={page}&per_page={per_page}
     */
    public function indexKabupaten()
    {
        // Get pagination parameters from request
        $page = $_GET['page'] ?? 1;
        $perPage = $_GET['per_page'] ?? 15;
        $search = $_GET['search'] ?? '';

        $params = [
            'page' => $page,
            'per_page' => $perPage
        ];

        // Add search filter if provided
        if (!empty($search)) {
            $params['q'] = $search; // Use 'q' for search as per API convention
        }

        $response = $this->service->getAllKabupaten($params);

        // Handle unauthorized
        if (isset($response['http_code']) && $response['http_code'] === 401) {
            header('Location: index.php?controller=Auth&action=logout');
            exit;
        }

        $kabupatenList = [];
        $pagination = [];

        if ($response['success']) {
            // Parse response dari endpoint /wilayah?jenis=kabupaten
            // Response structure: { data: { data: [...], current_page: X, last_page: Y, ... }, ... }
            $responseData = $response['data'] ?? [];

            // Check if response has pagination structure
            if (isset($responseData['data']) && is_array($responseData['data'])) {
                // API returns paginated data
                $rawData = $responseData['data'];
                $pagination = [
                    'current_page' => $responseData['current_page'] ?? 1,
                    'last_page' => $responseData['last_page'] ?? 1,
                    'per_page' => $responseData['per_page'] ?? 15,
                    'total' => $responseData['total'] ?? 0,
                    'from' => $responseData['from'] ?? 0,
                    'to' => $responseData['to'] ?? 0,
                ];
            } elseif (is_array($responseData)) {
                // API returns non-paginated data (direct array)
                $rawData = $responseData;
                $pagination = [
                    'current_page' => 1,
                    'last_page' => 1,
                    'per_page' => count($responseData),
                    'total' => count($responseData),
                ];
            } else {
                $rawData = [];
            }

            // Transform data wilayah ke format kabupaten untuk view
            if (is_array($rawData)) {
                foreach ($rawData as $item) {
                    // Handle nested parent structure
                    $provinsiNama = '';

                    // Extract hierarchical data from nested parent structure
                    if (isset($item['parent']) && is_array($item['parent'])) {
                        $provinsiNama = $item['parent']['nama'] ?? '';
                    }

                    $kabupatenList[] = [
                        'id' => $item['id'] ?? null,
                        'nama' => $item['nama'] ?? '',
                        'id_provinsi' => $item['id_parent'] ?? null,
                        'nama_provinsi' => $provinsiNama,
                        'jenis' => $item['jenis'] ?? '',
                    ];
                }
            }
        }

        $title = "Manajemen Wilayah - Daftar Kabupaten";
        include 'views/wilayah/index_kabupaten.php';
    }

    /**
     * Show form for creating new kabupaten
     */
    public function createKabupaten()
    {
        $isEdit = false;
        $kabupaten = null;

        $title = "Manajemen Wilayah - Tambah Kabupaten";
        include 'views/wilayah/form_kabupaten.php';
    }

    /**
     * Show form for editing existing kabupaten
     */
    public function editKabupaten()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: index.php?controller=Wilayah&action=indexKabupaten&error=ID+kabupaten+tidak+ditemukan');
            exit;
        }

        $response = $this->service->getKabupatenDetail($id);

        // Handle unauthorized
        if (isset($response['http_code']) && $response['http_code'] === 401) {
            header('Location: index.php?controller=Auth&action=logout');
            exit;
        }

        // Handle forbidden
        if (isset($response['http_code']) && $response['http_code'] === 403) {
            header('Location: index.php?controller=Wilayah&action=indexKabupaten&error=' . urlencode('Anda tidak memiliki hak akses untuk mengedit data ini'));
            exit;
        }

        if (!$response['success']) {
            header('Location: index.php?controller=Wilayah&action=indexKabupaten&error=' . urlencode($response['message'] ?? 'Data kabupaten tidak ditemukan'));
            exit;
        }

        $isEdit = true;

        // Parse response dari endpoint /wilayah/{id}
        $rawData = $response['data'];

        // Transform data wilayah ke format kabupaten untuk form
        $kabupaten = [
            'id' => $rawData['id'] ?? null,
            'nama' => $rawData['nama'] ?? '',
            'id_provinsi' => $rawData['id_parent'] ?? null,
            'jenis' => $rawData['jenis'] ?? '',
            // Data hierarki lengkap untuk pre-fill dropdown
            'provinsi' => [
                'id' => $rawData['parent']['id'] ?? null,
                'nama' => $rawData['parent']['nama'] ?? '',
            ],
        ];

        $title = "Manajemen Wilayah - Edit Kabupaten";
        include 'views/wilayah/form_kabupaten.php';
    }

    /**
     * Store new kabupaten
     */
    public function storeKabupaten()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=Wilayah&action=indexKabupaten');
            exit;
        }

        $data = [
            'nama' => $_POST['nama'] ?? '',
            'id_provinsi' => $_POST['id_provinsi'] ?? null,
        ];

        // Validasi input
        if (empty($data['nama']) || empty($data['id_provinsi'])) {
            header('Location: index.php?controller=Wilayah&action=createKabupaten&error=Nama+kabupaten+dan+provinsi+wajib+diisi');
            exit;
        }

        $response = $this->service->createKabupaten($data);

        // Handle unauthorized
        if (isset($response['http_code']) && $response['http_code'] === 401) {
            header('Location: index.php?controller=Auth&action=logout');
            exit;
        }

        // Handle forbidden
        if (isset($response['http_code']) && $response['http_code'] === 403) {
            $errorMessage = 'Anda tidak memiliki hak akses untuk menambah data kabupaten.';
            header('Location: index.php?controller=Wilayah&action=createKabupaten&error=' . urlencode($errorMessage));
            exit;
        }

        if ($response['success']) {
            header('Location: index.php?controller=Wilayah&action=indexKabupaten&success=' . urlencode('Kabupaten berhasil ditambahkan'));
            exit;
        } else {
            $errorMessage = $response['message'] ?? 'Gagal menambahkan kabupaten';
            header('Location: index.php?controller=Wilayah&action=createKabupaten&error=' . urlencode($errorMessage));
            exit;
        }
    }

    /**
     * Update existing kabupaten
     */
    public function updateKabupaten()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=Wilayah&action=indexKabupaten');
            exit;
        }

        $id = $_POST['id'] ?? null;

        if (!$id) {
            header('Location: index.php?controller=Wilayah&action=indexKabupaten&error=ID+kabupaten+tidak+ditemukan');
            exit;
        }

        $data = [
            'nama' => $_POST['nama'] ?? '',
            'id_provinsi' => $_POST['id_provinsi'] ?? null,
        ];

        // Validasi input
        if (empty($data['nama']) || empty($data['id_provinsi'])) {
            header('Location: index.php?controller=Wilayah&action=editKabupaten&id=' . $id . '&error=Nama+kabupaten+dan+provinsi+wajib+diisi');
            exit;
        }

        $response = $this->service->updateKabupaten($id, $data);

        // Handle unauthorized
        if (isset($response['http_code']) && $response['http_code'] === 401) {
            header('Location: index.php?controller=Auth&action=logout');
            exit;
        }

        // Handle forbidden
        if (isset($response['http_code']) && $response['http_code'] === 403) {
            $errorMessage = 'Anda tidak memiliki hak akses untuk mengedit data kabupaten.';
            header('Location: index.php?controller=Wilayah&action=editKabupaten&id=' . $id . '&error=' . urlencode($errorMessage));
            exit;
        }

        if ($response['success']) {
            header('Location: index.php?controller=Wilayah&action=indexKabupaten&success=' . urlencode('Kabupaten berhasil diperbarui'));
            exit;
        } else {
            $errorMessage = $response['message'] ?? 'Gagal memperbarui kabupaten';
            header('Location: index.php?controller=Wilayah&action=editKabupaten&id=' . $id . '&error=' . urlencode($errorMessage));
            exit;
        }
    }

    /**
     * Delete kabupaten
     */
    public function deleteKabupaten()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: index.php?controller=Wilayah&action=indexKabupaten&error=ID+kabupaten+tidak+ditemukan');
            exit;
        }

        $response = $this->service->deleteKabupaten($id);

        // Handle unauthorized
        if (isset($response['http_code']) && $response['http_code'] === 401) {
            header('Location: index.php?controller=Auth&action=logout');
            exit;
        }

        // Handle forbidden
        if (isset($response['http_code']) && $response['http_code'] === 403) {
            $errorMessage = 'Anda tidak memiliki hak akses untuk menghapus data kabupaten.';
            header('Location: index.php?controller=Wilayah&action=indexKabupaten&error=' . urlencode($errorMessage));
            exit;
        }

        if ($response['success']) {
            header('Location: index.php?controller=Wilayah&action=indexKabupaten&success=' . urlencode('Kabupaten berhasil dihapus'));
            exit;
        } else {
            $errorMessage = $response['message'] ?? 'Gagal menghapus kabupaten';
            header('Location: index.php?controller=Wilayah&action=indexKabupaten&error=' . urlencode($errorMessage));
            exit;
        }
    }

    /**
     * Display list of all kecamatan
     * Endpoint: /wilayah?jenis=kecamatan&page={page}&per_page={per_page}
     */
    public function indexKecamatan()
    {
        // Get pagination parameters from request
        $page = $_GET['page'] ?? 1;
        $perPage = $_GET['per_page'] ?? 15;
        $search = $_GET['search'] ?? '';

        $params = [
            'page' => $page,
            'per_page' => $perPage
        ];

        // Add search filter if provided
        if (!empty($search)) {
            $params['q'] = $search; // Use 'q' for search as per API convention
        }

        $response = $this->service->getAllKecamatan($params);

        // Handle unauthorized
        if (isset($response['http_code']) && $response['http_code'] === 401) {
            header('Location: index.php?controller=Auth&action=logout');
            exit;
        }

        $kecamatanList = [];
        $pagination = [];

        if ($response['success']) {
            // Parse response dari endpoint /wilayah?jenis=kecamatan
            // Response structure: { data: { data: [...], current_page: X, last_page: Y, ... }, ... }
            $responseData = $response['data'] ?? [];

            // Check if response has pagination structure
            if (isset($responseData['data']) && is_array($responseData['data'])) {
                // API returns paginated data
                $rawData = $responseData['data'];
                $pagination = [
                    'current_page' => $responseData['current_page'] ?? 1,
                    'last_page' => $responseData['last_page'] ?? 1,
                    'per_page' => $responseData['per_page'] ?? 15,
                    'total' => $responseData['total'] ?? 0,
                    'from' => $responseData['from'] ?? 0,
                    'to' => $responseData['to'] ?? 0,
                ];
            } elseif (is_array($responseData)) {
                // API returns non-paginated data (direct array)
                $rawData = $responseData;
                $pagination = [
                    'current_page' => 1,
                    'last_page' => 1,
                    'per_page' => count($responseData),
                    'total' => count($responseData),
                ];
            } else {
                $rawData = [];
            }

            // Transform data wilayah ke format kecamatan untuk view
            if (is_array($rawData)) {
                foreach ($rawData as $item) {
                    // Handle nested parent structure
                    $kabupatenNama = '';
                    $provinsiNama = '';

                    // Extract hierarchical data from nested parent structure
                    if (isset($item['parent']) && is_array($item['parent'])) {
                        $kabupatenNama = $item['parent']['nama'] ?? '';

                        if (isset($item['parent']['parent']) && is_array($item['parent']['parent'])) {
                            $provinsiNama = $item['parent']['parent']['nama'] ?? '';
                        }
                    }

                    $kecamatanList[] = [
                        'id' => $item['id'] ?? null,
                        'nama' => $item['nama'] ?? '',
                        'id_kabupaten' => $item['id_parent'] ?? null,
                        'nama_kabupaten' => $kabupatenNama,
                        'nama_provinsi' => $provinsiNama,
                        'jenis' => $item['jenis'] ?? '',
                    ];
                }
            }
        }

        $title = "Manajemen Wilayah - Daftar Kecamatan";
        include 'views/wilayah/index_kecamatan.php';
    }

    /**
     * Show form for creating new kecamatan
     */
    public function createKecamatan()
    {
        $isEdit = false;
        $kecamatan = null;

        $title = "Manajemen Wilayah - Tambah Kecamatan";
        include 'views/wilayah/form_kecamatan.php';
    }

    /**
     * Show form for editing existing kecamatan
     */
    public function editKecamatan()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: index.php?controller=Wilayah&action=indexKecamatan&error=ID+kecamatan+tidak+ditemukan');
            exit;
        }

        $response = $this->service->getKecamatanDetail($id);

        // Handle unauthorized
        if (isset($response['http_code']) && $response['http_code'] === 401) {
            header('Location: index.php?controller=Auth&action=logout');
            exit;
        }

        // Handle forbidden
        if (isset($response['http_code']) && $response['http_code'] === 403) {
            header('Location: index.php?controller=Wilayah&action=indexKecamatan&error=' . urlencode('Anda tidak memiliki hak akses untuk mengedit data ini'));
            exit;
        }

        if (!$response['success']) {
            header('Location: index.php?controller=Wilayah&action=indexKecamatan&error=' . urlencode($response['message'] ?? 'Data kecamatan tidak ditemukan'));
            exit;
        }

        $isEdit = true;

        // Parse response dari endpoint /wilayah/{id}
        $rawData = $response['data'];

        // Transform data wilayah ke format kecamatan untuk form
        $kecamatan = [
            'id' => $rawData['id'] ?? null,
            'nama' => $rawData['nama'] ?? '',
            'id_kabupaten' => $rawData['id_parent'] ?? null,
            'jenis' => $rawData['jenis'] ?? '',
            // Data hierarki lengkap untuk pre-fill dropdown
            'kabupaten' => [
                'id' => $rawData['parent']['id'] ?? null,
                'nama' => $rawData['parent']['nama'] ?? '',
            ],
            'provinsi' => [
                'id' => $rawData['parent']['parent']['id'] ?? null,
                'nama' => $rawData['parent']['parent']['nama'] ?? '',
            ],
        ];

        $title = "Manajemen Wilayah - Edit Kecamatan";
        include 'views/wilayah/form_kecamatan.php';
    }

    /**
     * Store new kecamatan
     */
    public function storeKecamatan()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=Wilayah&action=indexKecamatan');
            exit;
        }

        $data = [
            'nama' => $_POST['nama'] ?? '',
            'id_kabupaten' => $_POST['id_kabupaten'] ?? null,
        ];

        // Validasi input
        if (empty($data['nama']) || empty($data['id_kabupaten'])) {
            header('Location: index.php?controller=Wilayah&action=createKecamatan&error=Nama+kecamatan+dan+kabupaten+wajib+diisi');
            exit;
        }

        $response = $this->service->createKecamatan($data);

        // Handle unauthorized
        if (isset($response['http_code']) && $response['http_code'] === 401) {
            header('Location: index.php?controller=Auth&action=logout');
            exit;
        }

        // Handle forbidden
        if (isset($response['http_code']) && $response['http_code'] === 403) {
            $errorMessage = 'Anda tidak memiliki hak akses untuk menambah data kecamatan.';
            header('Location: index.php?controller=Wilayah&action=createKecamatan&error=' . urlencode($errorMessage));
            exit;
        }

        if ($response['success']) {
            header('Location: index.php?controller=Wilayah&action=indexKecamatan&success=' . urlencode('Kecamatan berhasil ditambahkan'));
            exit;
        } else {
            $errorMessage = $response['message'] ?? 'Gagal menambahkan kecamatan';
            header('Location: index.php?controller=Wilayah&action=createKecamatan&error=' . urlencode($errorMessage));
            exit;
        }
    }

    /**
     * Update existing kecamatan
     */
    public function updateKecamatan()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=Wilayah&action=indexKecamatan');
            exit;
        }

        $id = $_POST['id'] ?? null;

        if (!$id) {
            header('Location: index.php?controller=Wilayah&action=indexKecamatan&error=ID+kecamatan+tidak+ditemukan');
            exit;
        }

        $data = [
            'nama' => $_POST['nama'] ?? '',
            'id_kabupaten' => $_POST['id_kabupaten'] ?? null,
        ];

        // Validasi input
        if (empty($data['nama']) || empty($data['id_kabupaten'])) {
            header('Location: index.php?controller=Wilayah&action=editKecamatan&id=' . $id . '&error=Nama+kecamatan+dan+kabupaten+wajib+diisi');
            exit;
        }

        $response = $this->service->updateKecamatan($id, $data);

        // Handle unauthorized
        if (isset($response['http_code']) && $response['http_code'] === 401) {
            header('Location: index.php?controller=Auth&action=logout');
            exit;
        }

        // Handle forbidden
        if (isset($response['http_code']) && $response['http_code'] === 403) {
            $errorMessage = 'Anda tidak memiliki hak akses untuk mengedit data kecamatan.';
            header('Location: index.php?controller=Wilayah&action=editKecamatan&id=' . $id . '&error=' . urlencode($errorMessage));
            exit;
        }

        if ($response['success']) {
            header('Location: index.php?controller=Wilayah&action=indexKecamatan&success=' . urlencode('Kecamatan berhasil diperbarui'));
            exit;
        } else {
            $errorMessage = $response['message'] ?? 'Gagal memperbarui kecamatan';
            header('Location: index.php?controller=Wilayah&action=editKecamatan&id=' . $id . '&error=' . urlencode($errorMessage));
            exit;
        }
    }

    /**
     * Delete kecamatan
     */
    public function deleteKecamatan()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: index.php?controller=Wilayah&action=indexKecamatan&error=ID+kecamatan+tidak+ditemukan');
            exit;
        }

        $response = $this->service->deleteKecamatan($id);

        // Handle unauthorized
        if (isset($response['http_code']) && $response['http_code'] === 401) {
            header('Location: index.php?controller=Auth&action=logout');
            exit;
        }

        // Handle forbidden
        if (isset($response['http_code']) && $response['http_code'] === 403) {
            $errorMessage = 'Anda tidak memiliki hak akses untuk menghapus data kecamatan.';
            header('Location: index.php?controller=Wilayah&action=indexKecamatan&error=' . urlencode($errorMessage));
            exit;
        }

        if ($response['success']) {
            header('Location: index.php?controller=Wilayah&action=indexKecamatan&success=' . urlencode('Kecamatan berhasil dihapus'));
            exit;
        } else {
            $errorMessage = $response['message'] ?? 'Gagal menghapus kecamatan';
            header('Location: index.php?controller=Wilayah&action=indexKecamatan&error=' . urlencode($errorMessage));
            exit;
        }
    }
}
