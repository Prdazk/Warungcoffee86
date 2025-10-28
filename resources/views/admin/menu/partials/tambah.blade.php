<!-- ===== Modal Tambah Menu ===== -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow-lg rounded-4" style="background:#4B3621; color:#FFF;">

      <!-- Header -->
      <div class="modal-header border-0">
        <h5 class="modal-title fw-semibold">Tambah Menu Baru</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <!-- Form -->
      <form action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Body -->
        <div class="modal-body">
          <div class="row g-3">

            <!-- Nama Menu -->
            <div class="col-md-6">
              <label class="form-label fw-semibold">Nama Menu</label>
              <input type="text" name="nama" class="form-control shadow-sm" required
                     style="background:#815b3b; color:#FFF; border:none; border-radius:6px;">
            </div>

            <!-- Harga -->
            <div class="col-md-6">
              <label class="form-label fw-semibold">Harga</label>
              <input type="number" name="harga" class="form-control shadow-sm" required
                     style="background:#815b3b; color:#FFF; border:none; border-radius:6px;">
            </div>

            <!-- Kategori -->
            <div class="col-md-6">
              <label class="form-label fw-semibold">Kategori</label>
              <select name="kategori" class="form-select shadow-sm" required
                      style="background:#815b3b; color:#FFF; border:none; border-radius:6px;">
                <option value="">-- Pilih --</option>
                <option value="Makanan">Makanan</option>
                <option value="Minuman">Minuman</option>
              </select>
            </div>

            <!-- Status -->
            <div class="col-md-6">
              <label class="form-label fw-semibold">Status</label>
              <select name="status" class="form-select shadow-sm" required
                      style="background:#815b3b; color:#FFF; border:none; border-radius:6px;">
                <option value="Tersedia">Tersedia</option>
                <option value="Habis">Habis</option>
              </select>
            </div>

            <!-- Gambar -->
            <div class="col-12">
              <label class="form-label fw-semibold">Gambar</label>
              <input type="file" name="gambar" class="form-control shadow-sm"
                     style="background:#815b3b; color:#FFF; border:none; border-radius:6px;">
            </div>

          </div>
        </div>

        <!-- Footer -->
        <div class="modal-footer border-0 d-flex justify-content-center gap-3 pb-3">
          <button type="button" class="btn px-4 py-2 rounded-3 fw-semibold"
                  style="background:#D32F2F; color:#FFF; box-shadow:0 4px 10px rgba(0,0,0,0.2); transition:all 0.2s ease;"
                  data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn px-4 py-2 rounded-3 fw-semibold"
                  style="background:#8B5E3C; color:#FFF; box-shadow:0 4px 10px rgba(0,0,0,0.2); transition:all 0.2s ease;">Simpan</button>
        </div>

      </form>
    </div>
  </div>
</div>
