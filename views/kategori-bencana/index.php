<?php
include('template/header.php');

$kategoriRows = isset($kategoriRows) && is_array($kategoriRows) ? $kategoriRows : [];
$fetchError = isset($fetchError) ? $fetchError : null;

$withIcon = 0;
foreach ($kategoriRows as $row) {
  if (!empty($row['icon'])) $withIcon++;
}
$withoutIcon = max(0, count($kategoriRows) - $withIcon);
?>

<div class="flex h-screen overflow-hidden bg-slate-50">
  <?php include 'template/sidebar.php'; ?>
  
  <div class="flex-1 flex flex-col overflow-hidden">
    <?php include 'template/navbar.php'; ?>
    
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 relative">
      <div class="p-4 md:p-6 lg:p-8 w-full">

        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
          <div>
            <h1 class="font-display text-2xl md:text-3xl font-bold text-slate-900">Kategori Bencana</h1>
            <p class="text-sm text-slate-500 mt-1">Klasifikasi tipe laporan dan mapping ikon untuk dashboard visual.</p>
          </div>
          <div class="shrink-0 flex gap-3">
            <a href="index.php?controller=KategoriBencana&action=create" class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-brand-600 text-white font-bold text-sm hover:bg-brand-700 hover:shadow-float transition-all shadow-sm">
              <i class="fa-solid fa-plus"></i> Kategori Baru
            </a>
          </div>
        </div>

        <?php if (!empty($fetchError)): ?>
          <div class="rounded-xl bg-red-50 border border-red-200 p-4 mb-6 flex items-start gap-4">
            <div class="flex-shrink-0 text-red-500 mt-0.5"><i class="fa-solid fa-triangle-exclamation text-xl"></i></div>
            <div class="flex-1">
              <h3 class="text-sm font-bold text-red-800">Gagal Memuat Kategori</h3>
              <p class="text-sm text-red-600 mt-1"><?php echo htmlspecialchars((string)$fetchError); ?></p>
            </div>
          </div>
        <?php endif; ?>

        <!-- KPI Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 mb-6">
          <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm flex items-center gap-4 border-l-4 border-l-slate-400">
            <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center text-xl shrink-0"><i class="fa-solid fa-layer-group"></i></div>
            <div>
              <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Total Kategori</p>
              <h3 class="font-display text-2xl font-bold text-slate-800 leading-none"><?php echo count($kategoriRows); ?></h3>
            </div>
          </div>
          <div class="rounded-2xl border border-indigo-200 bg-indigo-50/50 p-5 shadow-sm flex items-center gap-4 border-l-4 border-l-indigo-500">
            <div class="w-12 h-12 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center text-xl shrink-0"><i class="fa-solid fa-icons"></i></div>
            <div>
              <p class="text-[11px] font-bold text-indigo-600 uppercase tracking-widest mb-0.5">Ber-Ikon Fa-Solid</p>
              <h3 class="font-display text-2xl font-bold text-indigo-700 leading-none"><?php echo $withIcon; ?></h3>
            </div>
          </div>
          <div class="rounded-2xl border border-rose-200 bg-rose-50/50 p-5 shadow-sm flex items-center gap-4 border-l-4 border-l-rose-500">
            <div class="w-12 h-12 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center text-xl shrink-0"><i class="fa-solid fa-shapes"></i></div>
            <div>
              <p class="text-[11px] font-bold text-rose-600 uppercase tracking-widest mb-0.5">Tanpa Ikon</p>
              <h3 class="font-display text-2xl font-bold text-rose-700 leading-none"><?php echo $withoutIcon; ?></h3>
            </div>
          </div>
        </div>

        <!-- Data Table -->
        <div class="rounded-2xl border border-slate-200 bg-white shadow-card overflow-hidden">
          <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
              <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-[11px] font-bold text-slate-500 uppercase tracking-widest">
                  <th class="px-5 py-4 w-16 text-center">No</th>
                  <th class="px-5 py-4">Nama Bencana</th>
                  <th class="px-5 py-4 min-w-[250px]">Deskripsi Singkat</th>
                  <th class="px-5 py-4 text-center">Preview Ikon</th>
                  <th class="px-5 py-4 text-center w-32">Aksi</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100 text-sm">
                <?php if (!empty($kategoriRows)): ?>
                  <?php $no = 1; foreach ($kategoriRows as $kategori): ?>
                    <tr class="hover:bg-slate-50/70 transition-colors group">
                      <td class="px-5 py-4 text-center font-bold text-slate-400"><?php echo $no++; ?></td>
                      <td class="px-5 py-4 font-bold text-slate-800">
                        <?php echo htmlspecialchars($kategori['nama_kategori'] ?? $kategori['nama'] ?? '-'); ?>
                      </td>
                      <td class="px-5 py-4 text-slate-500 font-medium line-clamp-2">
                        <?php echo htmlspecialchars($kategori['deskripsi'] ?? '-'); ?>
                      </td>
                      <td class="px-5 py-4 text-center">
                        <?php if (!empty($kategori['icon'])): ?>
                          <div class="inline-flex flex-col items-center justify-center gap-1.5 p-2 rounded-lg bg-indigo-50 border border-indigo-100 text-indigo-600 min-w-[48px]">
                            <i class="fa-solid fa-<?php echo htmlspecialchars(str_replace('fa-', '', $kategori['icon'])); ?> text-lg"></i>
                          </div>
                        <?php else: ?>
                          <span class="inline-flex items-center px-2 py-1 rounded-md bg-slate-100 text-slate-400 text-[10px] font-bold uppercase tracking-wider">N/A</span>
                        <?php endif; ?>
                      </td>
                      <td class="px-5 py-4 text-center">
                        <div class="flex items-center justify-center gap-1.5">
                          <a href="index.php?controller=KategoriBencana&action=edit&id=<?php echo (int)$kategori['id']; ?>" class="inline-flex items-center justify-center h-8 w-8 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 hover:text-amber-700 transition" title="Edit">
                            <i class="fa-solid fa-pen text-sm"></i>
                          </a>
                          <button
                            type="button"
                            class="inline-flex items-center justify-center h-8 w-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 transition btn-delete"
                            data-id="<?php echo (int)$kategori['id']; ?>"
                            data-name="<?php echo htmlspecialchars($kategori['nama_kategori'] ?? $kategori['nama'] ?? 'N/A'); ?>"
                            title="Hapus"
                          >
                            <i class="fa-solid fa-trash-can text-sm"></i>
                          </button>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="5" class="px-5 py-16 text-center">
                      <div class="inline-flex h-16 w-16 rounded-full bg-slate-50 border border-slate-100 text-slate-300 items-center justify-center mb-4 text-3xl shadow-inner"><i class="fa-solid fa-layer-group"></i></div>
                      <h3 class="font-display font-bold text-slate-700 text-lg mb-1">Kategori Kosong</h3>
                      <p class="text-sm font-medium text-slate-500">Sistem belum memiliki referensi tipe bencana.</p>
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
<script>
  document.addEventListener('click', function (event) {
    const button = event.target.closest('.btn-delete');
    if (!button) return;

    const id = button.getAttribute('data-id');
    const name = button.getAttribute('data-name') || 'Kategori';

    if (typeof Swal !== 'undefined') {
      Swal.fire({
        icon: 'warning',
        title: 'Hapus Referensi?',
        text: `Master data "${name}" akan dihapus. Ini bisa mempengaruhi grafik dashboard bila masih ada laporan terkait.`,
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus Saja',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#ef4444',
        customClass: {
          popup: 'rounded-2xl',
          confirmButton: 'rounded-xl px-5 py-2.5 font-bold shadow-sm',
          cancelButton: 'rounded-xl px-5 py-2.5 font-bold border border-slate-200 bg-white text-slate-700 hover:bg-slate-50'
        }
      }).then(function (result) {
        if (result.isConfirmed) {
          const form = document.createElement('form');
          form.method = 'POST';
          form.action = 'index.php?controller=KategoriBencana&action=delete&id=' + encodeURIComponent(id);
          document.body.appendChild(form);
          form.submit();
        }
      });
    } else {
      if (window.confirm('Hapus kategori "' + name + '"?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'index.php?controller=KategoriBencana&action=delete&id=' + encodeURIComponent(id);
        document.body.appendChild(form);
        form.submit();
      }
    }
  });
</script>
