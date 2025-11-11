<div class="modal fade" id="editReservasiModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="background:#2b2b2b; border:1px solid #3a3a3a; border-radius:14px; color:#FFF;">

      <div class="modal-header border-0" style="justify-content:center; position:relative;">
        <h5 class="modal-title" style="color:#c18b4a; font-weight:700;">Edit Reservasi</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" style="position:absolute; right:15px; top:15px;"></button>
      </div>

      <form id="editReservasiForm" method="POST">
        @csrf
        @method('PUT')

        <div class="modal-body">
          <div class="row g-2">

            <div class="col-md-6">
              <label class="form-label" style="color:#c18b4a;">Nama</label>
              <input type="text" name="nama" id="editNama" class="form-control" required style="background:#3a3a3a; color:#fff; border:none; border-radius:6px;">
            </div>

            <div class="col-md-6">
              <label class="form-label" style="color:#c18b4a;">Jumlah Orang</label>
              <input type="number" name="jumlah_orang" id="editJumlah" class="form-control" min="1" max="10" required style="background:#3a3a3a; color:#fff; border:none; border-radius:6px;">
            </div>

            <div class="col-md-6">
              <label class="form-label" style="color:#c18b4a;">Meja</label>
              <select name="meja_id" id="editMeja" class="form-select" required style="background:#3a3a3a; color:#fff; border:none; border-radius:6px;">
                <option value="">-- Pilih Meja --</option>
                @foreach(\App\Models\Meja::orderBy('id','asc')->get() as $meja)
                  <option value="{{ $meja->id }}">{{ $meja->nama_meja }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label" style="color:#c18b4a;">Status Reservasi</label>
              <select name="status" id="editStatus" class="form-select" required style="background:#3a3a3a; color:#fff; border:none; border-radius:6px;">
                <option value="Dipesan">Dipesan</option>
                <option value="Dibatalkan">Dibatalkan</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label" style="color:#c18b4a;">Tanggal</label>
              <input type="date" name="tanggal" id="editTanggal" class="form-control" required style="background:#3a3a3a; color:#fff; border:none; border-radius:6px;">
            </div>

            <div class="col-md-6">
              <label class="form-label" style="color:#c18b4a;">Jam</label>
              <input type="time" name="jam" id="editJam" class="form-control" required style="background:#3a3a3a; color:#fff; border:none; border-radius:6px;">
            </div>

            <div class="col-12">
              <label class="form-label" style="color:#c18b4a;">Catatan</label>
              <textarea name="catatan" id="editCatatan" class="form-control" rows="3" style="background:#3a3a3a; color:#fff; border:none; border-radius:6px;"></textarea>
            </div>

          </div>
        </div>

        <div class="modal-footer border-0 pb-3 d-flex justify-content-center gap-3">
          <button type="button" class="btn" data-bs-dismiss="modal" style="background:#5b5b5b; color:#fff; padding:8px 30px;">Batal</button>
          <button type="submit" class="btn" style="background:#c18b4a; color:#fff; padding:8px 30px;">Update</button>
        </div>

      </form>
    </div>
  </div>
</div>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {

    const editForm   = document.getElementById('editReservasiForm');
    const editModalEl = document.getElementById('editReservasiModal');
    const editModal   = new bootstrap.Modal(editModalEl);

    document.querySelector('#reservasiTable tbody').addEventListener('click', function(e) {
        const btn = e.target.closest('.btn-edit');
        if (!btn) return;

        if (btn.dataset.status === 'Dibatalkan') {
            Swal.fire({
                icon: 'warning',
                title: 'Tidak Bisa Diedit',
                text: 'Reservasi ini sudah dibatalkan. Silakan buat reservasi baru.',
                confirmButtonText: 'Mengerti'
            });
            return;
        }

        editForm.action = `/admin/reservasi/${btn.dataset.id}`;

        editForm.querySelector('#editNama').value     = btn.dataset.nama ?? '';
        editForm.querySelector('#editJumlah').value   = btn.dataset.jumlah ?? '';
        editForm.querySelector('#editMeja').value     = btn.dataset.meja ?? '';
        editForm.querySelector('#editTanggal').value  = btn.dataset.tanggal ?? '';
        editForm.querySelector('#editJam').value      = btn.dataset.jam ?? '';
        editForm.querySelector('#editCatatan').value  = btn.dataset.catatan ?? '';
        editForm.querySelector('#editStatus').value   = btn.dataset.status ?? 'Dipesan';

        editModal.show();
    });

    editForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const submitBtn = editForm.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.textContent = 'Memproses...';

        const formData = new FormData(editForm);
        formData.append('_method', 'PUT');

        try {
            const res = await fetch(editForm.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            });

            const result = await res.json();

            if (res.ok) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: result.message ?? 'Reservasi berhasil diperbarui.',
                    showConfirmButton: false,
                    timer: 1500
                });
                editForm.reset();
                setTimeout(() => window.location.reload(), 1600);
            } else {
                Swal.fire('Gagal!', result.message || 'Terjadi kesalahan.', 'error');
            }
        } catch (err) {
            Swal.fire('Error!', 'Koneksi gagal. Silakan coba lagi.', 'error');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Update';
        }
    });

    editModalEl.addEventListener('hidden.bs.modal', () => editForm.reset());

});

</script>