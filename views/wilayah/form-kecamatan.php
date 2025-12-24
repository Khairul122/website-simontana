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
                  <h4 class="card-title"><?php echo $isEdit ? 'Edit' : 'Tambah'; ?> Kecamatan</h4>
                  <p class="card-description"><?php echo $isEdit ? 'Edit' : 'Tambah'; ?> data kecamatan baru</p>
                  
                  <form action="index.php?controller=Wilayah&action=<?php echo $isEdit ? 'updateKecamatan&id=' . $kecamatan['id'] : 'storeKecamatan'; ?>" method="POST">
                    <?php if ($isEdit && isset($kecamatan['kabupaten']) && isset($kecamatan['kabupaten']['provinsi'])): ?>
                    <div class="form-group">
                      <label for="id_provinsi">Provinsi</label>
                      <input type="text" class="form-control" value="<?php echo htmlspecialchars(isset($kecamatan['kabupaten']['provinsi']['nama']) ? $kecamatan['kabupaten']['provinsi']['nama'] : (isset($kecamatan['kabupaten']['provinsi']['name']) ? $kecamatan['kabupaten']['provinsi']['name'] : '')); ?>" readonly>
                      <input type="hidden" name="id_provinsi" value="<?php echo isset($kecamatan['kabupaten']['id_provinsi']) ? $kecamatan['kabupaten']['id_provinsi'] : (isset($kecamatan['kabupaten']['id_parent']) ? $kecamatan['kabupaten']['id_parent'] : ''); ?>">
                    </div>
                    <?php else: ?>
                    <div class="form-group">
                      <label for="id_provinsi">Provinsi</label>
                      <select class="form-control" id="id_provinsi" name="id_provinsi" required onchange="loadKabupatenByProvinsi()">
                        <option value="">-- Pilih Provinsi --</option>
                        <?php foreach ($provinsiList as $provinsi): ?>
                          <option value="<?php echo $provinsi['id']; ?>"
                            <?php echo ((isset($kecamatan['kabupaten']['id_provinsi']) && $kecamatan['kabupaten']['id_provinsi'] == $provinsi['id']) ? 'selected' :
                                       ((isset($_GET['provinsi_id']) && $_GET['provinsi_id'] == $provinsi['id']) ? 'selected' : '')); ?>>
                            <?php echo htmlspecialchars($provinsi['nama'] ?? $provinsi['name'] ?? ''); ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <?php endif; ?>

                    <div class="form-group">
                      <label for="id_kabupaten">Kabupaten</label>
                      <select class="form-control" id="id_kabupaten" name="id_kabupaten" required>
                        <option value="">-- Pilih Kabupaten --</option>
                        <?php foreach ($kabupatenList as $kabupaten): ?>
                          <option value="<?php echo $kabupaten['id']; ?>"
                            <?php
                            $selected = '';
                            if (isset($kecamatan['id_kabupaten']) && $kecamatan['id_kabupaten'] == $kabupaten['id']) {
                                $selected = 'selected';
                            } elseif (isset($kecamatan['id_parent']) && $kecamatan['id_parent'] == $kabupaten['id']) {
                                $selected = 'selected';
                            } elseif (isset($_GET['kabupaten_id']) && $_GET['kabupaten_id'] == $kabupaten['id']) {
                                $selected = 'selected';
                            }
                            echo $selected;
                            ?>>
                            <?php echo htmlspecialchars($kabupaten['nama'] ?? $kabupaten['name'] ?? ''); ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </div>

                    <div class="form-group">
                      <label for="nama">Nama Kecamatan</label>
                      <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama kecamatan"
                        value="<?php echo htmlspecialchars($kecamatan['nama'] ?? $kecamatan['name'] ?? ''); ?>" required>
                    </div>

                    <button type="submit" class="btn btn-primary mr-2"><?php echo $isEdit ? 'Update' : 'Simpan'; ?></button>
                    <a href="index.php?controller=Wilayah&action=indexKecamatan<?php echo (isset($_GET['kabupaten_id']) ? '&kabupaten_id=' . $_GET['kabupaten_id'] : ''); ?>" class="btn btn-light">Batal</a>
                  </form>

                  <script>
                    function loadKabupatenByProvinsi() {
                      // Only allow changing provinsi when creating new data
                      <?php if (!$isEdit): ?>
                      const provinsiId = document.getElementById('id_provinsi').value;
                      if (provinsiId) {
                        window.location.href = 'index.php?controller=Wilayah&action=createKecamatan&provinsi_id=' + provinsiId;
                      }
                      <?php endif; ?>
                    }

                    // Prevent the onchange handler from working during edit mode
                    <?php if ($isEdit): ?>
                    document.addEventListener('DOMContentLoaded', function() {
                      // Disable the onchange handler for edit mode to prevent form reset
                      const provinsiSelect = document.getElementById('id_provinsi');
                      if (provinsiSelect) {
                        provinsiSelect.onchange = null;
                      }
                    });
                    <?php endif; ?>
                  </script>
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
                </script>
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