<div class="modal fade" id="tambahMejaModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow-lg rounded-4" style="background:#4B3621; color:#FFF;">
      
      <div class="modal-header border-0">
        <h5 class="modal-title d-flex align-items-center">
          <i class="fas fa-chair me-2"></i> Tambah Meja Baru
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <form id="formTambahMeja" action="{{ route('admin.reservasi.meja.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="row g-4">

            {{-- Nama Meja --}}
            <div class="col-md-6">
              <label class="form-label fw-semibold">Nama Meja</label>
              <input type="text" name="nama_meja" class="form-control rounded-3 px-3" required
                     placeholder="Masukkan nama meja (misal: Meja 5)"
                     style="background:#815b3b; color:#FFF; border:none; height:48px;">
            </div>

            {{-- Kapasitas --}}
            <div class="col-md-6">
              <label class="form-label fw-semibold">Kapasitas</label>
              <input type="number" name="kapasitas" class="form-control rounded-3 px-3" required min="1" max="12"
                     placeholder="Jumlah kursi (misal: 4)"
                     style="background:#815b3b; color:#FFF; border:none; height:48px;">
            </div>

          </div>
        </div>

        <div class="modal-footer border-0 d-flex justify-content-center gap-3">
          <button type="button" class="btn btn-danger px-4 py-2 rounded-3" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i> Batal
          </button>
          <button type="submit" class="btn btn-success px-4 py-2 rounded-3">
            <i class="fas fa-save me-1"></i> Simpan
          </button>
        </div>
      </form>

    </div>
  </div>
</div>

<!-- ===== Load SweetAlert2 dan JS Tambahan ===== -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/tambahMejaAlert.js') }}"></script>
