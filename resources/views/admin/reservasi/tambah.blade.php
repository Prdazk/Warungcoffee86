<div class="modal fade" id="tambahMejaModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content shadow-lg border-0 rounded-4 bg-dark text-white">

      <div class="modal-header border-0 justify-content-center position-relative">
        <h5 class="modal-title text-warning fw-bold">
          Tambah Meja Baru
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

          <button type="button" class="btn btn-info btn-hover" data-bs-toggle="modal" data-bs-target="#kelolaMejaModal">
            <i class="fas fa-cog me-1"></i> Kelola Meja
          </button>

          <button type="submit" class="btn btn-warning btn-hover">
            <i class="fas fa-save me-1"></i> Simpan
          </button>
        </div>
      </form>

    </div>
  </div>
</div>


<div class="modal fade" id="kelolaMejaModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow-lg border-0 rounded-4 bg-dark text-white">

      {{-- Header Modal --}}
      <div class="modal-header border-0 justify-content-center position-relative">

        <h5 class="modal-title text-info fw-bold">Kelola Meja</h5>

        <!-- Tombol Kembali di kiri → membuka modal Tambah Meja -->
        <button type="button" class="btn btn-outline-light btn-sm position-absolute start-0 ms-3"
                data-bs-toggle="modal" data-bs-target="#tambahMejaModal"
                data-bs-dismiss="modal">
          Kembali
        </button>

        <!-- Tombol X di kanan -->
        <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3" data-bs-dismiss="modal"></button>

      </div>

      {{-- Body Modal --}}
      <div class="modal-body px-4 pb-3">
        <div class="meja-scroll d-flex gap-3">
          @foreach($mejas as $m)
            <div id="rowMeja{{ $m->id }}" class="meja-card">
              <span class="meja-text">{{ $m->nama_meja }}</span>
              <button type="button" class="btn btn-danger btn-sm btnHapusMeja" data-id="{{ $m->id }}">
                <i class="fas fa-trash"></i>
              </button>
            </div>
          @endforeach
        </div>
      </div>

    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {

    // === Modal Tambah Meja ===
    const tambahModalEl = document.getElementById('tambahMejaModal');
    const tambahModal = new bootstrap.Modal(tambahModalEl);
    const btnOpen = document.getElementById('btnOpenTambahFlex');

    if (btnOpen) {
        btnOpen.addEventListener('click', () => {
            tambahModal.show();
            tambahModalEl.querySelector('.modal-content').classList.add('animate__animated','animate__fadeInDown');
        });
    }

    // === AJAX Simpan Meja Baru ===
    const form = document.getElementById('formTambahMeja');
    form.addEventListener('submit', function(e){
        e.preventDefault();
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
        .then(async response => {
            let res;
            try {
                res = await response.json();
            } catch (err) {
                Swal.fire('Error', 'Server tidak merespon JSON', 'error');
                return;
            }

            if(response.ok && res.success){
                form.reset();
                Swal.fire({
                    icon:'success',
                    title:'Berhasil!',
                    text: res.message ?? 'Meja baru berhasil ditambahkan',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    tambahModal.hide(); // tutup modal
                    location.reload();
                });
            } else {
                // validasi gagal
                let msg = res.message ?? 'Terjadi kesalahan';
                if(res.errors){
                    msg = Object.values(res.errors).flat().join('\n');
                }
                Swal.fire('Gagal', msg, 'error');
            }
        })
        .catch(err => {
            console.error(err);
            Swal.fire('Error', 'Koneksi gagal. Silakan coba lagi', 'error');
        });
    });


    // === Hapus Meja tanpa reload ===
    document.querySelectorAll('.btnHapusMeja').forEach(btn => {
        btn.addEventListener('click', function(){
            const id = this.dataset.id;

            Swal.fire({
                icon:'warning',
                title:'Hapus meja ini?',
                showCancelButton:true
            }).then(result => {
                if(result.isConfirmed){
                    fetch(`/admin/reservasi/meja/${id}`, {
                        method:'DELETE',
                        headers:{
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(r => r.json())
                    .then(res => {
                        if(res.success){
                            document.getElementById('rowMeja'+id).remove();
                            Swal.fire({ icon:'success', title:'Terhapus', timer:1200, showConfirmButton:false });
                        }
                    });
                }
            });
        });
    });

});
</script>


{{-- ================= Style Modal & Meja ================= --}}
<style>
/* Efek tombol hover */
.btn-hover:hover { 
  transform: translateY(-2px); 
  box-shadow:0 4px 8px rgba(0,0,0,0.3); 
  transition:.2s; 
}

/* Warna tombol */
.btn-warning { background:#c18b4a; border:none; }
.btn-secondary { background:#5b5b5b; border:none; }
.btn-info { background:#2779a7; border:none; }
.btn-info:hover { background:#2d93c8; }

/* Input fokus */
.modal-body input:focus { 
  outline:none; 
  box-shadow:0 0 8px #ffc107; 
  border:1px solid #ffc107; 
  transition:.3s; 
}

/* Scroll horizontal untuk meja */
.meja-scroll {
  overflow-x: auto;
  white-space: nowrap;
  padding-bottom: 8px;
}

/* Kotak meja (lebih kecil) */
.meja-card {
  display: inline-block;
  background: linear-gradient(145deg, #1e1e1e, #2b2b2b);
  border-radius: 14px;
  padding: 12px 15px; /* lebih kecil */
  min-width: 150px;   /* sebelumnya 200px */
  height: 90px;       /* sebelumnya 120px */
  text-align: center;
  border: 1px solid #3e3e3e;
  position: relative;
  transition: 0.25s ease;
}

/* Efek hover pada meja */
.meja-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 0 10px rgba(255, 193, 7, 0.5);
  border-color: #ffc107;
}

/* Teks nama meja */
.meja-text {
  font-weight: 700;
  font-size: 16px; /* sebelumnya 20px */
  color: #ffffff;
  margin-top: 5px;
}

/* Tombol hapus meja di tengah bawah */
.meja-card .btnHapusMeja {
  position: absolute;
  bottom: 6px;
  left: 50%;
  transform: translateX(-50%);
  padding: 3px 6px; /* tetap kecil */
}


/* Scrollbar gelap */
.meja-scroll::-webkit-scrollbar { height: 8px; }
.meja-scroll::-webkit-scrollbar-track { background: #1a1a1a; border-radius: 10px; }
.meja-scroll::-webkit-scrollbar-thumb { background: #444; border-radius: 10px; }
.meja-scroll::-webkit-scrollbar-thumb:hover { background: #666; }
</style>