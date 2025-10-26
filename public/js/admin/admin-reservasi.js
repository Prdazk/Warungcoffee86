// ===============================
// Admin Reservasi - Script Lengkap (Final SweetAlert + Fix JSON)
// ===============================
document.addEventListener('DOMContentLoaded', function() {

  // ======== Pagination ========
  const rows = document.querySelectorAll('#reservasiTable tbody tr');
  const rowsPerPage = 5;
  let currentPage = 1;

  function showPage(page) {
    const start = (page - 1) * rowsPerPage;
    const end = start + rowsPerPage;
    rows.forEach((row, index) => {
      row.style.display = (index >= start && index < end) ? '' : 'none';
    });
  }

  function updatePaginationButtons() {
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    if (!prevBtn || !nextBtn) return;
    prevBtn.disabled = currentPage === 1;
    nextBtn.disabled = currentPage * rowsPerPage >= rows.length;
    prevBtn.style.opacity = prevBtn.disabled ? '0.5' : '1';
    nextBtn.style.opacity = nextBtn.disabled ? '0.5' : '1';
  }

  showPage(currentPage);
  updatePaginationButtons();

  document.getElementById('nextBtn')?.addEventListener('click', () => {
    if (currentPage * rowsPerPage < rows.length) {
      currentPage++;
      showPage(currentPage);
      updatePaginationButtons();
    }
  });

  document.getElementById('prevBtn')?.addEventListener('click', () => {
    if (currentPage > 1) {
      currentPage--;
      showPage(currentPage);
      updatePaginationButtons();
    }
  });

  // ======== Pencarian ========
  const searchInput = document.getElementById('searchInput');
  if (searchInput) {
    searchInput.addEventListener('keyup', function() {
      const filter = this.value.toLowerCase();
      rows.forEach(row => {
        const nama = row.cells[1]?.textContent.toLowerCase() || '';
        row.style.display = nama.includes(filter) ? '' : 'none';
      });
    });
  }

  // ======== Popup Konfirmasi Hapus ========
  let formToSubmit = null;
  const popup = document.getElementById('confirmPopup');
  const batalBtn = document.getElementById('batalHapus');
  const yakinBtn = document.getElementById('yakinHapus');

  document.querySelectorAll('.btn-hapus').forEach(btn => {
    btn.addEventListener('click', e => {
      e.preventDefault();
      formToSubmit = btn.closest('form');
      if (popup) popup.style.display = 'flex';
    });
  });

  batalBtn?.addEventListener('click', () => { 
    popup.style.display = 'none'; 
    formToSubmit = null; 
  });
  
  yakinBtn?.addEventListener('click', () => { 
    if (formToSubmit) formToSubmit.submit(); 
  });

  // ======== Modal Edit Reservasi ========
  document.querySelectorAll('.btn-edit').forEach(btn => {
    btn.addEventListener('click', () => {
      const form = document.getElementById('editReservasiForm');
      if (!form) return;
      form.action = `/admin/reservasi/${btn.dataset.id}`;
      document.getElementById('editNama').value = btn.dataset.nama;
      document.getElementById('editJumlah').value = btn.dataset.jumlah;
      document.getElementById('editMeja').value = btn.dataset.meja;
      document.getElementById('editTanggal').value = btn.dataset.tanggal.split('T')[0];
      document.getElementById('editJam').value = btn.dataset.jam;
      document.getElementById('editCatatan').value = btn.dataset.catatan;
    });
  });

  // ======== Kirim Form Edit via AJAX + SweetAlert ========
  const editForm = document.getElementById('editReservasiForm');
  if (editForm) {
    editForm.addEventListener('submit', async function(e) {
      e.preventDefault(); // cegah reload

      const formData = new FormData(this);
      const actionUrl = this.action;

      try {
        const response = await fetch(actionUrl, {
          method: 'POST',
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          },
          body: formData
        });

        const data = await response.json();

        if (data.status === 'success') {
          const modal = bootstrap.Modal.getInstance(document.getElementById('editReservasiModal'));
          modal.hide();

          Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: data.message,
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true
          });

          setTimeout(() => {
            location.reload();
          }, 1500);
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: data.message || 'Terjadi kesalahan saat memperbarui data.'
          });
        }
      } catch (error) {
        console.error('Error:', error);
        Swal.fire({
          icon: 'error',
          title: 'Kesalahan Server',
          text: 'Tidak dapat terhubung ke server.'
        });
      }
    });
  }

  // ======== Modal Lihat Reservasi ========
  const lihatModal = document.getElementById('modalLihatReservasi');
  const lihatContent = document.getElementById('modalContent');
  const closeModalBtn = document.getElementById('closeModalBtn');

  document.querySelectorAll('.btn-lihat').forEach(btn => {
    btn.addEventListener('click', () => {
      document.getElementById('detail-nama').textContent = btn.dataset.nama;
      document.getElementById('detail-jumlah').textContent = btn.dataset.jumlah;
      document.getElementById('detail-meja').textContent = btn.dataset.meja;
      document.getElementById('detail-tanggal').textContent = btn.dataset.tanggal;
      document.getElementById('detail-jam').textContent = btn.dataset.jam;
      document.getElementById('detail-catatan').textContent = btn.dataset.catatan;

      lihatModal.style.display = 'flex';
      setTimeout(() => {
        lihatContent.style.transform = 'scale(1)';
        lihatContent.style.opacity = '1';
      }, 10);
    });
  });

  function closeLihatModal() {
    lihatContent.style.transform = 'scale(0.8)';
    lihatContent.style.opacity = '0';
    setTimeout(() => { lihatModal.style.display = 'none'; }, 250);
  }

  closeModalBtn?.addEventListener('click', closeLihatModal);
  lihatModal?.addEventListener('click', (e) => { if (e.target === lihatModal) closeLihatModal(); });

  // ==============================
  // 🔥 Preview Status Meja
  // ==============================
  const statusSelect = document.getElementById('statusSelect');
  const statusPreview = document.getElementById('statusPreview');
  const statusBadge = document.getElementById('statusBadge');
  if (statusSelect && statusPreview && statusBadge) {
    statusSelect.addEventListener('change', function() {
      const val = this.value;
      let color = '', text = '';
      if (val === 'Kosong') { color = 'bg-success'; text = 'Kosong (Siap Digunakan)'; }
      else if (val === 'Terisi') { color = 'bg-secondary'; text = 'Terisi (Sedang Dipakai)'; }
      else if (val === 'Dipesan') { color = 'bg-warning text-dark'; text = 'Dipesan (Sudah Direservasi)'; }
      statusBadge.className = `badge rounded-pill px-3 py-2 ${color}`;
      statusBadge.textContent = text;
      statusPreview.style.display = 'block';
    });
  }

});
