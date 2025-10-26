{{-- ================= Modal Edit Reservasi ================= --}}
<div class="modal fade" id="editReservasiModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow-lg rounded-4" style="background:#4B3621; color:#FFF;">

      <div class="modal-header border-0">
        <h5 class="modal-title">
          <i class="fas fa-edit me-2"></i> Edit Reservasi
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <form id="editReservasiForm" method="POST">
        @csrf
        @method('PUT')

        <div class="modal-body">
          <div class="row g-3">

            {{-- Nama --}}
            <div class="col-md-6">
              <label class="form-label">Nama</label>
              <input type="text" name="nama" id="editNama" class="form-control" required
                     style="background:#815b3b; color:#FFF; border:none;">
            </div>

            {{-- Jumlah Orang --}}
            <div class="col-md-6">
              <label class="form-label">Jumlah Orang</label>
              <input type="number" name="jumlah_orang" id="editJumlah" class="form-control" required min="1" max="10"
                     style="background:#815b3b; color:#FFF; border:none;">
            </div>

            {{-- Pilih Meja --}}
            <div class="col-md-6">
              <label class="form-label">Meja</label>
              <select name="meja_id" id="editMeja" class="form-select" required
                      style="background:#815b3b; color:#FFF; border:none;">
                <option value="">-- Pilih Meja --</option>
                @foreach(\App\Models\Meja::orderBy('id','asc')->get() as $meja)
                  <option value="{{ $meja->id }}">{{ $meja->nama_meja }}</option>
                @endforeach
              </select>
            </div>

            {{-- Status Reservasi --}}
            <div class="col-md-6">
              <label class="form-label">Status Reservasi</label>
              <select name="status" id="editStatus" class="form-select"
                      style="background:#815b3b; color:#FFF; border:none;">
                <option value="Dipesan">Dipesan</option>
                <option value="Terisi">Terisi</option>
                <option value="Selesai">Selesai</option>
                <option value="Dibatalkan">Dibatalkan</option>
              </select>
            </div>

            {{-- Tanggal --}}
            <div class="col-md-6">
              <label class="form-label">Tanggal</label>
              <input type="date" name="tanggal" id="editTanggal" class="form-control" required
                     style="background:#815b3b; color:#FFF; border:none;">
            </div>

            {{-- Jam --}}
            <div class="col-md-6">
              <label class="form-label">Jam</label>
              <input type="time" name="jam" id="editJam" class="form-control" required
                     style="background:#815b3b; color:#FFF; border:none;">
            </div>

            {{-- Catatan --}}
            <div class="col-12">
              <label class="form-label">Catatan</label>
              <textarea name="catatan" id="editCatatan" class="form-control" rows="3"
                        style="background:#815b3b; color:#FFF; border:none;"></textarea>
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

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  // =========================
  // Modal Edit Reservasi
  // =========================
  const editForm = document.getElementById('editReservasiForm');
  const editModalEl = document.getElementById('editReservasiModal');
  const editModal = new bootstrap.Modal(editModalEl);

  // Saat tombol Edit diklik
  document.querySelectorAll('.btn-edit').forEach(button => {
    button.addEventListener('click', () => {
      const data = button.dataset;
      editForm.action = `/admin/reservasi/${data.id}`;
      document.getElementById('editNama').value = data.nama;
      document.getElementById('editJumlah').value = data.jumlah;
      document.getElementById('editMeja').value = data.meja;
      document.getElementById('editStatus').value = data.status;
      document.getElementById('editTanggal').value = data.tanggal.split('T')[0];
      document.getElementById('editJam').value = data.jam;
      document.getElementById('editCatatan').value = data.catatan || '';
    });
  });

  // Saat form disubmit (AJAX)
  editForm.addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    const actionUrl = this.action;

    fetch(actionUrl, {
      method: 'POST',
      body: formData,
      headers: { 'X-Requested-With': 'XMLHttpRequest' },
    })
      .then(res => res.json())
      .then(data => {
        if (data.status === 'success') {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: data.message,
            timer: 1500,
            showConfirmButton: false,
          });

          editModal.hide();
          setTimeout(() => window.location.reload(), 1500);
        } else {
          Swal.fire({
            icon: 'warning',
            title: 'Gagal!',
            text: data.message || 'Terjadi kesalahan saat update.',
          });
        }
      })
      .catch(() => {
        Swal.fire({
          icon: 'error',
          title: 'Error!',
          text: 'Tidak dapat menghubungi server.',
        });
      });
  });

  // Reset form saat modal ditutup
  editModalEl.addEventListener('hidden.bs.modal', () => {
    editForm.reset();
  });
});
</script>
