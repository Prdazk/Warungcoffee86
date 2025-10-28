document.addEventListener('DOMContentLoaded', function () {
    // ===== Alert Sukses/Hapus Otomatis =====
    document.querySelectorAll('.alert-success, .alert-danger').forEach(alertEl => {
        alertEl.style.position = 'fixed';
        alertEl.style.top = '20px';
        alertEl.style.left = '50%';
        alertEl.style.transform = 'translateX(-50%)';
        alertEl.style.zIndex = '1050';
        alertEl.style.transition = 'all 0.5s ease';
        alertEl.style.opacity = '1';

        setTimeout(() => {
            alertEl.style.opacity = '0';
            alertEl.style.transform = 'translateX(-50%) translateY(-20px)';
            setTimeout(() => alertEl.remove(), 500);
        }, 3000);
    });

    // ===== Modal Lihat Menu =====
    const modalLihatEl = document.getElementById('modalLihat');
    function showMenuModal(button) {
        document.getElementById('modalNama').textContent = button.dataset.nama;
        document.getElementById('modalHarga').textContent = Number(button.dataset.harga).toLocaleString('id-ID');
        document.getElementById('modalKategori').textContent = button.dataset.kategori;
        document.getElementById('modalStatus').textContent = button.dataset.status;
        document.getElementById('modalGambar').src = button.dataset.gambar;
        const modal = new bootstrap.Modal(modalLihatEl);
        modal.show();
    }
    document.querySelectorAll('.view-menu').forEach(btn => {
        btn.addEventListener('click', function() { showMenuModal(this); });
    });

    // ===== Modal Hapus =====
    let deleteUrl = null;
    const modalHapus = new bootstrap.Modal(document.getElementById('modalHapus'));
    const btnConfirmDelete = document.getElementById('btnConfirmDelete');
    const btnCancelDelete = document.getElementById('btnCancelDelete');
    const deleteForm = document.getElementById('deleteForm');

    btnConfirmDelete.addEventListener('click', function() {
        if(!deleteUrl) return;
        deleteForm.action = deleteUrl;
        modalHapus.hide();
        setTimeout(() => deleteForm.submit(), 200);
    });
    btnCancelDelete.addEventListener('click', () => modalHapus.hide());
    window.confirmDelete = function(url) {
        deleteUrl = url;
        modalHapus.show();
    }

    // ===== Modal Edit =====
    window.showEditModal = function(id, nama, harga, kategori, status) {
        document.getElementById('formEditMenu').action = `/admin/menu/${id}`;
        document.getElementById('editNama').value = nama;
        document.getElementById('editHarga').value = harga;
        document.getElementById('editKategori').value = kategori;
        document.getElementById('editStatus').value = status;
        new bootstrap.Modal(document.getElementById('modalEdit')).show();
    }
});
