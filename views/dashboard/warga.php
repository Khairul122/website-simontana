<?php include('template/header.php'); ?>


<div class="flex h-screen overflow-hidden bg-slate-50">
  
  <?php include 'template/sidebar.php'; ?>
  
  <div class="flex-1 flex flex-col overflow-hidden">
    <?php include 'template/navbar.php'; ?>
    
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 relative">
      <div class="p-4 md:p-6 lg:p-8 w-full">

        
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-brand-700 to-brand-900 text-white shadow-float p-8 mb-8">
          <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
          <div class="absolute -right-16 -top-16 w-64 h-64 bg-white/10 rounded-full blur-2xl"></div>
          <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
              <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 border border-white/20 text-xs font-bold tracking-widest uppercase mb-4 backdrop-blur-sm">
                <i class="fa-solid fa-shield-cat mt-0.5"></i> Info Publik Bencana
              </span>
              <h1 class="font-display text-3xl md:text-4xl font-bold mb-3 tracking-tight">Tetap Waspada & Aman!</h1>
              <p class="text-brand-100 max-w-xl text-sm leading-relaxed">
                Pantau peringatan dini dari BMKG, ketahui status wilayah Anda, dan laporkan kejadian darurat di sekitar Anda dengan cepat agar petugas dapat segera merespons.
              </p>
            </div>
            <div class="shrink-0 flex flex-col gap-3">
              <a href="index.php?controller=LaporanAdmin&action=create" class="flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-white text-brand-800 font-bold hover:bg-slate-50 hover:scale-105 transition-all shadow-lg active:scale-95">
                <i class="fa-solid fa-truck-medical text-lg"></i> Lapor Darurat!
              </a>
            </div>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
          
          <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-card hover:shadow-lg transition-shadow">
            <div class="flex items-center gap-4 mb-4">
              <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-list-ul"></i>
              </div>
              <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Jenis Kategori Bencana</p>
                <h3 class="font-display text-3xl font-bold text-slate-800">
                  <?= isset($dashboardData['categories']['data']) && is_array($dashboardData['categories']['data']) ? count($dashboardData['categories']['data']) : 0 ?>
                </h3>
              </div>
            </div>
            <p class="text-xs text-slate-500">Tersedia untuk dilaporkan oleh masyarakat.</p>
          </div>

          
          <div class="md:col-span-2 rounded-2xl border border-brand-200 bg-brand-50 p-6 shadow-card relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-32 h-32 bg-brand-100 rounded-bl-[100px] -z-0 transition-transform group-hover:scale-110"></div>
            
            <div class="relative z-10">
              <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-2 text-brand-800">
                  <i class="fa-solid fa-satellite-dish"></i>
                  <h3 class="font-bold">Info Gempa Terkini (BMKG)</h3>
                </div>
                <span class="flex h-2.5 w-2.5">
                  <span class="animate-ping absolute inline-flex h-2.5 w-2.5 rounded-full bg-brand-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-brand-500"></span>
                </span>
              </div>

              <?php if (isset($dashboardData['bmkgData']['success']) && $dashboardData['bmkgData']['success']): ?>
                <?php $gempa = $dashboardData['bmkgData']['data'] ?? null; ?>
                <?php if ($gempa && isset($gempa['Magnitude'])): ?>
                  <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
                    <div>
                      <p class="text-[10px] font-bold text-brand-500 uppercase tracking-wider mb-1">Magnitude</p>
                      <p class="font-display text-2xl font-bold text-brand-700"><?= htmlspecialchars($gempa['Magnitude'] ?? '-') ?> <span class="text-xs font-normal">SR</span></p>
                    </div>
                    <div>
                      <p class="text-[10px] font-bold text-brand-500 uppercase tracking-wider mb-1">Kedalaman</p>
                      <p class="font-bold text-slate-700 mt-1.5"><?= htmlspecialchars($gempa['Kedalaman'] ?? '-') ?></p>
                    </div>
                    <div class="col-span-2">
                      <p class="text-[10px] font-bold text-brand-500 uppercase tracking-wider mb-1">Pusat Gempa / Wilayah</p>
                      <p class="font-bold text-slate-700 leading-tight"><?= htmlspecialchars($gempa['Wilayah'] ?? '-') ?></p>
                      <p class="text-xs text-slate-500 mt-1"><i class="fa-regular fa-clock mr-1"></i><?= htmlspecialchars(($gempa['Tanggal'] ?? '-') . ' ' . ($gempa['Jam'] ?? '')) ?></p>
                    </div>
                  </div>
                <?php else: ?>
                  <div class="flex items-center justify-center p-4 bg-white/50 rounded-xl mt-4">
                    <p class="text-sm font-semibold text-brand-600">Info teknis gempa tidak dapat dimuat saat ini.</p>
                  </div>
                <?php endif; ?>
              <?php else: ?>
                <div class="flex items-center justify-center p-4 bg-white/50 rounded-xl mt-4">
                  <p class="text-sm font-semibold text-brand-600">Tidak ada koneksi ke server BMKG.</p>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>

        
        <div class="rounded-2xl border border-slate-200 bg-white shadow-card overflow-hidden">
          <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div>
              <h2 class="font-bold text-slate-800 text-lg flex items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left text-slate-400"></i> Laporan Masuk Terbaru
              </h2>
              <p class="text-xs text-slate-500 mt-1">Daftar laporan masyarakat yang sedang diproses oleh sistem.</p>
            </div>
          </div>

          <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
              <thead>
                <tr class="bg-slate-50/50 text-xs font-bold text-slate-500 uppercase tracking-wider">
                  <th class="px-6 py-4 border-b border-slate-200 w-16">ID</th>
                  <th class="px-6 py-4 border-b border-slate-200">Judul Darurat</th>
                  <th class="px-6 py-4 border-b border-slate-200">Status Tindakan</th>
                  <th class="px-6 py-4 border-b border-slate-200 text-right">Tanggal Dilaporkan</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100 text-sm">
                <?php
                  $reports = $dashboardData['latestReports']['data'] ?? [];
                  if (!is_array($reports)) $reports = [];
                ?>
                <?php if (!empty($reports)): ?>
                  <?php foreach ($reports as $report): ?>
                    <?php
                      $status = strtolower((string)($report['status'] ?? '-'));
                      $badgeTheme = 'bg-slate-100 text-slate-700 border-slate-200';
                      $icon = 'fa-circle-question';
                      if ($status === 'menunggu verifikasi') {
                          $badgeTheme = 'bg-red-50 text-red-700 border-red-200';
                          $icon = 'fa-clock';
                      } elseif ($status === 'diproses' || $status === 'ditangani') {
                          $badgeTheme = 'bg-amber-50 text-amber-700 border-amber-200';
                          $icon = 'fa-person-digging';
                      } elseif ($status === 'selesai') {
                          $badgeTheme = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                          $icon = 'fa-check';
                      }
                    ?>
                    <tr class="hover:bg-slate-50/70 transition-colors">
                      <td class="px-6 py-4 font-bold text-slate-400">#<?= htmlspecialchars((string)($report['id'] ?? '-')) ?></td>
                      <td class="px-6 py-4 font-semibold text-slate-800"><?= htmlspecialchars($report['judul_laporan'] ?? $report['judul'] ?? '-') ?></td>
                      <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg border text-xs font-bold <?= $badgeTheme ?>">
                          <i class="fa-solid <?= $icon ?> scale-90"></i> <?= htmlspecialchars($report['status'] ?? '-') ?>
                        </span>
                      </td>
                      <td class="px-6 py-4 text-right font-medium text-slate-500">
                        <?= htmlspecialchars(date('d M Y, H:i', strtotime($report['waktu_laporan'] ?? $report['created_at'] ?? 'now'))) ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="4" class="px-6 py-12 text-center">
                      <div class="inline-flex h-12 w-12 rounded-full bg-slate-100 text-slate-400 items-center justify-center mb-3 text-xl"><i class="fa-regular fa-folder-open"></i></div>
                      <p class="font-semibold text-slate-500 mb-1">Belum ada laporan dari warga sekitar.</p>
                      <p class="text-xs text-slate-400">Jadilah yang pertama melapor jika melihat kondisi darurat.</p>
                    </td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </main>
  </div>
</div>

<?php include 'template/script.php'; ?>
