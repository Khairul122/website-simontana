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
            <div class="col-12">
              <div class="page-header">
                <h3 class="page-title">Edit Laporan Bencana</h3>
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="index.php?controller=LaporanAdmin&action=index">Laporan Bencana</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Laporan</li>
                  </ol>
                </nav>
              </div>

              <div class="row">
                <div class="col-lg-10 mx-auto">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                          <h4 class="card-title mb-0">Edit Data Laporan Bencana</h4>
                          <p class="card-description mb-0">Perbarui informasi laporan bencana</p>
                        </div>
                      </div>

                      <form action="index.php?controller=LaporanAdmin&action=update&id=<?php echo $laporan['id']; ?>" method="POST" enctype="multipart/form-data" class="forms-sample">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group row">
                              <label for="judul_laporan" class="col-sm-4 col-form-label">Judul Laporan</label>
                              <div class="col-sm-8">
                                <input type="text" class="form-control" id="judul_laporan" name="judul_laporan" value="<?php echo htmlspecialchars($laporan['judul_laporan'] ?? $laporan['judul'] ?? ''); ?>" required>
                              </div>
                            </div>

                            <div class="form-group row">
                              <label for="id_provinsi" class="col-sm-4 col-form-label">Provinsi</label>
                              <div class="col-sm-8">
                                <select class="form-control" id="id_provinsi" name="id_provinsi" required onchange="loadKabupatenByProvinsi()">
                                  <option value="">-- Pilih Provinsi --</option>
                                  <?php foreach ($provinsiList as $provinsi): ?>
                                    <option value="<?php echo $provinsi['id']; ?>"
                                      <?php echo ((isset($laporan['desa']['id_provinsi']) && $laporan['desa']['id_provinsi'] == $provinsi['id']) ? 'selected' :
                                                 ((isset($laporan['desa']['id_parent']) && $laporan['desa']['id_parent'] == $provinsi['id']) ? 'selected' :
                                                 ((isset($_GET['provinsi_id']) && $_GET['provinsi_id'] == $provinsi['id']) ? 'selected' : ''))); ?>>
                                      <?php echo htmlspecialchars($provinsi['nama'] ?? $provinsi['name'] ?? ''); ?>
                                    </option>
                                  <?php endforeach; ?>
                                </select>
                              </div>
                            </div>

                            <div class="form-group row">
                              <label for="id_kabupaten" class="col-sm-4 col-form-label">Kabupaten</label>
                              <div class="col-sm-8">
                                <select class="form-control" id="id_kabupaten" name="id_kabupaten" required onchange="loadKecamatanByKabupaten()">
                                  <option value="">-- Pilih Kabupaten --</option>
                                  <?php foreach ($kabupatenList as $kabupaten): ?>
                                    <option value="<?php echo $kabupaten['id']; ?>"
                                      <?php echo ((isset($laporan['desa']['id_kabupaten']) && $laporan['desa']['id_kabupaten'] == $kabupaten['id']) ? 'selected' :
                                                 ((isset($laporan['desa']['id_parent']) && $laporan['desa']['id_parent'] == $kabupaten['id']) ? 'selected' :
                                                 ((isset($_GET['kabupaten_id']) && $_GET['kabupaten_id'] == $kabupaten['id']) ? 'selected' : ''))); ?>>
                                      <?php echo htmlspecialchars($kabupaten['nama'] ?? $kabupaten['name'] ?? ''); ?>
                                    </option>
                                  <?php endforeach; ?>
                                </select>
                              </div>
                            </div>

                            <div class="form-group row">
                              <label for="id_kecamatan" class="col-sm-4 col-form-label">Kecamatan</label>
                              <div class="col-sm-8">
                                <select class="form-control" id="id_kecamatan" name="id_kecamatan" required>
                                  <option value="">-- Pilih Kecamatan --</option>
                                  <?php foreach ($kecamatanList as $kecamatan): ?>
                                    <option value="<?php echo $kecamatan['id']; ?>"
                                      <?php echo ((isset($laporan['id_kecamatan']) && $laporan['id_kecamatan'] == $kecamatan['id']) ? 'selected' :
                                                 ((isset($laporan['id_parent']) && $laporan['id_parent'] == $kecamatan['id']) ? 'selected' :
                                                 ((isset($_GET['kecamatan_id']) && $_GET['kecamatan_id'] == $kecamatan['id']) ? 'selected' : ''))); ?>>
                                      <?php echo htmlspecialchars($kecamatan['nama'] ?? $kecamatan['name'] ?? ''); ?>
                                    </option>
                                  <?php endforeach; ?>
                                </select>
                              </div>
                            </div>

                            <div class="form-group row">
                              <label for="id_desa" class="col-sm-4 col-form-label">Desa</label>
                              <div class="col-sm-8">
                                <select class="form-control" id="id_desa" name="id_desa" required>
                                  <option value="">-- Pilih Desa --</option>
                                  <?php foreach ($desaList as $desa): ?>
                                    <option value="<?php echo $desa['id']; ?>"
                                      <?php echo ((isset($laporan['id_desa']) && $laporan['id_desa'] == $desa['id']) ? 'selected' :
                                                 ((isset($laporan['id_parent']) && $laporan['id_parent'] == $desa['id']) ? 'selected' :
                                                 ((isset($_GET['desa_id']) && $_GET['desa_id'] == $desa['id']) ? 'selected' : ''))); ?>>
                                      <?php echo htmlspecialchars($desa['nama'] ?? $desa['name'] ?? ''); ?>
                                    </option>
                                  <?php endforeach; ?>
                                </select>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="form-group row">
                              <label for="tingkat_keparahan" class="col-sm-4 col-form-label">Tingkat Keparahan</label>
                              <div class="col-sm-8">
                                <select class="form-control" id="tingkat_keparahan" name="tingkat_keparahan" required>
                                  <option value="">-- Pilih Tingkat Keparahan --</option>
                                  <option value="Rendah" <?php echo (isset($laporan['tingkat_keparahan']) && $laporan['tingkat_keparahan'] == 'Rendah') ? 'selected' : ''; ?>>Rendah</option>
                                  <option value="Sedang" <?php echo (isset($laporan['tingkat_keparahan']) && $laporan['tingkat_keparahan'] == 'Sedang') ? 'selected' : ''; ?>>Sedang</option>
                                  <option value="Tinggi" <?php echo (isset($laporan['tingkat_keparahan']) && $laporan['tingkat_keparahan'] == 'Tinggi') ? 'selected' : ''; ?>>Tinggi</option>
                                  <option value="Sangat Tinggi" <?php echo (isset($laporan['tingkat_keparahan']) && $laporan['tingkat_keparahan'] == 'Sangat Tinggi') ? 'selected' : ''; ?>>Sangat Tinggi</option>
                                </select>
                              </div>
                            </div>

                            <div class="form-group row">
                              <label for="jumlah_korban" class="col-sm-4 col-form-label">Jumlah Korban</label>
                              <div class="col-sm-8">
                                <input type="number" class="form-control" id="jumlah_korban" name="jumlah_korban" value="<?php echo $laporan['jumlah_korban'] ?? 0; ?>" min="0">
                              </div>
                            </div>

                            <div class="form-group row">
                              <label for="jumlah_rumah_rusak" class="col-sm-4 col-form-label">Jumlah Rumah Rusak</label>
                              <div class="col-sm-8">
                                <input type="number" class="form-control" id="jumlah_rumah_rusak" name="jumlah_rumah_rusak" value="<?php echo $laporan['jumlah_rumah_rusak'] ?? 0; ?>" min="0">
                              </div>
                            </div>

                            <div class="form-group row">
                              <label for="latitude" class="col-sm-4 col-form-label">Latitude</label>
                              <div class="col-sm-8">
                                <input type="text" class="form-control" id="latitude" name="latitude" value="<?php echo $laporan['latitude'] ?? ''; ?>">
                              </div>
                            </div>

                            <div class="form-group row">
                              <label for="longitude" class="col-sm-4 col-form-label">Longitude</label>
                              <div class="col-sm-8">
                                <input type="text" class="form-control" id="longitude" name="longitude" value="<?php echo $laporan['longitude'] ?? ''; ?>">
                              </div>
                            </div>

                            <div class="form-group row">
                              <label for="alamat_lengkap" class="col-sm-4 col-form-label">Alamat Lengkap</label>
                              <div class="col-sm-8">
                                <textarea class="form-control" id="alamat_lengkap" name="alamat_lengkap" rows="3"><?php echo htmlspecialchars($laporan['alamat_lengkap'] ?? ''); ?></textarea>
                              </div>
                            </div>

                            <div class="form-group row">
                              <label for="deskripsi" class="col-sm-4 col-form-label">Deskripsi</label>
                              <div class="col-sm-8">
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required><?php echo htmlspecialchars($laporan['deskripsi'] ?? ''); ?></textarea>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-12">
                            <h5 class="mt-4 mb-3">Bukti Dokumentasi</h5>
                            <div class="row">
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label>Foto Bukti 1</label>
                                  <?php if (!empty($laporan['foto_bukti_1'])): ?>
                                    <div class="mb-2">
                                      <img src="<?php echo htmlspecialchars($laporan['foto_bukti_1_url'] ?? $laporan['foto_bukti_1']); ?>" alt="Foto Bukti 1" class="img-fluid rounded shadow-sm" style="max-height: 200px;">
                                    </div>
                                  <?php endif; ?>
                                  <input type="file" class="form-control" name="foto_bukti_1">
                                  <small class="form-text text-muted">Pilih file baru jika ingin mengganti foto</small>
                                </div>
                              </div>

                              <div class="col-md-4">
                                <div class="form-group">
                                  <label>Foto Bukti 2</label>
                                  <?php if (!empty($laporan['foto_bukti_2'])): ?>
                                    <div class="mb-2">
                                      <img src="<?php echo htmlspecialchars($laporan['foto_bukti_2_url'] ?? $laporan['foto_bukti_2']); ?>" alt="Foto Bukti 2" class="img-fluid rounded shadow-sm" style="max-height: 200px;">
                                    </div>
                                  <?php endif; ?>
                                  <input type="file" class="form-control" name="foto_bukti_2">
                                  <small class="form-text text-muted">Pilih file baru jika ingin mengganti foto</small>
                                </div>
                              </div>

                              <div class="col-md-4">
                                <div class="form-group">
                                  <label>Foto Bukti 3</label>
                                  <?php if (!empty($laporan['foto_bukti_3'])): ?>
                                    <div class="mb-2">
                                      <img src="<?php echo htmlspecialchars($laporan['foto_bukti_3_url'] ?? $laporan['foto_bukti_3']); ?>" alt="Foto Bukti 3" class="img-fluid rounded shadow-sm" style="max-height: 200px;">
                                    </div>
                                  <?php endif; ?>
                                  <input type="file" class="form-control" name="foto_bukti_3">
                                  <small class="form-text text-muted">Pilih file baru jika ingin mengganti foto</small>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-12">
                                <div class="form-group">
                                  <label>Video Bukti</label>
                                  <?php if (!empty($laporan['video_bukti'])): ?>
                                    <div class="mb-2">
                                      <video width="100%" height="auto" controls style="max-height: 200px;">
                                        <source src="<?php echo htmlspecialchars($laporan['video_bukti_url'] ?? $laporan['video_bukti']); ?>" type="video/mp4">
                                        Browser Anda tidak mendukung elemen video.
                                      </video>
                                    </div>
                                  <?php endif; ?>
                                  <input type="file" class="form-control" name="video_bukti">
                                  <small class="form-text text-muted">Pilih file baru jika ingin mengganti video</small>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-end">
                          <a href="index.php?controller=LaporanAdmin&action=detail&id=<?php echo $laporan['id']; ?>" class="btn btn-light mr-2">Batal</a>
                          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                      </form>
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