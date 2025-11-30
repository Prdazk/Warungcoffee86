<style>
/* 1. CONTAINER MODAL */
.custom-modal {
    background: #1b1b1b;       /* Latar belakang gelap */
    color: #fff;               /* Teks putih */
    border-radius: 14px;
    border: 1px solid #3a3a3a; /* Garis tepi halus */
    box-shadow: 0 0 20px rgba(0,0,0,0.6);
    overflow: hidden;
    padding-bottom: 10px;
}

#modalTambah .modal-dialog {
    max-width: 650px;
}

/* 2. JUDUL MODAL */
#modalTambah .modal-title {
    font-size: 20px;
    font-weight: 700;
    color: #c18b4a;            /* Warna Emas */
    width: 100%;
    text-align: center;
    letter-spacing: 1px;
    text-transform: uppercase;
}

/* 3. LABEL INPUT */
#modalTambah .form-label {
    color: #c18b4a;            /* Label Emas */
    font-size: 13px;
    margin-bottom: 6px;
    font-weight: 600;
}

/* 4. INPUT TEKS BIASA */
#modalTambah .custom-input {
    background: rgba(30,30,30,0.9) !important;
    border-radius: 8px;
    border: 1px solid #444;
    color: #fff !important;
    padding: 8px 12px;
    font-size: 14px;
    transition: .3s ease;
    height: 40px;
}

/* Efek Fokus pada Input */
#modalTambah .custom-input:focus {
    border-color: #c18b4a;     /* Border jadi Emas saat diketik */
    box-shadow: 0 0 8px rgba(193,139,74,0.4);
    background: rgba(40,40,40,1) !important;
    outline: none;
}

/* Placeholder warna redup */
#modalTambah .custom-input::placeholder {
    color: rgba(255,255,255,0.5) !important;
}

/* 5. KHUSUS INPUT FILE (CHOOSE FILE) - Diperbaiki */
#modalTambah input[type="file"].custom-input {
    padding: 5px;   /* Padding lebih kecil agar tombol muat */
    height: auto;   /* Tinggi menyesuaikan isi */
    display: flex;
    align-items: center;
}

/* Mengubah Tombol "Choose File" jadi Emas */
#modalTambah input[type="file"]::file-selector-button {
    background: #c18b4a;       /* Background Emas */
    border: none;
    color: #fff;               /* Teks Putih */
    padding: 6px 15px;
    border-radius: 6px;
    font-weight: 600;
    margin-right: 12px;
    cursor: pointer;
    transition: .3s;
}

#modalTambah input[type="file"]::file-selector-button:hover {
    background: #d49a55;       /* Emas lebih terang saat hover */
}

/* 6. TOMBOL SAVE (SIMPAN) */
#modalTambah .custom-btn-save {
    background: #c18b4a;
    border-radius: 8px;
    padding: 10px 30px;
    font-weight: 600;
    color: #fff;
    transition: .3s;
    border: none;
    font-size: 14px;
    letter-spacing: 0.5px;
}

#modalTambah .custom-btn-save:hover {
    background: #a67c42;       /* Warna menggelap dikit */
    transform: translateY(-1px);
}

/* 7. TOMBOL CANCEL (BATAL) */
#modalTambah .custom-btn-cancel {
    background: #333;
    border-radius: 8px;
    padding: 10px 30px;
    font-weight: 600;
    color: #bbb;
    transition: .3s;
    border: 1px solid #444;
    font-size: 14px;
}

#modalTambah .custom-btn-cancel:hover {
    background: #444;
    color: #fff;
}

/* 8. TOMBOL SILANG (CLOSE) DI POJOK KANAN ATAS */
#modalTambah .btn-close {
    filter: invert(1) grayscale(100%) brightness(200%); /* Jadi Putih */
    opacity: 0.8;
}
#modalTambah .btn-close:hover {
    opacity: 1;
}

/* LAYOUT SPACING */
#modalTambah .row.g-4 {
    row-gap: 20px !important; /* Jarak antar baris form */
}

/* RESPONSIVE HP */
@media (max-width: 576px) {
    #modalTambah .custom-btn-save,
    #modalTambah .custom-btn-cancel {
        width: 100%;       /* Tombol jadi full width di HP */
        margin-bottom: 10px;
    }
}
</style>

<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content custom-modal">

      <div class="modal-header border-0">
        <h5 class="modal-title">Tambah Menu Baru</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <form action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="modal-body">
          <div class="row g-4">

            <div class="col-md-6">
              <label class="form-label">Nama Menu</label>
              <input type="text" name="nama" class="form-control custom-input" placeholder="Masukkan nama" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">Harga</label>
              <input type="number" name="harga" class="form-control custom-input" placeholder="Masukkan harga" required>
            </div>

            <div class="col-md-6">
              <label class="form-label" style="color:#c18b4a;">Kategori</label>
              <select name="kategori" class="form-select shadow-sm" required
                      style="background:#262626; border-radius:10px; border:1px solid #444; color:#fff;">
                <option value="" style="color:#888;">-- Pilih --</option>
                <option value="Makanan" style="color:#fff;">Makanan</option>
                <option value="Minuman" style="color:#fff;">Minuman</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label" style="color:#c18b4a;">Status</label>
              <select name="status" class="form-select shadow-sm" required
                      style="background:#262626; border-radius:10px; border:1px solid #444; color:#fff;">
                <option value="Tersedia" style="color:#fff;">Tersedia</option>
                <option value="Habis" style="color:#fff;">Habis</option>
              </select>
            </div>

            <div class="col-12">
              <label class="form-label">Gambar</label>
              <input type="file" name="gambar" class="form-control custom-input">
            </div>

          </div>
        </div>

        <div class="modal-footer border-0 pb-3 w-100 d-flex justify-content-center gap-3">
          <button type="button" class="btn custom-btn-cancel" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn custom-btn-save">Simpan</button>
        </div>

      </form>

    </div>
  </div>
</div>