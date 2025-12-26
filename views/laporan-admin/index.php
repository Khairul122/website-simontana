<?php include('template/header.php'); ?>

<style>
  .table th {
    font-weight: 600;
    color: #495057;
    border-top: none;
    background-color: #f8f9fa;
  }

  .table-hover tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.05);
  }

  .card {
    border: none;
    box-shadow: 0 0.1rem 0.7rem rgba(0, 0, 0, 0.1);
    border-radius: 0.5rem;
  }

  .page-title {
    font-weight: 600;
    color: #2c2c2c;
  }

  .card-title {
    font-weight: 600;
    color: #2c2c2c;
  }

  .btn-group .btn {
    margin: 0 1px;
  }

  .table-responsive {
    border-radius: 0.5rem;
  }

  .badge {
    font-size: 0.8em;
    font-weight: 500;
    padding: 0.5em 0.75em;
  }

  .bg-orange {
    background-color: #fd7e14;
    color: white;
  }

  .pagination .page-link {
    border-radius: 0.375rem;
    margin: 0 0.2rem;
  }

  .form-select, .form-control {
    border-radius: 0.375rem;
  }

  .input-group .form-control {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
  }

  .input-group .input-group-append .input-group-text {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
    border-top-right-radius: 0.375rem;
    border-bottom-right-radius: 0.375rem;
  }

  .table th {
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .table th:hover {
    background-color: #e9ecef;
  }

  .table th.sortable::after {
    content: ' ↕';
    font-size: 0.8em;
    opacity: 0.5;
  }

  .table th.sort-asc::after {
    content: ' ↑';
    opacity: 1;
  }

  .table th.sort-desc::after {
    content: ' ↓';
    opacity: 1;
  }
</style>

<body class="with-welcome-text">
  <div class="container-scroller">
    <?php include 'template/navbar.php'; ?>
    <div class="container-fluid page-body-wrapper">
      <?php include 'template/setting_panel.php'; ?>
      <?php include 'template/sidebar.php'; ?>
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-12">
              <div class="page-header">
                <h3 class="page-title">Data Laporan Bencana</h3>
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Laporan Bencana</li>
                  </ol>
                </nav>
              </div>

              <div class="row">
                <div class="col-12 grid-margin">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                        <div>
                          <h4 class="card-title mb-1">Daftar Laporan Bencana</h4>
                          <p class="card-description mb-0">Laporan bencana yang terdaftar dalam sistem</p>
                        </div>
                        <div class="d-flex gap-2">
                          <div class="input-group" style="width: 300px;">
                            <input type="text" class="form-control" id="search" name="search" placeholder="Cari judul atau deskripsi..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                            <div class="input-group-append">
                              <span class="input-group-text bg-transparent"><i class="mdi mdi-magnify"></i></span>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="row mb-4">
                        <div class="col-md-12">
                          <form method="GET" class="d-flex flex-wrap gap-3">
                            <input type="hidden" name="controller" value="LaporanAdmin">
                            <input type="hidden" name="action" value="index">

                            <div class="form-group mb-2">
                              <label for="status" class="form-label">Status:</label>
                              <select name="status" id="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="Menunggu Verifikasi" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Menunggu Verifikasi') ? 'selected' : ''; ?>>Menunggu Verifikasi</option>
                                <option value="Diproses" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Diproses') ? 'selected' : ''; ?>>Diproses</option>
                                <option value="Selesai" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Selesai') ? 'selected' : ''; ?>>Selesai</option>
                                <option value="Ditolak" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Ditolak') ? 'selected' : ''; ?>>Ditolak</option>
                              </select>
                            </div>

                            <div class="form-group mb-2">
                              <label for="tingkat_keparahan" class="form-label">Tingkat Keparahan:</label>
                              <select name="tingkat_keparahan" id="tingkat_keparahan" class="form-select">
                                <option value="">Semua Tingkat</option>
                                <option value="Rendah" <?php echo (isset($_GET['tingkat_keparahan']) && $_GET['tingkat_keparahan'] == 'Rendah') ? 'selected' : ''; ?>>Rendah</option>
                                <option value="Sedang" <?php echo (isset($_GET['tingkat_keparahan']) && $_GET['tingkat_keparahan'] == 'Sedang') ? 'selected' : ''; ?>>Sedang</option>
                                <option value="Tinggi" <?php echo (isset($_GET['tingkat_keparahan']) && $_GET['tingkat_keparahan'] == 'Tinggi') ? 'selected' : ''; ?>>Tinggi</option>
                                <option value="Sangat Tinggi" <?php echo (isset($_GET['tingkat_keparahan']) && $_GET['tingkat_keparahan'] == 'Sangat Tinggi') ? 'selected' : ''; ?>>Sangat Tinggi</option>
                              </select>
                            </div>

                            <button type="submit" class="btn btn-primary mb-2 align-self-end">
                              <i class="mdi mdi-filter-variant"></i> Filter
                            </button>
                            <a href="index.php?controller=LaporanAdmin&action=index" class="btn btn-outline-secondary mb-2 align-self-end">
                              <i class="mdi mdi-refresh"></i> Reset
                            </a>
                          </form>
                        </div>
                      </div>

                      <?php if (isset($_SESSION['toast_message'])): ?>
                        <div class="alert alert-<?php echo $_SESSION['toast_message']['type']; ?> alert-dismissible fade show" role="alert">
                          <strong><?php echo $_SESSION['toast_message']['title']; ?></strong> <?php echo $_SESSION['toast_message']['message']; ?>
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php unset($_SESSION['toast_message']); ?>
                      <?php endif; ?>

                      <div class="table-responsive">
                        <table class="table table-hover" id="laporanTable">
                          <thead class="table-light">
                            <tr>
                              <th class="text-center">
                                <input type="checkbox" id="selectAll" class="form-check-input">
                              </th>
                              <th class="sortable">No</th>
                              <th class="sortable">Judul Laporan</th>
                              <th class="sortable">Pelapor</th>
                              <th class="sortable">Lokasi</th>
                              <th class="sortable">Tingkat Keparahan</th>
                              <th class="sortable">Status</th>
                              <th class="sortable">Tanggal</th>
                              <th class="text-center">Aksi</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php if (!empty($laporanList)): ?>
                              <?php $no = (($_GET['page'] ?? 1) - 1) * ($pagination['per_page'] ?? 15) + 1; ?>
                              <?php foreach ($laporanList as $laporan): ?>
                                <tr>
                                  <td class="text-center">
                                    <input type="checkbox" class="form-check-input row-checkbox" value="<?php echo $laporan['id']; ?>">
                                  </td>
                                  <td><?php echo $no++; ?></td>
                                  <td>
                                    <div class="fw-medium"><?php echo htmlspecialchars($laporan['judul_laporan'] ?? $laporan['judul'] ?? $laporan['name'] ?? ''); ?></div>
                                    <small class="text-muted d-block"><?php echo htmlspecialchars(substr($laporan['deskripsi'] ?? $laporan['description'] ?? '', 0, 60)) . (strlen($laporan['deskripsi'] ?? $laporan['description'] ?? '') > 60 ? '...' : ''); ?></small>
                                  </td>
                                  <td><?php echo htmlspecialchars($laporan['pelapor']['nama'] ?? $laporan['pelapor']['username'] ?? $laporan['user']['nama'] ?? $laporan['user']['username'] ?? ''); ?></td>
                                  <td>
                                    <?php
                                      $desa = $laporan['desa']['nama'] ?? '';
                                      $kecamatan = $laporan['desa']['kecamatan']['nama'] ?? '';
                                      $kabupaten = $laporan['desa']['kecamatan']['kabupaten']['nama'] ?? '';
                                      $provinsi = $laporan['desa']['kecamatan']['kabupaten']['provinsi']['nama'] ?? '';

                                      $lokasi = [];
                                      if ($desa) $lokasi[] = $desa;
                                      if ($kecamatan) $lokasi[] = $kecamatan;
                                      if ($kabupaten) $lokasi[] = $kabupaten;
                                      if ($provinsi) $lokasi[] = $provinsi;

                                      echo htmlspecialchars(implode(', ', $lokasi));
                                    ?>
                                  </td>
                                  <td>
                                    <?php
                                      $tingkat = $laporan['tingkat_keparahan'] ?? $laporan['tingkat_kedaruratan'] ?? '';
                                      $tingkatClass = '';
                                      switch ($tingkat) {
                                        case 'Rendah':
                                          $tingkatClass = 'badge bg-success';
                                          break;
                                        case 'Sedang':
                                          $tingkatClass = 'badge bg-warning text-dark';
                                          break;
                                        case 'Tinggi':
                                          $tingkatClass = 'badge bg-orange';
                                          break;
                                        case 'Sangat Tinggi':
                                          $tingkatClass = 'badge bg-danger';
                                          break;
                                        default:
                                          $tingkatClass = 'badge bg-secondary';
                                      }
                                    ?>
                                    <span class="<?php echo $tingkatClass; ?>"><?php echo htmlspecialchars($tingkat); ?></span>
                                  </td>
                                  <td>
                                    <?php
                                      $status = $laporan['status'] ?? '';
                                      $badgeClass = '';
                                      switch ($status) {
                                        case 'Menunggu Verifikasi':
                                          $badgeClass = 'badge bg-warning text-dark';
                                          break;
                                        case 'Diproses':
                                          $badgeClass = 'badge bg-info';
                                          break;
                                        case 'Selesai':
                                          $badgeClass = 'badge bg-success';
                                          break;
                                        case 'Ditolak':
                                          $badgeClass = 'badge bg-danger';
                                          break;
                                        default:
                                          $badgeClass = 'badge bg-secondary';
                                      }
                                    ?>
                                    <span class="<?php echo $badgeClass; ?>"><?php echo htmlspecialchars($status); ?></span>
                                  </td>
                                  <td><?php echo date('d M Y', strtotime($laporan['waktu_laporan'] ?? $laporan['created_at'] ?? '')); ?></td>
                                  <td class="text-center">
                                    <div class="btn-group" role="group">
                                      <a href="index.php?controller=LaporanAdmin&action=detail&id=<?php echo $laporan['id']; ?>" class="btn btn-outline-info btn-sm" title="Detail">
                                        <i class="mdi mdi-eye"></i>
                                      </a>
                                      <a href="index.php?controller=LaporanAdmin&action=edit&id=<?php echo $laporan['id']; ?>" class="btn btn-outline-warning btn-sm" title="Edit">
                                        <i class="mdi mdi-pencil"></i>
                                      </a>
                                      <form method="POST" action="index.php?controller=LaporanAdmin&action=delete&id=<?php echo $laporan['id']; ?>" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?');">
                                        <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus">
                                          <i class="mdi mdi-trash-can"></i>
                                        </button>
                                      </form>
                                    </div>
                                  </td>
                                </tr>
                              <?php endforeach; ?>
                            <?php else: ?>
                              <tr>
                                <td colspan="9" class="text-center py-5">
                                  <div class="d-flex flex-column align-items-center justify-content-center">
                                    <i class="mdi mdi-alert-octagram mdi-48px text-muted mb-3"></i>
                                    <h5 class="text-muted">Tidak ada data laporan bencana</h5>
                                    <p class="text-muted">Belum ada laporan bencana yang tersedia</p>
                                  </div>
                                </td>
                              </tr>
                            <?php endif; ?>
                          </tbody>
                        </table>
                      </div>

                      <?php if ($pagination && $pagination['last_page'] > 1): ?>
                        <nav aria-label="Laporan pagination" class="mt-4">
                          <ul class="pagination justify-content-center flex-wrap">
                            <?php if ($pagination['current_page'] > 1): ?>
                              <li class="page-item">
                                <a class="page-link" href="index.php?controller=LaporanAdmin&action=index&page=<?php echo $pagination['current_page'] - 1; ?>&<?php echo http_build_query(array_filter($_GET, function($key) { return $key !== 'page'; }, ARRAY_FILTER_USE_KEY)); ?>">&laquo; Sebelumnya</a>
                              </li>
                            <?php endif; ?>

                            <?php if ($pagination['current_page'] > 3): ?>
                              <li class="page-item">
                                <a class="page-link" href="index.php?controller=LaporanAdmin&action=index&page=1&<?php echo http_build_query(array_filter($_GET, function($key) { return $key !== 'page'; }, ARRAY_FILTER_USE_KEY)); ?>">1</a>
                              </li>
                              <?php if ($pagination['current_page'] > 4): ?>
                                <li class="page-item disabled">
                                  <span class="page-link">...</span>
                                </li>
                              <?php endif; ?>
                            <?php endif; ?>

                            <?php for ($i = max(1, $pagination['current_page'] - 2); $i <= min($pagination['last_page'], $pagination['current_page'] + 2); $i++): ?>
                              <li class="page-item <?php echo ($i == $pagination['current_page']) ? 'active' : ''; ?>">
                                <a class="page-link" href="index.php?controller=LaporanAdmin&action=index&page=<?php echo $i; ?>&<?php echo http_build_query(array_filter($_GET, function($key) { return $key !== 'page'; }, ARRAY_FILTER_USE_KEY)); ?>"><?php echo $i; ?></a>
                              </li>
                            <?php endfor; ?>

                            <?php if ($pagination['current_page'] < $pagination['last_page'] - 2): ?>
                              <?php if ($pagination['last_page'] - $pagination['current_page'] > 3): ?>
                                <li class="page-item disabled">
                                  <span class="page-link">...</span>
                                </li>
                              <?php endif; ?>
                              <li class="page-item">
                                <a class="page-link" href="index.php?controller=LaporanAdmin&action=index&page=<?php echo $pagination['last_page']; ?>&<?php echo http_build_query(array_filter($_GET, function($key) { return $key !== 'page'; }, ARRAY_FILTER_USE_KEY)); ?>"><?php echo $pagination['last_page']; ?></a>
                              </li>
                            <?php endif; ?>

                            <?php if ($pagination['current_page'] < $pagination['last_page']): ?>
                              <li class="page-item">
                                <a class="page-link" href="index.php?controller=LaporanAdmin&action=index&page=<?php echo $pagination['current_page'] + 1; ?>&<?php echo http_build_query(array_filter($_GET, function($key) { return $key !== 'page'; }, ARRAY_FILTER_USE_KEY)); ?>">Berikutnya &raquo;</a>
                              </li>
                            <?php endif; ?>
                          </ul>
                        </nav>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include 'template/script.php'; ?>

  <script>
    // Select all checkbox functionality
    document.getElementById('selectAll').addEventListener('change', function() {
      const checkboxes = document.querySelectorAll('.row-checkbox');
      checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
      });
    });

    // Search functionality with live filtering
    document.getElementById('search').addEventListener('keyup', function() {
      const searchTerm = this.value.toLowerCase();
      const rows = document.querySelectorAll('#laporanTable tbody tr');

      rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
    });

    // Status filter functionality
    document.getElementById('status').addEventListener('change', function() {
      const statusFilter = this.value;
      const rows = document.querySelectorAll('#laporanTable tbody tr');

      rows.forEach(row => {
        if (statusFilter === '') {
          row.style.display = '';
        } else {
          const statusText = row.cells[6].textContent.trim();
          if (statusText === statusFilter) {
            row.style.display = '';
          } else {
            row.style.display = 'none';
          }
        }
      });
    });

    // Tingkat Keparahan filter functionality
    document.getElementById('tingkat_keparahan').addEventListener('change', function() {
      const tingkatFilter = this.value;
      const rows = document.querySelectorAll('#laporanTable tbody tr');

      rows.forEach(row => {
        if (tingkatFilter === '') {
          row.style.display = '';
        } else {
          const tingkatText = row.cells[5].textContent.trim();
          if (tingkatText === tingkatFilter) {
            row.style.display = '';
          } else {
            row.style.display = 'none';
          }
        }
      });
    });

    // Sort functionality for table headers
    document.querySelectorAll('#laporanTable th.sortable').forEach((header, index) => {
      header.style.cursor = 'pointer';
      header.addEventListener('click', function() {
        // Find the actual index of this header in the row
        const columnIndex = Array.from(this.parentElement.children).indexOf(this);
        sortTable(columnIndex);
      });
    });

    function sortTable(columnIndex) {
      const table = document.getElementById('laporanTable');
      const tbody = table.querySelector('tbody');
      const rows = Array.from(tbody.querySelectorAll('tr'));

      // Remove sort indicators from all headers
      document.querySelectorAll('#laporanTable th').forEach(th => {
        th.classList.remove('sort-asc', 'sort-desc');
      });

      // Determine sort direction based on current state of this header
      const currentHeader = document.querySelectorAll('#laporanTable th')[columnIndex];
      const isAscending = !currentHeader.classList.contains('sort-asc');

      // Add sort indicator to current header
      currentHeader.classList.toggle('sort-asc', isAscending);
      currentHeader.classList.toggle('sort-desc', !isAscending);

      rows.sort((a, b) => {
        const aVal = a.cells[columnIndex].textContent.trim();
        const bVal = b.cells[columnIndex].textContent.trim();

        // Check if values are numeric for proper sorting
        const aNum = parseFloat(aVal.replace(/,/g, ''));
        const bNum = parseFloat(bVal.replace(/,/g, ''));

        if (!isNaN(aNum) && !isNaN(bNum)) {
          return isAscending ? aNum - bNum : bNum - aNum;
        }

        // For date sorting
        const aDate = new Date(aVal);
        const bDate = new Date(bVal);
        if (!isNaN(aDate) && !isNaN(bDate)) {
          return isAscending ? aDate - bDate : bDate - aDate;
        }

        // For text sorting
        return isAscending ?
          aVal.localeCompare(bVal) :
          bVal.localeCompare(aVal);
      });

      // Clear the table and append sorted rows
      tbody.innerHTML = '';
      rows.forEach(row => tbody.appendChild(row));
    }

    // Bulk delete functionality
    function bulkDelete() {
      const selectedCheckboxes = document.querySelectorAll('.row-checkbox:checked');
      if (selectedCheckboxes.length === 0) {
        alert('Pilih setidaknya satu laporan untuk dihapus');
        return;
      }

      const ids = Array.from(selectedCheckboxes).map(checkbox => checkbox.value);
      if (confirm(`Apakah Anda yakin ingin menghapus ${selectedCheckboxes.length} laporan?`)) {
        // In a real implementation, you would send an AJAX request to handle bulk deletion
        // For now, we'll just show an alert - in a real system, you would submit a form or make an API call
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'index.php?controller=LaporanAdmin&action=bulkDelete';

        ids.forEach(id => {
          const input = document.createElement('input');
          input.type = 'hidden';
          input.name = 'ids[]';
          input.value = id;
          form.appendChild(input);
        });

        document.body.appendChild(form);
        form.submit();
      }
    }
  </script>
</body>
</html>