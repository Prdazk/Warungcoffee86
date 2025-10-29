document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById('modalLihatReservasi');
  const modalContent = document.getElementById('modalContent');
  const closeBtn = document.getElementById('closeModalBtn');
  const detailCatatan = document.getElementById('detail-catatan');

  function openModalCatatan(catatan) {
    detailCatatan.textContent = catatan || '-';

    // Reset sebelum animasi
    modal.style.display = 'flex';
    modal.style.opacity = '0';
    modalContent.style.transition = 'none';
    modalContent.style.transform = 'scale(0.8)';
    modalContent.style.opacity = '0';

    // Trigger animasi masuk
    setTimeout(() => {
      modal.style.opacity = '1';
      modalContent.style.transition = 'all 0.3s ease';
      modalContent.style.transform = 'scale(1)';
      modalContent.style.opacity = '1';
    }, 20);
  }

  function closeModal() {
    modalContent.style.transform = 'scale(0.8)';
    modalContent.style.opacity = '0';
    modal.style.opacity = '0';
    setTimeout(() => modal.style.display = 'none', 300);
  }

  // Event delegation untuk semua tombol lihat
  document.addEventListener('click', e => {
    const btn = e.target.closest('.btn-lihat');
    if (!btn) return;
    const catatan = btn.getAttribute('data-catatan');
    openModalCatatan(catatan);
  });

  closeBtn.addEventListener('click', closeModal);
  window.addEventListener('click', e => {
    if (e.target === modal) closeModal();
  });
});
