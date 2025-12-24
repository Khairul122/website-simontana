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
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Data Kecamatan</h4>
                  <p class="card-description">Daftar kecamatan di Indonesia</p>
                  
                  <div class="row">
                    <div class="col-12">
                      <form method="GET" class="form-inline mb-3">
                        <input type="hidden" name="controller" value="Wilayah">
                        <input type="hidden" name="action" value="indexKecamatan">
                        <div class="form-group mb-2 mr-2">
                          <label for="provinsi_id" class="sr-only">Provinsi</label>
                          <select name="provinsi_id" id="provinsi_id" class="form-control" onchange="this.form.submit()">
                            <option value="">-- Pilih Provinsi --</option>
                            <?php foreach ($provinsiList as $provinsi): ?>
                              <option value="<?php echo $provinsi['id']; ?>" <?php echo ((isset($_GET['provinsi_id']) && $_GET['provinsi_id'] == $provinsi['id']) ? 'selected' : ''); ?>>
                                <?php echo htmlspecialchars($provinsi['nama'] ?? $provinsi['name'] ?? ''); ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        
                        <div class="form-group mb-2">
                          <label for="kabupaten_id" class="sr-only">Kabupaten</label>
                          <select name="kabupaten_id" id="kabupaten_id" class="form-control" onchange="this.form.submit()">
                            <option value="">-- Pilih Kabupaten --</option>
                            <?php foreach ($kabupatenList as $kabupaten): ?>
                              <option value="<?php echo $kabupaten['id']; ?>" <?php echo ((isset($_GET['kabupaten_id']) && $_GET['kabupaten_id'] == $kabupaten['id']) ? 'selected' : ''); ?>>
                                <?php echo htmlspecialchars($kabupaten['nama'] ?? $kabupaten['name'] ?? ''); ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </form>
                      
                      <div class="template-demo d-flex justify-content-between">
                        <a href="index.php?controller=Wilayah&action=createKecamatan<?php echo isset($_GET['kabupaten_id']) ? '&kabupaten_id=' . $_GET['kabupaten_id'] : ''; ?>" class="btn btn-primary btn-fw">
                          <i class="mdi mdi-plus"></i>Tambah Kecamatan
                        </a>
                      </div>
                      
                      
                      <div class="table-responsive">
                        <table class="table table-striped">
                          <thead>
                            <tr>
                              <th>No</th>
                              <th>Nama Kecamatan</th>
                              <th>Kabupaten</th>
                              <th>Provinsi</th>
                              <th>Aksi</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php if (!empty($kecamatanList)): ?>
                              <?php $no = 1; ?>
                              <?php foreach ($kecamatanList as $kecamatan): ?>
                                <tr>
                                  <td><?php echo $no++; ?></td>
                                  <td><?php echo htmlspecialchars($kecamatan['nama'] ?? $kecamatan['name'] ?? ''); ?></td>
                                  <td><?php
                                    // Handle different possible structures for kabupaten
                                    $kabupaten_nama = '';
                                    if (isset($kecamatan['kabupaten'])) {
                                        $kabupaten_nama = $kecamatan['kabupaten']['nama'] ?? $kecamatan['kabupaten']['name'] ?? '';
                                    } elseif (isset($kecamatan['id_kabupaten'])) {
                                        // If we only have the ID, we might need to get the name from kabupatenList
                                        foreach ($kabupatenList as $kab) {
                                            if ($kab['id'] == $kecamatan['id_kabupaten']) {
                                                $kabupaten_nama = $kab['nama'] ?? $kab['name'] ?? '';
                                                break;
                                            }
                                        }
                                    }
                                    echo htmlspecialchars($kabupaten_nama);
                                  ?></td>
                                  <td><?php
                                    // Handle different possible structures for provinsi
                                    $provinsi_nama = '';
                                    if (isset($kecamatan['kabupaten']) && isset($kecamatan['kabupaten']['provinsi'])) {
                                        $provinsi_nama = $kecamatan['kabupaten']['provinsi']['nama'] ?? $kecamatan['kabupaten']['provinsi']['name'] ?? '';
                                    } elseif (isset($kecamatan['id_kabupaten'])) {
                                        // If we have kabupaten ID, find the provinsi through kabupatenList
                                        foreach ($kabupatenList as $kab) {
                                            if ($kab['id'] == $kecamatan['id_kabupaten']) {
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
                                    echo htmlspecialchars($provinsi_nama);
                                  ?></td>
                                  <td>
                                    <a href="index.php?controller=Wilayah&action=editKecamatan&id=<?php echo $kecamatan['id']; ?>&kabupaten_id=<?php echo $_GET['kabupaten_id'] ?? ''; ?>" class="btn btn-outline-warning btn-sm">Edit</a>
                                    <form method="POST" action="index.php?controller=Wilayah&action=deleteKecamatan&id=<?php echo $kecamatan['id']; ?>" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kecamatan ini?');">
                                      <button type="submit" class="btn btn-outline-danger btn-sm">Hapus</button>
                                    </form>
                                  </td>
                                </tr>
                              <?php endforeach; ?>
                            <?php else: ?>
                              <tr>
                                <td colspan="5" class="text-center">Tidak ada data kecamatan</td>
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