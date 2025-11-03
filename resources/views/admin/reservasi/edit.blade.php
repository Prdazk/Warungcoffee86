{{-- ================= Modal Edit Reservasi ================= --}}
<div class="modal fade" id="editReservasiModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="background:#2b2b2b; border:1px solid #3a3a3a; border-radius:14px; color:#FFF;">

      <!-- Header -->
      <div class="modal-header border-0" style="justify-content:center; position:relative;">
        <h5 class="modal-title" style="color:#c18b4a; font-weight:700; text-align:center; width:100%;">Edit Reservasi</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" style="position:absolute; right:15px; top:15px;"></button>
      </div>

      <!-- Form -->
      <form id="editReservasiForm" method="POST">
        @csrf
        @method('PUT')

        <!-- Body -->
        <div class="modal-body">
          <div class="row g-2">

            <div class="col-md-6">
              <label class="form-label" style="color:#c18b4a;">Nama</label>
              <input type="text" name="nama" id="editNama" class="form-control" placeholder="Masukkan nama" required 
                     style="background:#3a3a3a; color:#fff; border:none; border-radius:6px;">
            </div>

            <div class="col-md-6">
              <label class="form-label" style="color:#c18b4a;">Jumlah Orang</label>
              <input type="number" name="jumlah_orang" id="editJumlah" class="form-control" placeholder="Jumlah orang" required min="1" max="10"
                     style="background:#3a3a3a; color:#fff; border:none; border-radius:6px;">
            </div>

            <div class="col-md-6">
              <label class="form-label" style="color:#c18b4a;">Meja</label>
              <select name="meja_id" id="editMeja" class="form-select" required
                      style="background:#3a3a3a; color:#fff; border:none; border-radius:6px;">
                <option value="" style="color:#888;">-- Pilih Meja --</option>
                @foreach(\App\Models\Meja::orderBy('id','asc')->get() as $meja)
                  <option value="{{ $meja->id }}" style="color:#fff;">{{ $meja->nama_meja }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label" style="color:#c18b4a;">Status Reservasi</label>
              <select name="status" id="editStatus" class="form-select" required
                      style="background:#3a3a3a; color:#fff; border:none; border-radius:6px;">
                <option value="Dipesan" style="color:#fff;">Dipesan</option>
                <option value="Dibatalkan" style="color:#fff;">Batal</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label" style="color:#c18b4a;">Tanggal</label>
              <input type="date" name="tanggal" id="editTanggal" class="form-control" required
                     style="background:#3a3a3a; color:#fff; border:none; border-radius:6px;">
            </div>

            <div class="col-md-6">
              <label class="form-label" style="color:#c18b4a;">Jam</label>
              <input type="time" name="jam" id="editJam" class="form-control" required
                     style="background:#3a3a3a; color:#fff; border:none; border-radius:6px;">
            </div>

            <div class="col-12">
              <label class="form-label" style="color:#c18b4a;">Catatan</label>
              <textarea name="catatan" id="editCatatan" class="form-control" rows="3"
                        style="background:#3a3a3a; color:#fff; border:none; border-radius:6px;"></textarea>
            </div>

          </div>
        </div>

        <!-- Footer -->
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    const editForm = document.getElementById('editReservasiForm');
    const editModalEl = document.getElementById('editReservasiModal');
    const editModal = new bootstrap.Modal(editModalEl);
    const editStatusSelect = document.getElementById('editStatus');

    // Fungsi update warna select status
    function updateStatusColor() {
        const status = editStatusSelect.value;
        if(status === 'Dipesan') editStatusSelect.style.background = '#c18b4a';
        else if(status === 'Batal') editStatusSelect.style.background = '#d32f2f';
        else editStatusSelect.style.background = '#3a3a3a';
    }

    editStatusSelect.addEventListener('change', updateStatusColor);

    // Saat tombol edit diklik
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', () => {
            const data = btn.dataset;
            editForm.action = `/admin/reservasi/${data.id}`;
            document.getElementById('editNama').value = data.nama || '';
            document.getElementById('editJumlah').value = data.jumlah || '';
            document.getElementById('editMeja').value = data.meja || '';
            document.getElementById('editTanggal').value = data.tanggal ? data.tanggal.split('T')[0] : '';
            document.getElementById('editJam').value = data.jam || '';
            document.getElementById('editCatatan').value = data.catatan || '';
            editStatusSelect.value = data.status || 'Dipesan';
            updateStatusColor();
            editModal.show();
        });
    });

    // Submit AJAX update reservasi
    editForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('_method', 'PUT');

        fetch(this.action, {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            body: formData,
        })
        .then(res => res.json())
        .then(data => {
            if(data.status === 'success'){
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                });
                editModal.hide();
                setTimeout(()=>window.location.reload(), 1500);
            } else {
                Swal.fire('Gagal!', data.message || 'Terjadi kesalahan', 'error');
            }
        })
        .catch(err => {
            console.error(err);
            Swal.fire('Gagal!', 'Terjadi kesalahan server', 'error');
        });
    });

    // Reset form saat modal ditutup
    editModalEl.addEventListener('hidden.bs.modal', () => {
        editForm.reset();
        editStatusSelect.value = 'Dipesan';
        updateStatusColor();
    });
});
</script>
