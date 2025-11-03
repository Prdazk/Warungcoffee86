{{-- ================= Modal Tambah Meja ================= --}}
<div class="modal fade" id="tambahMejaModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content shadow-lg border-0 rounded-4 bg-dark text-white">
      
      <div class="modal-header border-0 justify-content-center position-relative">
        <h5 class="modal-title text-warning fw-bold">
          <i class="fas fa-chair me-2"></i> Tambah Meja Baru
        </h5>
        <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3" data-bs-dismiss="modal"></button>
      </div>

      <form id="formTambahMeja" action="{{ route('admin.reservasi.meja.store') }}" method="POST">
        @csrf
        <div class="modal-body px-4 pb-3 d-flex flex-column align-items-center">
          <input type="text" name="nama_meja" class="form-control mb-3 text-center text-white" placeholder="Nama Meja" required
                 style="background:#3a3a3a; border:none; border-radius:8px; height:48px; font-weight:500;">
        </div>

        <div class="modal-footer d-flex justify-content-between flex-wrap px-4 pb-4">
          <button type="button" class="btn btn-secondary btn-hover" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i> Batal
          </button>
          <button type="submit" class="btn btn-warning btn-hover">
            <i class="fas fa-save me-1"></i> Simpan
          </button>
        </div>
      </form>

    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const tambahModalEl = document.getElementById('tambahMejaModal');
    const tambahModal = new bootstrap.Modal(tambahModalEl);

    // Tombol buka modal
    const btnOpen = document.getElementById('btnOpenTambahFlex');
    if(btnOpen) btnOpen.addEventListener('click', () => {
        tambahModal.show();
        // Animate masuk
        tambahModalEl.querySelector('.modal-content').classList.add('animate__animated','animate__fadeInDown');
    });

    // AJAX submit tambah meja
    const form = document.getElementById('formTambahMeja');
    form.addEventListener('submit', function(e){
        e.preventDefault();
        const formData = new FormData(this);
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch(this.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(res => res.json())
        .then(res => {
            if(res.success){
                tambahModal.hide();
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: res.message,
                    timer: 2000,
                    showConfirmButton: false,
                }).then(() => location.reload());
            } else if(res.errors){
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    html: Object.values(res.errors).join('<br>'),
                });
            }
        })
        .catch(err => {
            console.error(err);
            Swal.fire('Error', 'Gagal menambahkan meja. Cek console.', 'error');
        });
    });
});
</script>

<style>
/* Hover animasi tombol */
.btn-hover:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.3);
    transition: all 0.2s ease-in-out;
}

/* Modal body input */
.modal-body input:focus {
    outline: none;
    box-shadow: 0 0 8px #ffc107;
    border: 1px solid #ffc107;
    transition: all 0.3s ease;
}

/* Style tombol */
.btn-warning { background:#c18b4a; border:none; }
.btn-secondary { background:#5b5b5b; border:none; }
</style>
