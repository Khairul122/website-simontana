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
                <h3 class="page-title">Data Desa</h3>
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Wilayah</li>
                    <li class="breadcrumb-item active" aria-current="page">Desa</li>
                  </ol>
                </nav>
              </div>

              <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title">Daftar Desa/Kelurahan</h4>
                        <a href="index.php?controller=Wilayah&action=createDesa<?php echo isset($_GET['kecamatan_id']) ? '&kecamatan_id=' . $_GET['kecamatan_id'] : ''; ?>" class="btn btn-primary btn-sm">
                          <i class="mdi mdi-plus-circle-outline mr-1"></i> Tambah Desa
                        </a>
                      </div>

                      <div class="row mb-4">
                        <div class="col-md-4">
                          <form method="GET" class="form-inline">
                            <input type="hidden" name="controller" value="Wilayah">
                            <input type="hidden" name="action" value="indexDesa">

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

                        <div class="col-md-4">
                          <form method="GET" class="form-inline">
                            <input type="hidden" name="controller" value="Wilayah">
                            <input type="hidden" name="action" value="indexDesa">
                            <input type="hidden" name="provinsi_id" value="<?php echo htmlspecialchars($_GET['provinsi_id'] ?? ''); ?>">

                            <div class="form-group mb-2 w-100">
                              <label class="mr-2">Kabupaten:</label>
                              <select name="kabupaten_id" id="kabupaten_id" class="form-control w-100" onchange="this.form.submit()">
                                <option value="">-- Pilih Kabupaten --</option>
                                <?php foreach ($kabupatenList as $kabupaten): ?>
                                  <option value="<?php echo $kabupaten['id']; ?>" <?php echo ((isset($_GET['kabupaten_id']) && $_GET['kabupaten_id'] == $kabupaten['id']) ? 'selected' : ''); ?>>
                                    <?php echo htmlspecialchars($kabupaten['nama'] ?? $kabupaten['name'] ?? ''); ?>
                                  </option>
                                <?php endforeach; ?>
                              </select>
                            </div>
                          </form>
                        </div>

                        <div class="col-md-4">
                          <form method="GET" class="form-inline">
                            <input type="hidden" name="controller" value="Wilayah">
                            <input type="hidden" name="action" value="indexDesa">
                            <input type="hidden" name="provinsi_id" value="<?php echo htmlspecialchars($_GET['provinsi_id'] ?? ''); ?>">
                            <input type="hidden" name="kabupaten_id" value="<?php echo htmlspecialchars($_GET['kabupaten_id'] ?? ''); ?>">

                            <div class="form-group mb-2 w-100">
                              <label class="mr-2">Kecamatan:</label>
                              <select name="kecamatan_id" id="kecamatan_id" class="form-control w-100" onchange="this.form.submit()">
                                <option value="">-- Pilih Kecamatan --</option>
                                <?php foreach ($kecamatanList as $kecamatan): ?>
                                  <option value="<?php echo $kecamatan['id']; ?>" <?php echo ((isset($_GET['kecamatan_id']) && $_GET['kecamatan_id'] == $kecamatan['id']) ? 'selected' : ''); ?>>
                                    <?php echo htmlspecialchars($kecamatan['nama'] ?? $kecamatan['name'] ?? ''); ?>
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
                              <th>Nama Desa</th>
                              <th>Kecamatan</th>
                              <th>Kabupaten</th>
                              <th>Provinsi</th>
                              <th class="text-center">Aksi</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php if (!empty($desaList)): ?>
                              <?php $no = 1; ?>
                              <?php foreach ($desaList as $desa): ?>
                                <tr>
                                  <td><?php echo $no++; ?></td>
                                  <td>
                                    <div class="font-weight-medium"><?php echo htmlspecialchars($desa['nama'] ?? $desa['name'] ?? ''); ?></div>
                                  </td>
                                  <td>
                                    <?php
                                      // Handle different possible structures for kecamatan
                                      $kecamatan_nama = '';
                                      if (isset($desa['kecamatan'])) {
                                          $kecamatan_nama = $desa['kecamatan']['nama'] ?? $desa['kecamatan']['name'] ?? '';
                                      } elseif (isset($desa['id_kecamatan'])) {
                                          // If we only have the ID, we might need to get the name from kecamatanList
                                          foreach ($kecamatanList as $kec) {
                                              if ($kec['id'] == $desa['id_kecamatan']) {
                                                  $kecamatan_nama = $kec['nama'] ?? $kec['name'] ?? '';
                                                  break;
                                              }
                                          }
                                      }
                                      echo htmlspecialchars($kecamatan_nama);
                                    ?>
                                  </td>
                                  <td>
                                    <?php
                                      // Handle different possible structures for kabupaten
                                      $kabupaten_nama = '';
                                      if (isset($desa['kecamatan']) && isset($desa['kecamatan']['kabupaten'])) {
                                          $kabupaten_nama = $desa['kecamatan']['kabupaten']['nama'] ?? $desa['kecamatan']['kabupaten']['name'] ?? '';
                                      } elseif (isset($desa['id_kecamatan'])) {
                                          // If we have kecamatan ID, find the kabupaten through kecamatanList
                                          foreach ($kecamatanList as $kec) {
                                              if ($kec['id'] == $desa['id_kecamatan']) {
                                                  if (isset($kec['kabupaten'])) {
                                                      $kabupaten_nama = $kec['kabupaten']['nama'] ?? $kec['kabupaten']['name'] ?? '';
                                                  }
                                                  break;
                                              }
                                          }
                                      }
                                      echo htmlspecialchars($kabupaten_nama);
                                    ?>
                                  </td>
                                  <td>
                                    <?php
                                      // Handle different possible structures for provinsi
                                      $provinsi_nama = '';
                                      if (isset($desa['kecamatan']) && isset($desa['kecamatan']['kabupaten']) && isset($desa['kecamatan']['kabupaten']['provinsi'])) {
                                          $provinsi_nama = $desa['kecamatan']['kabupaten']['provinsi']['nama'] ?? $desa['kecamatan']['kabupaten']['provinsi']['name'] ?? '';
                                      } elseif (isset($desa['id_kecamatan'])) {
                                          // If we have kecamatan ID, find the provinsi through kecamatanList
                                          foreach ($kecamatanList as $kec) {
                                              if ($kec['id'] == $desa['id_kecamatan']) {
                                                  if (isset($kec['kabupaten']) && isset($kec['kabupaten']['provinsi'])) {
                                                      $provinsi_nama = $kec['kabupaten']['provinsi']['nama'] ?? $kec['kabupaten']['provinsi']['name'] ?? '';
                                                  } else {
                                                      // If provinsi is not nested in kecamatan->kabupaten, try to find it through kabupatenList
                                                      foreach ($kabupatenList as $kab) {
                                                          if ($kab['id'] == $kec['id_kabupaten']) {
                                                              if (isset($kab['provinsi'])) {
                                                                  $provinsi_nama = $kab['provinsi']['nama'] ?? $kab['provinsi']['name'] ?? '';
                                                              } else {
                                                                  // If provinsi is not nested in kabupaten, try to find it in provinsiList
                                                                  foreach ($provinsiList as $prov) {
                                                                      if ($prov['id'] == $kab['id_provinsi']) {
                                                                          $provinsi_nama = $prov['nama'] ?? $prov['name'] ?? '';
                                                                          break;
                                                                      }
                                                                  }
                                                              }
                                                              break;
                                                          }
                                                      }
                                                  }
                                                  break;
                                              }
                                          }
                                      }
                                      echo htmlspecialchars($provinsi_nama);
                                    ?>
                                  </td>
                                  <td class="text-center">
                                    <div class="btn-group" role="group">
                                      <a href="index.php?controller=Wilayah&action=editDesa&id=<?php echo $desa['id']; ?>&kecamatan_id=<?php echo $_GET['kecamatan_id'] ?? ''; ?>" class="btn btn-outline-warning btn-sm" title="Edit">
                                        <i class="mdi mdi-pencil"></i>
                                      </a>
                                      <form method="POST" action="index.php?controller=Wilayah&action=deleteDesa&id=<?php echo $desa['id']; ?>" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus desa ini?');">
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
                                <td colspan="6" class="text-center py-5">
                                  <div class="d-flex flex-column align-items-center justify-content-center">
                                    <i class="mdi mdi-map-marker-off mdi-48px text-muted mb-3"></i>
                                    <h5 class="text-muted">Tidak ada data desa</h5>
                                    <p class="text-muted">Silakan pilih kecamatan untuk melihat daftar desa</p>
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