document.addEventListener('DOMContentLoaded', function () {

  // =======================
  // 👁️ Toggle Password View
  // =======================
  document.querySelectorAll('.toggle-password').forEach(span => {
    span.addEventListener('click', function () {
      const input = this.previousElementSibling;
      if (!input) return;

      if (input.type === "password") {
        input.type = "text";
        this.textContent = "👀";
        setTimeout(() => {
          input.type = "password";
          this.textContent = "🙈";
        }, 1000);
      }
    });
  });

  // =======================
  // 🔄 Pagination (Next & Prev)
  // =======================
  const prevBtn = document.getElementById('prevBtn');
  const nextBtn = document.getElementById('nextBtn');

  prevBtn?.addEventListener('click', () => {
      const prevUrl = prevBtn.dataset.url;
      if (prevUrl) window.location.href = prevUrl;
  });

  nextBtn?.addEventListener('click', () => {
      const nextUrl = nextBtn.dataset.url;
      if (nextUrl) window.location.href = nextUrl;
  });

  // =======================
  // ⚠️ Konfirmasi Hapus Admin
  // =======================
  document.querySelectorAll('.btn-hapus').forEach(btn => {
    btn.addEventListener('click', function (e) {
      e.preventDefault();
      const form = this.closest('form');

      Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: "Data admin ini akan hilang permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          form.submit();
        }
      });
    });
  });

  // =======================
  // ✅ Notifikasi Berhasil / Gagal
  // =======================
  if (window.LaravelSessionSuccess) {
    Swal.fire({
      icon: 'success',
      title: 'Berhasil!',
      text: window.LaravelSessionSuccess,
      timer: 1500,
      showConfirmButton: false
    });
  }

  if (window.LaravelSessionError) {
    Swal.fire({
      icon: 'error',
      title: 'Gagal!',
      text: window.LaravelSessionError,
    });
  }

  // =======================
  // 🚫 Modal Password jika ada error validasi
  // =======================
  if (Array.isArray(window.LaravelPasswordErrors)) {
    window.LaravelPasswordErrors.forEach(adminId => {
      const modalEl = document.getElementById(`passwordAdminModal${adminId}`);
      if (modalEl) {
        const bsModal = new bootstrap.Modal(modalEl);
        bsModal.show();
        Swal.fire({
          icon: 'error',
          title: 'Kesalahan!',
          text: 'Periksa kembali input password Anda.',
        });
      }
    });
  }

});
