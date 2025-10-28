<!-- ===== Modal Kelola Meja ===== -->
<div class="modal fade" id="kelolaMejaModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width:1200px;">
    <div class="modal-content shadow-lg rounded-4 border-0" style="background:#3E2723; color:#FFF;">

      <!-- Header -->
      <div class="modal-header border-0 justify-content-center position-relative">
        <h4 class="modal-title fw-semibold text-center" style="color:#ad8572;">Kelola Meja</h4>
        <!-- Tombol X untuk keluar -->
        <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Body: Daftar Meja -->
      <div class="modal-body px-4 pb-4">
        <div class="row g-3" id="daftarMejaKelola">
          @foreach($mejas as $meja)
            <div class="col-sm-6 col-md-4 col-lg-3" id="mejaKelola-{{ $meja->id }}">
              <div class="card text-center shadow-sm" style="background:#6A4827; color:#FFF; border-radius:1rem;">
                <div class="card-body py-3 d-flex flex-column justify-content-between">
                  <h5 class="card-title fw-semibold">{{ $meja->nama_meja }}</h5>
                  <p class="mb-2">Status: 
                    <span class="badge {{ $meja->status_meja == 'Kosong' ? 'bg-success' : 'bg-danger' }}">
                      {{ $meja->status_meja }}
                    </span>
                  </p>

                  <div class="d-flex justify-content-between align-items-center mt-3">
                    <!-- Tombol Tambah -->
                    <button class="btn btn-success btn-sm rounded-pill px-2 py-1" data-bs-toggle="modal" data-bs-target="#tambahMejaModal">
                      <i class="fas fa-plus"></i>
                    </button>

                    <!-- Tombol Hapus -->
                    <button class="btn btn-danger btn-sm rounded-pill px-2 py-1" onclick="hapusMejaKelola({{ $meja->id }})">
                      <i class="fas fa-trash"></i>
                    </button>
                  </div>

                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>

    </div>
  </div>
</div>

<style>
/* ===== Scrollbar Modal Kelola Meja ===== */
#kelolaMejaModal .modal-body::-webkit-scrollbar { width: 8px; }
#kelolaMejaModal .modal-body::-webkit-scrollbar-track { background: #5A4032; border-radius: 4px; }
#kelolaMejaModal .modal-body::-webkit-scrollbar-thumb { background: #8B5E3C; border-radius: 4px; transition: background 0.3s ease; }
#kelolaMejaModal .modal-body::-webkit-scrollbar-thumb:hover { background: #A67C52; }
#kelolaMejaModal .modal-body { scrollbar-width: thin; scrollbar-color: #8B5E3C #5A4032; transition: scrollbar-color 0.3s ease; }
#kelolaMejaModal .modal-body:hover { scrollbar-color: #A67C52 #5A4032; }
</style>

<!-- ===== Modal Tambah Meja ===== -->
<div class="modal fade" id="tambahMejaModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content shadow-lg rounded-4 border-0 text-center" style="background:#4B3621; color:#FFF;">

      <!-- Header -->
      <div class="modal-header border-0 d-flex justify-content-center position-relative">
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
        <div class="modal-footer border-0 d-flex justify-content-center gap-3 pb-4">
          <!-- Tombol Batal: kembali ke Kelola Meja -->
          <button type="button" class="btn px-4 py-2 rounded-3 fw-semibold" 
                  style="background:#D32F2F; color:#FFF; box-shadow:0 4px 10px rgba(0,0,0,0.2);" 
                  id="btnBatalTambahMeja">
            <i class="fas fa-times me-1"></i> Batal
          </button>
          <button type="submit" class="btn px-4 py-2 rounded-3 fw-semibold" 
                  style="background:#8B5E3C; color:#FFF; box-shadow:0 4px 10px rgba(0,0,0,0.2);">
            <i class="fas fa-save me-1"></i> Simpan
          </button>
        </div>
      </form>

    </div>
  </div>
</div>

<!-- ===== JS Kelola Meja ===== -->
<script>
function hapusMejaKelola(id){
  Swal.fire({
    title: 'Apakah yakin?',
    text: "Meja ini akan dihapus permanen!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Ya, hapus!'
  }).then((result) => {
    if(result.isConfirmed){
      fetch(`/admin/reservasi/meja/${id}`, {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Accept': 'application/json'
        }
      })
      .then(res => res.json())
      .then(res => {
        if(res.success){
          document.getElementById('mejaKelola-' + id).remove();
          Swal.fire('Dihapus!', res.message, 'success');
        }
      })
      .catch(err => console.error(err));
    }
  });
}

// Tombol Batal Tambah Meja -> kembali ke Kelola Meja
document.getElementById('btnBatalTambahMeja').addEventListener('click', function() {
    // Tutup modal Tambah Meja
    const tambahModalEl = document.getElementById('tambahMejaModal');
    const tambahModal = bootstrap.Modal.getInstance(tambahModalEl);
    if(tambahModal) tambahModal.hide();

    // Buka modal Kelola Meja
    const kelolaModalEl = document.getElementById('kelolaMejaModal');
    const kelolaModal = new bootstrap.Modal(kelolaModalEl);
    kelolaModal.show();
});
</script>