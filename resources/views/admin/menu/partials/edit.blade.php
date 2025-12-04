<!-- Modal Edit Menu -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content custom-modal" style="background:#2b2b2b; border:1px solid #3a3a3a; border-radius:14px;">

      <div class="modal-header border-0" style="justify-content:center; position:relative;">
        <h5 class="modal-title" style="color:#c18b4a; font-weight:700; text-align:center; width:100%;">Edit Menu</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" style="position:absolute; right:15px; top:15px;"></button>
      </div>

      <form id="formEditMenu" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="modal-body">
          <div class="row g-4">

            <div class="col-md-6">
              <label class="form-label" style="color:#c18b4a;">Nama Menu</label>
              <input type="text" name="nama" id="editNama" class="form-control custom-input" placeholder="Masukkan nama" required style="background:#3a3a3a; color:#fff; border:none;">
            </div>

            <div class="col-md-6">
              <label class="form-label" style="color:#c18b4a;">Harga</label>
              <input type="number" name="harga" id="editHarga" class="form-control custom-input" placeholder="Masukkan harga" required style="background:#3a3a3a; color:#fff; border:none;">
            </div>

            <div class="col-md-6">
              <label class="form-label" style="color:#c18b4a;">Kategori</label>
              <select name="kategori" id="editKategori" class="form-select custom-input" required
                      style="background:#3a3a3a; color:#fff; border:none;">
                <option value="" style="color:#888;">-- Pilih --</option>
                <option value="Makanan" style="color:#fff;">Makanan</option>
                <option value="Minuman" style="color:#fff;">Minuman</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label" style="color:#c18b4a;">Status</label>
              <select name="status" id="editStatus" class="form-select custom-input" required
                      style="background:#3a3a3a; color:#fff; border:none;">
                <option value="Tersedia" style="color:#fff;">Tersedia</option>
                <option value="Habis" style="color:#fff;">Habis</option>
              </select>
            </div>

            <div class="col-12">
              <label class="form-label" style="color:#c18b4a;">Gambar</label>
              <input type="file" name="gambar" class="form-control custom-input" style="background:#3a3a3a; color:#fff; border:none;">
            </div>

          </div>
        </div>

        <div class="modal-footer border-0 pb-3 w-100 d-flex justify-content-center gap-3">
          <button type="button" class="btn" data-bs-dismiss="modal" style="background:#5b5b5b; color:#fff; padding:8px 30px; border:none;">
            Batal
          </button>
          <button type="submit" class="btn" style="background:#c18b4a; color:#fff; padding:8px 30px; border:none;">
            Update
          </button>
        </div>

      </form>
    </div>
  </div>
</div>

<!-- SweetAlert2 & AJAX untuk Edit -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('formEditMenu');

    // Fungsi untuk membuka modal dan mengisi data
    window.openEditModal = function(menu) {
        document.getElementById('editNama').value = menu.nama;
        document.getElementById('editHarga').value = menu.harga;
        document.getElementById('editKategori').value = menu.kategori;
        document.getElementById('editStatus').value = menu.status;
        form.action = `/admin/menu/${menu.id}`; // ubah sesuai route update
        const modal = new bootstrap.Modal(document.getElementById('modalEdit'));
        modal.show();
    }

    form.addEventListener('submit', function(e) {
        e.preventDefault(); // hentikan submit default
        const formData = new FormData(this);

        fetch(this.action, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                // Tutup modal
                const modalEl = document.getElementById('modalEdit');
                const modal = bootstrap.Modal.getInstance(modalEl);
                modal.hide();

                // Popup sukses
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    timer: 2000,
                    showConfirmButton: false
                });

                // Reload opsional untuk update tampilan
                setTimeout(() => location.reload(), 2100);
            } else {
                Swal.fire('Gagal', 'Terjadi kesalahan', 'error');
            }
        })
        .catch(() => Swal.fire('Gagal', 'Terjadi kesalahan server', 'error'));
    });
});
</script>
