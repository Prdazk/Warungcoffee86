<style>
/* ===== MODAL WRAPPER ===== */
.custom-modal {
    background: #1b1b1b;
    color: #fff;
    border-radius: 14px;
    border: 1px solid #3a3a3a;
    box-shadow: 0 0 20px rgba(0,0,0,0.6);
    overflow: hidden;
    padding-bottom: 10px;
}

/* Perkecil ukuran modal */
#modalTambah .modal-dialog {
    max-width: 650px;
}

/* ===== TITLE ===== */
#modalTambah .modal-title {
    font-size: 20px;
    font-weight: 700;
    color: #c18b4a;
    width: 100%;
    text-align: center;
    letter-spacing: 1px;
    text-transform: uppercase;
}

/* ===== LABEL ===== */
#modalTambah .form-label {
    color: #c18b4a;
    font-size: 13px;
    margin-bottom: 4px;
}

/* ===== INPUT, SELECT ===== */
#modalTambah .custom-input {
    background: rgba(30,30,30,0.9) !important;
    border-radius: 10px;
    border: 1px solid #444;
    color: #fff !important;
    padding: 8px 10px;
    font-size: 14px;
    transition: .3s ease;
    height: 38px;
}

#modalTambah .custom-input:focus {
    border-color: #c18b4a;
    box-shadow: 0 0 6px rgba(193,139,74,0.7);
    background: rgba(45,45,45,0.9) !important;
}

#modalTambah .custom-input:hover {
    border-color: #c18b4a;
}

/* Placeholder */
#modalTambah .custom-input::placeholder {
    color: rgba(255,255,255,0.65) !important;
}

/* Input file */
#modalTambah input[type=file] {
    padding: 7px;
}

/* ===== BUTTON SAVE ===== */
#modalTambah .custom-btn-save {
    background: #c18b4a;
    border-radius: 8px;
    padding: 8px 30px;
    font-weight: 600;
    color: #fff;
    transition: .3s;
    border: none;
    font-size: 14px;
}
#modalTambah .custom-btn-save:hover {
    background: #996d39;
}

/* ===== BUTTON CANCEL ===== */
#modalTambah .custom-btn-cancel {
    background: #5b5b5b;
    border-radius: 8px;
    padding: 8px 30px;
    font-weight: 600;
    color: #fff;
    transition: .3s;
    border: none;
    font-size: 14px;
}
#modalTambah .custom-btn-cancel:hover {
    background: #3b3b3b;
}

/* ===== CLOSE BUTTON ===== */
#modalTambah .btn-close {
    filter: invert(100%);
    opacity: .7;
}
#modalTambah .btn-close:hover {
    opacity: 1;
}

/* Perkecil spacing antar form */
#modalTambah .row.g-4 {
    row-gap: 15px !important;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 576px) {
    #modalTambah .custom-btn-save,
    #modalTambah .custom-btn-cancel {
        width: 47%;
    }
}
</style>


<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content custom-modal">

      <!-- Header -->
      <div class="modal-header border-0">
        <h5 class="modal-title">Tambah Menu Baru</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <!-- Form -->
      <form action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Body -->
        <div class="modal-body">
          <div class="row g-4">

            <!-- Nama Menu -->
            <div class="col-md-6">
              <label class="form-label">Nama Menu</label>
              <input type="text" name="nama" class="form-control custom-input" placeholder="Masukkan nama" required>
            </div>

            <!-- Harga -->
            <div class="col-md-6">
              <label class="form-label">Harga</label>
              <input type="number" name="harga" class="form-control custom-input" placeholder="Masukkan harga" required>
            </div>

         <!-- Kategori -->
          <div class="col-md-6">
            <label class="form-label" style="color:#c18b4a;">Kategori</label>
            <select name="kategori" class="form-select shadow-sm" required
                    style="background:#262626; border-radius:10px; border:1px solid #444; color:#fff;">
              <option value="" style="color:#888;">-- Pilih --</option>
              <option value="Makanan" style="color:#fff;">Makanan</option>
              <option value="Minuman" style="color:#fff;">Minuman</option>
            </select>
          </div>

           <!-- Status -->
            <div class="col-md-6">
              <label class="form-label" style="color:#c18b4a;">Status</label>
              <select name="status" class="form-select shadow-sm" required
                      style="background:#262626; border-radius:10px; border:1px solid #444; color:#fff;">
                <option value="Tersedia" style="color:#fff;">Tersedia</option>
                <option value="Habis" style="color:#fff;">Habis</option>
              </select>
            </div>

            <!-- Gambar -->
            <div class="col-12">
              <label class="form-label">Gambar</label>
              <input type="file" name="gambar" class="form-control custom-input">
            </div>

          </div>
        </div>

        <!-- Footer -->
        <div class="modal-footer border-0 pb-3 w-100 d-flex justify-content-center gap-3">
          <button type="button" class="btn custom-btn-cancel" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn custom-btn-save">Simpan</button>
        </div>

      </form>

    </div>
  </div>
</div>