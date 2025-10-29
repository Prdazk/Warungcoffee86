document.addEventListener('DOMContentLoaded', function() {

  // ===== Pagination =====
  let rows = Array.from(document.querySelectorAll('#reservasiTable tbody tr'));
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

  function refreshPagination() {
    rows = Array.from(document.querySelectorAll('#reservasiTable tbody tr'));
    showPage(currentPage);
    updatePaginationButtons();
  }

  refreshPagination();

  document.getElementById('nextBtn')?.addEventListener('click', () => {
    if (currentPage * rowsPerPage < rows.length) {
      currentPage++;
      refreshPagination();
    }
  });

  document.getElementById('prevBtn')?.addEventListener('click', () => {
    if (currentPage > 1) {
      currentPage--;
      refreshPagination();
    }
  });
  // ===== Modal Edit Reservasi =====
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

  // ===== Submit Edit AJAX + SweetAlert =====
  const editForm = document.getElementById('editReservasiForm');
  if (editForm) {
    editForm.addEventListener('submit', async function(e) {
      e.preventDefault();
      const formData = new FormData(this);
      try {
        const response = await fetch(this.action, {
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
            text: data.message || 'Data berhasil diperbarui',
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true
          });
          setTimeout(() => location.reload(), 1500);
        } else {
          Swal.fire('Gagal!', data.message || 'Terjadi kesalahan', 'error');
        }
      } catch (err) {
        console.error(err);
        Swal.fire('Gagal!', 'Terjadi kesalahan server', 'error');
      }
    });
  }

  // ===== Preview Status Meja =====
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

  // ===== SweetAlert Notifikasi Sukses Session =====
  const pesan = document.getElementById('pesanSukses');
  if (pesan) {
    Swal.fire({
      icon: 'success',
      title: 'Berhasil ✨',
      text: pesan.dataset.message,
      background: 'rgba(255,255,255,0.95)',
      backdrop: `
        rgba(0,0,0,0.4)
        url("https://i.gifer.com/7efs.gif")
        center top
        no-repeat
      `,
      showConfirmButton: false,
      timer: 2000,
      timerProgressBar: true
    });
  }

});
