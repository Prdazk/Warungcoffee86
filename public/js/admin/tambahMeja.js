// File: public/js/tambahMejaAlert.js
document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('formTambahMeja');
  if (!form) return;

  form.addEventListener('submit', function (e) {
    e.preventDefault(); // cegah submit langsung

    const nama = form.querySelector('input[name="nama_meja"]').value.trim();

    // Validasi manual
    if (!nama) {
      Swal.fire({
        icon: 'warning',
        title: 'Oops...',
        text: 'Nama meja wajib diisi 💬',
        background: 'rgba(255,255,255,0.95)',
        backdrop: 'rgba(0,0,0,0.4) blur(4px)',
        confirmButtonColor: '#6F4E37',
      });
      return;
    }

    // Konfirmasi simpan
    Swal.fire({
      title: 'Simpan Meja Baru?',
      text: 'Pastikan data sudah benar ya 🍽️',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#4CAF50',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Simpan',
      cancelButtonText: 'Batal',
      background: 'rgba(255,255,255,0.95)',
      backdrop: 'rgba(0,0,0,0.45) blur(5px)',
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          icon: 'success',
          title: 'Berhasil!',
          text: 'Meja baru berhasil ditambahkan 🪑✨',
          background: 'rgba(255,255,255,0.95)',
          backdrop: 'rgba(0,0,0,0.5) blur(6px)',
          showConfirmButton: false,
          timer: 1500,
          timerProgressBar: true,
        });

        // Delay biar alert tampil dulu baru submit
        setTimeout(() => {
          form.submit();
        }, 1500);
      }
    });
  });
});
