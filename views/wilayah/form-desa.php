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
                <h3 class="page-title"><?php echo $isEdit ? 'Edit' : 'Tambah'; ?> Desa</h3>
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="index.php?controller=Wilayah&action=indexDesa">Wilayah</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $isEdit ? 'Edit' : 'Tambah'; ?> Desa</li>
                  </ol>
                </nav>
              </div>

              <div class="row">
                <div class="col-lg-8 mx-auto">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title"><?php echo $isEdit ? 'Edit' : 'Tambah'; ?> Data Desa</h4>
                      <p class="card-description"><?php echo $isEdit ? 'Edit' : 'Tambah'; ?> data desa baru</p>

                      <form action="index.php?controller=Wilayah&action=<?php echo $isEdit ? 'updateDesa&id=' . $desa['id'] : 'storeDesa'; ?>" method="POST" class="forms-sample">
                        <?php if ($isEdit && isset($desa['kecamatan']) && isset($desa['kecamatan']['kabupaten']) && isset($desa['kecamatan']['kabupaten']['provinsi'])): ?>
                        <div class="form-group row">
                          <label for="id_provinsi" class="col-sm-3 col-form-label">Provinsi</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars(isset($desa['kecamatan']['kabupaten']['provinsi']['nama']) ? $desa['kecamatan']['kabupaten']['provinsi']['nama'] : (isset($desa['kecamatan']['kabupaten']['provinsi']['name']) ? $desa['kecamatan']['kabupaten']['provinsi']['name'] : '')); ?>" readonly>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="id_kabupaten" class="col-sm-3 col-form-label">Kabupaten</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars(isset($desa['kecamatan']['kabupaten']['nama']) ? $desa['kecamatan']['kabupaten']['nama'] : (isset($desa['kecamatan']['kabupaten']['name']) ? $desa['kecamatan']['kabupaten']['name'] : '')); ?>" readonly>
                          </div>
                        </div>
                        <?php else: ?>
                        <div class="form-group row">
                          <label for="id_provinsi" class="col-sm-3 col-form-label">Provinsi</label>
                          <div class="col-sm-9">
                            <select class="form-control" id="id_provinsi" name="id_provinsi" required onchange="loadKabupatenByProvinsi()">
                              <option value="">-- Pilih Provinsi --</option>
                              <?php foreach ($provinsiList as $provinsi): ?>
                                <option value="<?php echo $provinsi['id']; ?>"
                                  <?php echo ((isset($_GET['provinsi_id']) && $_GET['provinsi_id'] == $provinsi['id']) ? 'selected' : ''); ?>>
                                  <?php echo htmlspecialchars($provinsi['nama'] ?? $provinsi['name'] ?? ''); ?>
                                </option>
                              <?php endforeach; ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="id_kabupaten" class="col-sm-3 col-form-label">Kabupaten</label>
                          <div class="col-sm-9">
                            <select class="form-control" id="id_kabupaten" name="id_kabupaten" required onchange="loadKecamatanByKabupaten()">
                              <option value="">-- Pilih Kabupaten --</option>
                              <?php foreach ($kabupatenList as $kabupaten): ?>
                                <option value="<?php echo $kabupaten['id']; ?>"
                                  <?php echo ((isset($_GET['kabupaten_id']) && $_GET['kabupaten_id'] == $kabupaten['id']) ? 'selected' : ''); ?>>
                                  <?php echo htmlspecialchars($kabupaten['nama'] ?? $kabupaten['name'] ?? ''); ?>
                                </option>
                              <?php endforeach; ?>
                            </select>
                          </div>
                        </div>
                        <?php endif; ?>

                        <div class="form-group row">
                          <label for="id_kecamatan" class="col-sm-3 col-form-label">Kecamatan</label>
                          <div class="col-sm-9">
                            <select class="form-control" id="id_kecamatan" name="id_kecamatan" required>
                              <option value="">-- Pilih Kecamatan --</option>
                              <?php foreach ($kecamatanList as $kecamatan): ?>
                                <option value="<?php echo $kecamatan['id']; ?>"
                                  <?php echo ((isset($desa['id_kecamatan']) && $desa['id_kecamatan'] == $kecamatan['id']) ? 'selected' :
                                             ((isset($desa['id_parent']) && $desa['id_parent'] == $kecamatan['id']) ? 'selected' :
                                             ((isset($_GET['kecamatan_id']) && $_GET['kecamatan_id'] == $kecamatan['id']) ? 'selected' : ''))); ?>>
                                  <?php echo htmlspecialchars($kecamatan['nama'] ?? $kecamatan['name'] ?? ''); ?>
                                </option>
                              <?php endforeach; ?>
                            </select>
                          </div>
                        </div>

                        <div class="form-group row">
                          <label for="nama" class="col-sm-3 col-form-label">Nama Desa</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama desa"
                              value="<?php echo htmlspecialchars($desa['nama'] ?? $desa['name'] ?? ''); ?>" required>
                          </div>
                        </div>

                        <div class="mt-4">
                          <button type="submit" class="btn btn-primary mr-2"><?php echo $isEdit ? 'Update' : 'Simpan'; ?></button>
                          <a href="index.php?controller=Wilayah&action=indexDesa<?php echo (isset($_GET['kecamatan_id']) ? '&kecamatan_id=' . $_GET['kecamatan_id'] : ''); ?>" class="btn btn-light">Batal</a>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

                  <script>
                    function loadKabupatenByProvinsi() {
                      const provinsiId = document.getElementById('id_provinsi').value;
                      const kabupatenSelect = document.getElementById('id_kabupaten');

                      // Clear existing options except the first placeholder
                      kabupatenSelect.innerHTML = '<option value="">-- Pilih Kabupaten --</option>';

                      if (provinsiId) {
                        // Show loading state
                        kabupatenSelect.innerHTML = '<option value="">Memuat...</option>';

                        // Make AJAX request to get kabupatens for the selected provinsi
                        fetch(`index.php?controller=Wilayah&action=getKabupatenByProvinsi&id=${provinsiId}`)
                          .then(response => response.json())
                          .then(data => {
                            // Clear loading state
                            kabupatenSelect.innerHTML = '<option value="">-- Pilih Kabupaten --</option>';

                            if (data.success && data.data) {
                              data.data.forEach(function(kabupaten) {
                                const option = document.createElement('option');
                                option.value = kabupaten.id;
                                option.textContent = kabupaten.nama || kabupaten.name || '';
                                kabupatenSelect.appendChild(option);
                              });
                            }
                          })
                          .catch(error => {
                            console.error('Error:', error);
                            kabupatenSelect.innerHTML = '<option value="">-- Pilih Kabupaten --</option>';
                          });
                      }
                    }

                    function loadKecamatanByKabupaten() {
                      const kabupatenId = document.getElementById('id_kabupaten').value;
                      const kecamatanSelect = document.getElementById('id_kecamatan');

                      // Clear existing options except the first placeholder
                      kecamatanSelect.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';

                      if (kabupatenId) {
                        // Show loading state
                        kecamatanSelect.innerHTML = '<option value="">Memuat...</option>';

                        // Make AJAX request to get kecamatans for the selected kabupaten
                        fetch(`index.php?controller=Wilayah&action=getKecamatanByKabupaten&id=${kabupatenId}`)
                          .then(response => response.json())
                          .then(data => {
                            // Clear loading state
                            kecamatanSelect.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';

                            if (data.success && data.data) {
                              data.data.forEach(function(kecamatan) {
                                const option = document.createElement('option');
                                option.value = kecamatan.id;
                                option.textContent = kecamatan.nama || kecamatan.name || '';
                                kecamatanSelect.appendChild(option);
                              });
                            }
                          })
                          .catch(error => {
                            console.error('Error:', error);
                            kecamatanSelect.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
                          });
                      }
                    }
                  </script>
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