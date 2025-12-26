<?php include('template/header.php'); ?>

<body class="with-welcome-text">
  <div class="container-scroller">
    <?php include 'template/navbar.php'; ?>
    <div class="container-fluid page-body-wrapper">
      <?php include 'template/setting_panel.php'; ?>
      <?php include 'template/sidebar.php'; ?>
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-sm-12">
              <div class="page-header">
                <h3 class="page-title">Data Kabupaten</h3>
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Wilayah</li>
                    <li class="breadcrumb-item active" aria-current="page">Kabupaten</li>
                  </ol>
                </nav>
              </div>

              <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title">Daftar Kabupaten/Kota</h4>
                        <a href="index.php?controller=Wilayah&action=createKabupaten<?php echo isset($_GET['provinsi_id']) ? '&provinsi_id=' . $_GET['provinsi_id'] : ''; ?>" class="btn btn-primary btn-sm">
                          <i class="mdi mdi-plus-circle-outline mr-1"></i> Tambah Kabupaten
                        </a>
                      </div>

                      <div class="row mb-4">
                        <div class="col-md-6">
                          <form method="GET" class="form-inline">
                            <input type="hidden" name="controller" value="Wilayah">
                            <input type="hidden" name="action" value="indexKabupaten">

                            <div class="form-group mb-2 w-100">
                              <label class="mr-2">Provinsi:</label>
                              <select name="provinsi_id" id="provinsi_id" class="form-control w-100" onchange="this.form.submit()">
                                <option value="">-- Pilih Provinsi --</option>
                                <?php foreach ($provinsiList as $provinsi): ?>
                                  <option value="<?php echo $provinsi['id']; ?>" <?php echo ((isset($_GET['provinsi_id']) && $_GET['provinsi_id'] == $provinsi['id']) ? 'selected' : ''); ?>>
                                    <?php echo htmlspecialchars($provinsi['nama'] ?? $provinsi['name'] ?? ''); ?>
                                  </option>
                                <?php endforeach; ?>
                              </select>
                            </div>
                          </form>
                        </div>
                      </div>

                      <div class="table-responsive">
                        <table class="table table-hover">
                          <thead>
                            <tr class="bg-primary text-white">
                              <th>#</th>
                              <th>Nama Kabupaten</th>
                              <th>Provinsi</th>
                              <th class="text-center">Aksi</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php if (!empty($kabupatenList)): ?>
                              <?php $no = 1; ?>
                              <?php foreach ($kabupatenList as $kabupaten): ?>
                                <tr>
                                  <td><?php echo $no++; ?></td>
                                  <td>
                                    <div class="font-weight-medium"><?php echo htmlspecialchars($kabupaten['nama'] ?? $kabupaten['name'] ?? ''); ?></div>
                                  </td>
                                  <td>
                                    <?php
                                      // Handle different possible structures for provinsi
                                      $provinsi_nama = '';
                                      if (isset($kabupaten['provinsi'])) {
                                          $provinsi_nama = $kabupaten['provinsi']['nama'] ?? $kabupaten['provinsi']['name'] ?? '';
                                      } elseif (isset($kabupaten['id_provinsi'])) {
                                          // If we only have the ID, we might need to get the name from provinsiList
                                          foreach ($provinsiList as $prov) {
                                              if ($prov['id'] == $kabupaten['id_provinsi']) {
                                                  $provinsi_nama = $prov['nama'] ?? $prov['name'] ?? '';
                                                  break;
                                              }
                                          }
                                      }
                                      echo htmlspecialchars($provinsi_nama);
                                    ?>
                                  </td>
                                  <td class="text-center">
                                    <div class="btn-group" role="group">
                                      <a href="index.php?controller=Wilayah&action=editKabupaten&id=<?php echo $kabupaten['id']; ?>&provinsi_id=<?php echo $_GET['provinsi_id'] ?? ''; ?>" class="btn btn-outline-warning btn-sm" title="Edit">
                                        <i class="mdi mdi-pencil"></i>
                                      </a>
                                      <form method="POST" action="index.php?controller=Wilayah&action=deleteKabupaten&id=<?php echo $kabupaten['id']; ?>" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kabupaten ini?');">
                                        <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus">
                                          <i class="mdi mdi-delete"></i>
                                        </button>
                                      </form>
                                    </div>
                                  </td>
                                </tr>
                              <?php endforeach; ?>
                            <?php else: ?>
                              <tr>
                                <td colspan="4" class="text-center py-5">
                                  <div class="d-flex flex-column align-items-center justify-content-center">
                                    <i class="mdi mdi-map-marker-off mdi-48px text-muted mb-3"></i>
                                    <h5 class="text-muted">Tidak ada data kabupaten</h5>
                                    <p class="text-muted">Silakan pilih provinsi untuk melihat daftar kabupaten</p>
                                  </div>
                                </td>
                              </tr>
                            <?php endif; ?>
                          </tbody>
                        </table>
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
  </div>
  <?php include 'template/script.php'; ?>
</body>
</html>