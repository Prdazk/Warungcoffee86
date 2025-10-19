document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById('modalLihat');
  const modalContent = modal.querySelector('.modal-content');
  const modalClose = modal.querySelector('.modal-close');
  const modalNama = modal.querySelector('#modalNama');
  const modalJumlah = modal.querySelector('#modalJumlah');
  const modalMeja = modal.querySelector('#modalMeja');
  const modalTanggal = modal.querySelector('#modalTanggal');
  const modalJam = modal.querySelector('#modalJam');
  const modalCatatan = modal.querySelector('.catatan-box');

  // Tangkap semua tombol lihat
  const btnLihat = document.querySelectorAll('.btn-lihat');
  btnLihat.forEach(btn => {
    btn.addEventListener('click', () => {
      modalNama.textContent = btn.dataset.nama;
      modalJumlah.textContent = btn.dataset.jumlah;
      modalMeja.textContent = btn.dataset.meja;
      modalTanggal.textContent = btn.dataset.tanggal;
      modalJam.textContent = btn.dataset.jam;
      modalCatatan.textContent = btn.dataset.catatan || '-';

      modal.style.display = 'flex';
      setTimeout(() => {
        modalContent.style.transform = 'scale(1)';
        modalContent.style.opacity = '1';
      }, 50);
    });
  });

  // Jika klik teks “Pesan Baru”
  const catatanPesanBaru = document.querySelectorAll('.catatan-pesan-baru');
  catatanPesanBaru.forEach(span => {
    span.addEventListener('click', () => {
      // Ambil data dari row terkait
      const row = span.closest('tr');
      const nama = row.querySelector('.btn-lihat').dataset.nama;
      const jumlah = row.querySelector('.btn-lihat').dataset.jumlah;
      const meja = row.querySelector('.btn-lihat').dataset.meja;
      const tanggal = row.querySelector('.btn-lihat').dataset.tanggal;
      const jam = row.querySelector('.btn-lihat').dataset.jam;
      const catatan = row.querySelector('.btn-lihat').dataset.catatan;

      modalNama.textContent = nama;
      modalJumlah.textContent = jumlah;
      modalMeja.textContent = meja;
      modalTanggal.textContent = tanggal;
      modalJam.textContent = jam;
      modalCatatan.textContent = catatan || '-';

      modal.style.display = 'flex';
      setTimeout(() => {
        modalContent.style.transform = 'scale(1)';
        modalContent.style.opacity = '1';
      }, 50);
    });
  });

  // Tutup modal
  modalClose.addEventListener('click', () => {
    modalContent.style.transform = 'scale(0.8)';
    modalContent.style.opacity = '0';
    setTimeout(() => modal.style.display = 'none', 300);
  });

  // Tutup jika klik luar modal
  modal.addEventListener('click', (e) => {
    if (e.target === modal) {
      modalContent.style.transform = 'scale(0.8)';
      modalContent.style.opacity = '0';
      setTimeout(() => modal.style.display = 'none', 300);
    }
  });
});
