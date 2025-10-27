{{-- ================= Modal Edit Reservasi ================= --}}
<div class="modal fade" id="editReservasiModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width:500px;">
    <div class="modal-content shadow-lg rounded-4" style="background:#4B3621; color:#FFF;">

      <div class="modal-header border-0">
        <h5 class="modal-title"><i class="fas fa-edit me-2"></i> Edit Reservasi</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <form id="editReservasiForm" method="POST">
        @csrf
        @method('PUT')

        <div class="modal-body">
          <div class="row g-2">

            <div class="col-md-6">
              <label class="form-label">Nama</label>
              <input type="text" name="nama" id="editNama" class="form-control" required
                     style="background:#815b3b; color:#FFF; border:none; border-radius:6px;">
            </div>

            <div class="col-md-6">
              <label class="form-label">Jumlah Orang</label>
              <input type="number" name="jumlah_orang" id="editJumlah" class="form-control" required min="1" max="10"
                     style="background:#815b3b; color:#FFF; border:none; border-radius:6px;">
            </div>

            <div class="col-md-6">
              <label class="form-label">Meja</label>
              <select name="meja_id" id="editMeja" class="form-select" required
                      style="background:#815b3b; color:#FFF; border:none; border-radius:6px;">
                <option value="">-- Pilih Meja --</option>
                @foreach(\App\Models\Meja::orderBy('id','asc')->get() as $meja)
                  <option value="{{ $meja->id }}">{{ $meja->nama_meja }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label">Status Reservasi</label>
             <select name="status" id="editStatus" class="form-select"
                    style="background:#815b3b; color:#FFF; border:none; border-radius:6px;">
                <option value="Dipesan">Dipesan</option>
                <option value="batal">Batal</option> <!-- gunakan 'batal' bukan 'Dibatalkan' -->
            </select>
            </div>

            <div class="col-md-6">
              <label class="form-label">Tanggal</label>
              <input type="date" name="tanggal" id="editTanggal" class="form-control" required
                     style="background:#815b3b; color:#FFF; border:none; border-radius:6px;">
            </div>

            <div class="col-md-6">
              <label class="form-label">Jam</label>
              <input type="time" name="jam" id="editJam" class="form-control" required
                     style="background:#815b3b; color:#FFF; border:none; border-radius:6px;">
            </div>

            <div class="col-12">
              <label class="form-label">Catatan</label>
              <textarea name="catatan" id="editCatatan" class="form-control" rows="3"
                        style="background:#815b3b; color:#FFF; border:none; border-radius:6px;"></textarea>
            </div>

          </div>
        </div>

        <div class="modal-footer border-0 d-flex justify-content-center gap-3">
          <button type="button" class="btn btn-danger px-4" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary px-4">Update</button>
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

    // Fungsi untuk ubah warna status otomatis
    function updateStatusColor() {
        const status = editStatusSelect.value;
        if(status === 'Dipesan') editStatusSelect.style.background = '#FF9800';
        else if(status === 'Batal') editStatusSelect.style.background = '#e53935';
        else editStatusSelect.style.background = '#757575';
    }

    editStatusSelect.addEventListener('change', updateStatusColor);

    // Tombol edit
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

    // Submit form edit reservasi (AJAX)
    editForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('_method', 'PUT'); // penting untuk Laravel

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
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
            }
        });
    });

    // Reset modal saat ditutup
    editModalEl.addEventListener('hidden.bs.modal', () => {
        editForm.reset();
        editStatusSelect.value = 'Dipesan';
        updateStatusColor();
    });
});
</script>

