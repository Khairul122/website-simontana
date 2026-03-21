<?php
include('template/header.php');

$users = isset($users) && is_array($users) ? $users : [];
$fetchError = isset($fetchError) && is_array($fetchError) ? $fetchError : null;

$adminCount = 0;
$petugasCount = 0;
$operatorCount = 0;
$wargaCount = 0;
foreach ($users as $u) {
  $r = strtolower((string)($u['role'] ?? ''));
  if ($r === 'admin') $adminCount++;
  if ($r === 'petugasbpbd') $petugasCount++;
  if ($r === 'operatordesa') $operatorCount++;
  if ($r === 'warga') $wargaCount++;
}
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
            <h1 class="font-display text-2xl md:text-3xl font-bold text-slate-900">User Account & Role</h1>
            <p class="text-sm text-slate-500 mt-1">Registrasi dan validasi hak akses untuk stakeholder, operator, dan warga.</p>
          </div>
          <div class="shrink-0 flex gap-3">
            <a href="index.php?controller=User&action=create" class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-brand-600 text-white font-bold text-sm hover:bg-brand-700 hover:shadow-float transition-all shadow-sm">
              <i class="fa-solid fa-user-plus"></i> Tambah Pengguna Terdaftar
            </a>
          </div>
        </div>

        <?php if ($fetchError): ?>
          <div class="rounded-xl bg-red-50 border border-red-200 p-4 mb-6">
            <div class="flex items-start gap-4">
              <div class="flex-shrink-0 text-red-500 mt-0.5"><i class="fa-solid fa-triangle-exclamation text-xl"></i></div>
              <div class="flex-1">
                <h3 class="text-sm font-bold text-red-800">Gangguan Sistem</h3>
                <p class="text-sm text-red-600 mt-1"><?php echo htmlspecialchars($fetchError['message'] ?? 'Data gagal didapatkan.'); ?></p>
                <?php if (!empty($fetchError['details']) && is_array($fetchError['details'])): ?>
                  <ul class="list-disc pl-5 mt-2 text-xs text-red-500 font-mono">
                    <?php foreach ($fetchError['details'] as $error): ?>
                      <li><?php echo htmlspecialchars(is_array($error) ? json_encode($error) : $error); ?></li>
                    <?php endforeach; ?>
                  </ul>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endif; ?>

        <!-- KPI Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
          <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm border-l-4 border-l-rose-500 flex items-end justify-between">
            <div>
              <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Administrator (IT)</p>
              <h3 class="font-display text-2xl font-bold text-slate-800 leading-none"><?php echo $adminCount; ?></h3>
            </div>
            <i class="fa-solid fa-user-gear text-slate-200 text-3xl mb-1"></i>
          </div>
          <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm border-l-4 border-l-amber-500 flex items-end justify-between">
            <div>
              <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Tim Assessment BPBD</p>
              <h3 class="font-display text-2xl font-bold text-slate-800 leading-none"><?php echo $petugasCount; ?></h3>
            </div>
             <i class="fa-solid fa-helmet-safety text-slate-200 text-3xl mb-1"></i>
          </div>
          <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm border-l-4 border-l-indigo-500 flex items-end justify-between">
            <div>
              <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Operator Verifikator Desa</p>
              <h3 class="font-display text-2xl font-bold text-slate-800 leading-none"><?php echo $operatorCount; ?></h3>
            </div>
            <i class="fa-solid fa-house-laptop text-slate-200 text-3xl mb-1"></i>
          </div>
          <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm flex items-end justify-between">
            <div>
              <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">User Pelapor / Warga Umum</p>
              <h3 class="font-display text-2xl font-bold text-slate-800 leading-none"><?php echo $wargaCount; ?></h3>
            </div>
            <i class="fa-solid fa-users text-slate-200 text-3xl mb-1"></i>
          </div>
        </div>

        <!-- Data Table -->
        <div class="rounded-2xl border border-slate-200 bg-white shadow-card overflow-hidden">
          <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <h2 class="font-bold text-slate-800 text-base"><i class="fa-solid fa-address-book text-slate-400 mr-2"></i> Direktori Kontak & Akses (<?php echo count($users); ?>)</h2>
          </div>

          <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
              <thead>
                <tr class="bg-slate-50/80 border-b border-slate-200 text-[11px] font-bold text-slate-500 uppercase tracking-widest whitespace-nowrap">
                  <th class="px-5 py-4 w-12 text-center">ID</th>
                  <th class="px-5 py-4 min-w-[200px]">Profile User</th>
                  <th class="px-5 py-4">Auth Login (Username)</th>
                  <th class="px-5 py-4 w-40 text-center">Security Level</th>
                  <th class="px-5 py-4">Kontak (Email / Telp)</th>
                  <th class="px-5 py-4 text-center w-36">Aksi Privilese</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100 text-sm">
                <?php if (!empty($users)): ?>
                  <?php $no = 1; foreach ($users as $user): ?>
                    <tr class="hover:bg-slate-50/70 transition-colors group">
                      <td class="px-5 py-4 text-center font-bold text-slate-400"><?php echo $no++; ?></td>
                      <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                          <div class="w-10 h-10 rounded-full bg-slate-200 border-2 border-white shadow-sm flex items-center justify-center font-bold text-slate-500 text-sm">
                            <?php echo strtoupper(substr($user['nama'] ?? '?', 0, 1)); ?>
                          </div>
                          <div>
                            <p class="font-bold text-slate-800 mb-0.5"><?php echo htmlspecialchars($user['nama'] ?? '-'); ?></p>
                          </div>
                        </div>
                      </td>
                      <td class="px-5 py-4 font-mono text-slate-600 text-xs font-semibold">
                        @<?php echo htmlspecialchars($user['username'] ?? '-'); ?>
                      </td>
                      <td class="px-5 py-4 text-center">
                        <?php 
                        $role = $user['role'] ?? '-';
                        $badgeClass = 'bg-slate-100 text-slate-600 border-slate-200';
                        $iconRole = 'fa-user';
                        
                        switch(strtolower($role)) {
                          case 'admin':
                            $badgeClass = 'bg-rose-50 text-rose-700 border-rose-200';
                            $role = 'Admin System';
                            $iconRole = 'fa-user-astronaut';
                            break;
                          case 'petugasbpbd':
                            $badgeClass = 'bg-amber-50 text-amber-700 border-amber-200';
                            $role = 'Field BPBD';
                            $iconRole = 'fa-street-view';
                            break;
                          case 'operatordesa':
                            $badgeClass = 'bg-indigo-50 text-indigo-700 border-indigo-200';
                            $role = 'Op. Desa';
                            $iconRole = 'fa-user-tie';
                            break;
                          case 'warga':
                            $badgeClass = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                            $role = 'Warga Biasa';
                            $iconRole = 'fa-user-large';
                            break;
                        }
                        ?>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md border text-[10px] font-bold tracking-widest uppercase <?php echo $badgeClass; ?>">
                          <i class="fa-solid <?php echo $iconRole; ?>"></i> <?php echo htmlspecialchars($role); ?>
                        </span>
                      </td>
                      <td class="px-5 py-4">
                        <div class="text-[11px] font-semibold text-slate-600 mb-1 flex justify-start items-center relative pl-5"><i class="fa-regular fa-envelope absolute left-0 text-slate-400"></i> <?php echo htmlspecialchars($user['email'] ?? '-'); ?></div>
                        <div class="text-[11px] font-semibold text-slate-600 flex justify-start items-center relative pl-5"><i class="fa-solid fa-phone absolute left-0 text-slate-400"></i> <?php echo htmlspecialchars($user['no_telepon'] ?? '-'); ?></div>
                      </td>
                      <td class="px-5 py-4 text-center">
                        <div class="flex items-center justify-center gap-1.5">
                          <a href="index.php?controller=User&action=edit&id=<?php echo $user['id']; ?>" class="inline-flex items-center justify-center h-8 w-8 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 hover:text-amber-700 transition" title="Edit Akun">
                            <i class="fa-solid fa-pen text-sm"></i>
                          </a>
                          <button
                            type="button"
                            class="inline-flex items-center justify-center h-8 w-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 transition btn-delete"
                            data-id="<?php echo $user['id']; ?>"
                            data-name="<?php echo htmlspecialchars($user['nama'] ?? 'N/A'); ?>"
                            title="Cabut Akses / Hapus"
                          >
                            <i class="fa-solid fa-user-xmark text-sm"></i>
                          </button>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="6" class="px-5 py-16 text-center">
                      <div class="inline-flex h-16 w-16 rounded-full bg-slate-50 border border-slate-100 text-slate-300 items-center justify-center mb-4 text-3xl shadow-inner"><i class="fa-solid fa-users-slash"></i></div>
                      <h3 class="font-display font-bold text-slate-700 text-lg mb-1">Sistem Kosong</h3>
                      <p class="text-sm font-medium text-slate-500">Tidak ada user terdaftar selain Anda.</p>
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
  document.addEventListener('DOMContentLoaded', function() {
    
    // Delegation for delete buttons
    document.addEventListener('click', function(event) {
      const button = event.target.closest('.btn-delete');
      if (!button) return;

      const id = button.getAttribute('data-id');
      const name = button.getAttribute('data-name');
      
      if (typeof Swal !== 'undefined') {
        Swal.fire({
          title: 'Cabut Hak Akses Sistem?',
          text: `Akun "${name}" beserta history log dan tracking datanya akan terpengaruh jika Anda memaksa menghapus user tersebut.`,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#ef4444',
          cancelButtonColor: '#e2e8f0',
          confirmButtonText: 'Berbahaya, Tetap Hapus',
          cancelButtonText: 'Batalkan',
          customClass: {
            popup: 'rounded-2xl',
            confirmButton: 'rounded-xl px-5 py-2.5 font-bold shadow-sm',
            cancelButton: 'rounded-xl px-5 py-2.5 font-bold text-slate-700 bg-white border border-slate-200 hover:bg-slate-50'
          }
        }).then((result) => {
          if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `index.php?controller=User&action=delete&id=${id}`;
            document.body.appendChild(form);
            form.submit();
          }
        });
      } else {
        if (window.confirm(`Apakah Anda yakin ingin menghapus pengguna "${name}"?`)) {
          const form = document.createElement('form');
          form.method = 'POST';
          form.action = `index.php?controller=User&action=delete&id=${id}`;
          document.body.appendChild(form);
          form.submit();
        }
      }
    });

    // Handle toast params
    const urlParams = new URLSearchParams(window.location.search);
    if(urlParams.has('success') && typeof Swal !== 'undefined') {
        Swal.fire({
          icon: 'success',
          title: 'Operation OK',
          text: urlParams.get('success'),
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true
        });
    }
    if(urlParams.has('error') && typeof Swal !== 'undefined') {
        Swal.fire({
          icon: 'error',
          title: 'Operation Failed',
          text: urlParams.get('error'),
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 5000,
          timerProgressBar: true
        });
    }
  });
</script>
