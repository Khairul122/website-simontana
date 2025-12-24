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
                  <h4 class="card-title">Data Kabupaten</h4>
                  <p class="card-description">Daftar kabupaten/kota di Indonesia</p>
                  
                  <div class="row">
                    <div class="col-12">
                      <form method="GET" class="form-inline mb-3">
                        <input type="hidden" name="controller" value="Wilayah">
                        <input type="hidden" name="action" value="indexKabupaten">
                        <div class="form-group mb-2">
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
                      </form>
                      
                      <div class="template-demo d-flex justify-content-between">
                        <a href="index.php?controller=Wilayah&action=createKabupaten<?php echo isset($_GET['provinsi_id']) ? '&provinsi_id=' . $_GET['provinsi_id'] : ''; ?>" class="btn btn-primary btn-fw">
                          <i class="mdi mdi-plus"></i>Tambah Kabupaten
                        </a>
                      </div>
                      
                      
                      <div class="table-responsive">
                        <table class="table table-striped">
                          <thead>
                            <tr>
                              <th>No</th>
                              <th>Nama Kabupaten</th>
                              <th>Provinsi</th>
                              <th>Aksi</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php if (!empty($kabupatenList)): ?>
                              <?php $no = 1; ?>
                              <?php foreach ($kabupatenList as $kabupaten): ?>
                                <tr>
                                  <td><?php echo $no++; ?></td>
                                  <td><?php echo htmlspecialchars($kabupaten['nama'] ?? $kabupaten['name'] ?? ''); ?></td>
                                  <td><?php
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
                                  ?></td>
                                  <td>
                                    <a href="index.php?controller=Wilayah&action=editKabupaten&id=<?php echo $kabupaten['id']; ?>&provinsi_id=<?php echo $_GET['provinsi_id'] ?? ''; ?>" class="btn btn-outline-warning btn-sm">Edit</a>
                                    <form method="POST" action="index.php?controller=Wilayah&action=deleteKabupaten&id=<?php echo $kabupaten['id']; ?>" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kabupaten ini?');">
                                      <button type="submit" class="btn btn-outline-danger btn-sm">Hapus</button>
                                    </form>
                                  </td>
                                </tr>
                              <?php endforeach; ?>
                            <?php else: ?>
                              <tr>
                                <td colspan="4" class="text-center">Tidak ada data kabupaten</td>
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