document.addEventListener('DOMContentLoaded', function () {

  // =======================
  // 👁️ Toggle Password View
  // =======================
  const toggleSpans = document.querySelectorAll('.toggle-password');
  toggleSpans.forEach(span => {
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
  // ✨ Modal Sukses (Animasi Masuk + Otomatis Hilang)
  // =======================
  const modalEl = document.getElementById('successModal');
  if (modalEl) {
    const modalContent = modalEl.querySelector('.modal-content');
    const bsModal = new bootstrap.Modal(modalEl);

    modalContent.style.transform = 'scale(0.8)';
    modalContent.style.opacity = '0';
    bsModal.show();

    requestAnimationFrame(() => {
      modalContent.style.transform = 'scale(1)';
      modalContent.style.opacity = '1';
      modalContent.style.transition = 'all 0.3s ease';
    });

    setTimeout(() => {
      modalContent.style.transform = 'scale(0.8)';
      modalContent.style.opacity = '0';
      setTimeout(() => bsModal.hide(), 300);
    }, 3000);
  }

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
  // ✅ Notifikasi Setelah Tambah / Edit / Update
  // (gunakan session()->has('success') di Blade)
  // =======================
  if (typeof Laravel !== 'undefined' && Laravel.session) {
    if (Laravel.session.success) {
      Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: Laravel.session.success,
        timer: 1500,
        showConfirmButton: false
      });
    }

    if (Laravel.session.error) {
      Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: Laravel.session.error,
      });
    }
  }

  // =======================
  // 🚫 Tampilkan Modal Ganti Password jika Ada Error Validasi
  // =======================
  const errorPasswordModal = document.querySelector('.password-error-modal');
  if (errorPasswordModal) {
    const bsModal = new bootstrap.Modal(errorPasswordModal);
    bsModal.show();
    Swal.fire({
      icon: 'error',
      title: 'Kesalahan!',
      text: 'Periksa kembali input password Anda.',
    });
  }

});
