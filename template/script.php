<?php if (isset($_SESSION['dialog'])): ?>
<script>
  (function() {
    const title = "<?php echo addslashes($_SESSION['dialog']['title'] ?? 'Informasi'); ?>";
    const message = "<?php echo addslashes($_SESSION['dialog']['message'] ?? ''); ?>";
    const type = "<?php echo addslashes($_SESSION['dialog']['type'] ?? 'info'); ?>";
    if (typeof Swal !== 'undefined') {
      Swal.fire({
        icon: type,
        title: title || 'Informasi',
        text: message || '',
        confirmButtonText: 'OKE',
        confirmButtonColor: '#b91c1c',
        customClass: {
          popup: 'rounded-2xl',
          confirmButton: 'rounded-lg px-6 py-2.5 font-bold shadow-sm'
        }
      });
    } else {
      alert(message);
    }
  })();
</script>
<?php unset($_SESSION['dialog']); endif; ?>

<?php if (isset($_SESSION['toast'])): ?>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const type = "<?php echo addslashes($_SESSION['toast']['type'] ?? 'success'); ?>";
    const title = "<?php echo addslashes($_SESSION['toast']['title'] ?? ''); ?>";
    const message = "<?php echo addslashes($_SESSION['toast']['message'] ?? ''); ?>";
    
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
      customClass: {
        popup: 'rounded-xl shadow-lg border border-slate-100 mt-16 mr-4'
      },
      didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
      }
    });

    Toast.fire({
      icon: type,
      title: title || message
    });
  });
</script>
<?php unset($_SESSION['toast']); endif; ?>

<!-- Close body and html tags from header -->
</body>
</html>
