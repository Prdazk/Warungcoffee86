<!-- Modal Hapus Menu -->
<div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width:420px; margin-top:-40px;">
    <div class="modal-content" style="background:#1b1b1b;color:#fff;border-radius:14px;border:1px solid #3a3a3a;box-shadow:0 0 20px rgba(0,0,0,0.6);padding:25px 20px 20px;text-align:center;">

      <h5 style="font-weight:700;color:#c18b4a;letter-spacing:1px;text-transform:uppercase;margin-bottom:18px;">
        Hapus Menu
      </h5>
      <p style="font-size:14px;color:#e9e9e9;opacity:1;margin-bottom:25px;">
        Apakah Anda yakin ingin menghapus menu <span id="namaMenu" style="font-weight:600;"></span>?
      </p>

      <div class="d-flex justify-content-center gap-3">
        <button type="button" class="btn" style="background:#5b5b5b;border-radius:8px;padding:8px 30px;font-weight:600;color:#fff;border:none;font-size:14px;" data-bs-dismiss="modal">Batal</button>

        <form id="deleteForm" method="POST" style="display:inline;" action="">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn" style="background:#c18b4a;border-radius:8px;padding:8px 30px;font-weight:600;color:#fff;border:none;font-size:14px;">
              Hapus
            </button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const modalHapus = document.getElementById('modalHapus');

    window.confirmDelete = function(url, nama) {
        // Set nama menu di modal
        document.getElementById('namaMenu').textContent = nama;

        // Set form action ke URL delete
        document.getElementById('deleteForm').action = url;

        // Tampilkan modal
        const modal = new bootstrap.Modal(modalHapus);
        modal.show();
    }
});
</script>

{{-- SweetAlert untuk notifikasi sukses, hanya jika ingin pakai --}}
@if(session('success'))
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: '{{ session('success') }}',
    timer: 2000,
    showConfirmButton: false
});
</script>
@endif
