<!-- ===== Modal Tambah Meja ===== -->
<div class="modal fade" id="tambahMejaModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content shadow-lg rounded-4 border-0 text-center" style="background:#4B3621; color:#FFF;">

      <!-- Header -->
      <div class="modal-header border-0 d-flex justify-content-center">
        <h5 class="modal-title fw-semibold">
          <i class="fas fa-chair me-2"></i> Tambah Meja Baru
        </h5>
        <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3" data-bs-dismiss="modal"></button>
      </div>

      <!-- Form -->
      <form id="formTambahMeja" action="{{ route('admin.reservasi.meja.store') }}" method="POST">
        @csrf

        <!-- Body -->
        <div class="modal-body px-4 pb-2 d-flex flex-column align-items-center justify-content-center">
          <div class="w-75">
            <label class="form-label fw-semibold mb-2 text-center d-block">Nama Meja</label>
            <input type="text" name="nama_meja"
                   class="form-control rounded-3 px-3 text-center fw-semibold"
                   placeholder="Masukkan nama meja (misal: Meja 5)" required
                   style="background:#6A4827; color:#FFF; border:none; height:48px;">
          </div>
        </div>

        <!-- Footer -->
        <div class="modal-footer border-0 d-flex justify-content-center pb-4 gap-3">
          <button type="button" class="btn btn-danger px-4 py-2 rounded-3 fw-semibold" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i> Batal
          </button>
          <button type="submit" class="btn btn-success px-4 py-2 rounded-3 fw-semibold">
            <i class="fas fa-save me-1"></i> Simpan
          </button>
        </div>
      </form>

    </div>
  </div>
</div>

<!-- ===== SweetAlert2 dan JS Tambahan ===== -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/tambahMejaAlert.js') }}"></script>
