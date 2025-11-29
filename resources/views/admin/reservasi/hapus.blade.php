<!-- Modal Hapus Reservasi -->
<div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width:420px; margin-top:-40px;">
    <div class="modal-content" style="background:#1b1b1b;color:#fff;border-radius:14px;border:1px solid #3a3a3a;box-shadow:0 0 20px rgba(0,0,0,0.6);padding:25px 20px 20px;text-align:center;">
      
      <h5 style="font-weight:700;color:#c18b4a;letter-spacing:1px;text-transform:uppercase;margin-bottom:18px;">
        Hapus Reservasi
      </h5>
      <p style="font-size:14px;color:#e9e9e9;opacity:1;margin-bottom:25px;">
        Apakah Anda yakin ingin menghapus reservasi <span id="namaReservasi" style="font-weight:600;"></span>?
      </p>
      
      <div class="d-flex justify-content-center gap-3">
        <button type="button" class="btn" style="background:#5b5b5b;border-radius:8px;padding:8px 30px;font-weight:600;color:#fff;transition:.3s;border:none;font-size:14px;" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn" id="btnConfirmDelete" style="background:#c18b4a;border-radius:8px;padding:8px 30px;font-weight:600;color:#fff;transition:.3s;border:none;font-size:14px;">
          Hapus
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Form Hidden -->
<form id="deleteForm" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const modalHapus = document.getElementById('modalHapus');
    let deleteId = null;

    modalHapus.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        deleteId = button.getAttribute('data-id');
        const nama = button.getAttribute('data-nama');
        document.getElementById('namaReservasi').textContent = nama;
    });

    document.getElementById('btnConfirmDelete').addEventListener('click', function() {
        if (!deleteId) return;

        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const url = "{{ route('admin.reservasi.destroy', ':id') }}".replace(':id', deleteId);

        fetch(url, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                const modalInstance = bootstrap.Modal.getInstance(modalHapus);
                modalInstance.hide();

                if (window.reloadAdminTable) window.reloadAdminTable();
                if (window.reloadUserMeja) window.reloadUserMeja();

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: data.message || 'Terjadi kesalahan.'
                });
            }
        })
        .catch(() => {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Terjadi kesalahan server.'
            });
        });
    });
});
</script>
