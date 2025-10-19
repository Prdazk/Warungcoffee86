document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById('modalLihatReservasi');
  const modalContent = document.getElementById('modalContent');
  const closeBtn = document.getElementById('closeModalBtn');

  document.querySelectorAll('.btn-lihat').forEach(button => {
    button.addEventListener('click', () => {
      document.getElementById('detail-nama').textContent = button.dataset.nama;
      document.getElementById('detail-jumlah').textContent = button.dataset.jumlah;
      document.getElementById('detail-meja').textContent = button.dataset.meja;
      document.getElementById('detail-tanggal').textContent = button.dataset.tanggal;
      document.getElementById('detail-jam').textContent = button.dataset.jam;
      document.getElementById('detail-catatan').textContent = button.dataset.catatan;

      // Tampilkan modal dengan animasi
      modal.style.display = 'flex';
      setTimeout(() => {
        modal.style.opacity = '1';
        modalContent.style.transform = 'scale(1)';
        modalContent.style.opacity = '1';
      }, 10);
    });
  });

  // Tutup modal dengan animasi
  function closeModal() {
    modal.style.opacity = '0';
    modalContent.style.transform = 'scale(0.8)';
    modalContent.style.opacity = '0';
    setTimeout(() => {
      modal.style.display = 'none';
    }, 300);
  }

  closeBtn.addEventListener('click', closeModal);
  window.addEventListener('click', e => {
    if (e.target === modal) closeModal();
  });
});
