<!-- ===== Modal Tambah Meja ===== -->
<div class="modal fade" id="tambahMejaModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content" style="background:#2b2b2b; border:1px solid #3a3a3a; border-radius:14px; color:#FFF; text-align:center;">

      <!-- Header -->
      <div class="modal-header border-0 d-flex justify-content-center position-relative">
        <h5 class="modal-title" style="color:#c18b4a; font-weight:700; width:100%;">
          <i class="fas fa-chair me-2"></i> Tambah Meja Baru
        </h5>
        <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3" data-bs-dismiss="modal"></button>
      </div>

      <!-- Form -->
      <form id="formTambahMeja" action="{{ route('admin.reservasi.meja.store') }}" method="POST">
        @csrf
        <div class="modal-body px-4 pb-3 d-flex flex-column align-items-center justify-content-center">

          <!-- Input Nama Meja -->
          <div class="w-75 mb-4">
            <label class="form-label" style="color:#c18b4a; font-weight:500; display:block; text-align:center; margin-bottom:0.5rem;">
              Nama Meja
            </label>
            <input type="text" name="nama_meja" class="form-control" placeholder="Masukkan nama meja" required
                   style="background:#3a3a3a; color:#fff; border:none; border-radius:6px; height:48px; text-align:center; font-weight:500;">
          </div>

          <!-- Tombol sejajar: Batal kiri | Kelola tengah | Simpan kanan -->
          <div class="d-flex w-100 px-4 justify-content-between flex-wrap">
            <button type="button" class="btn" id="btnBatalTambahMejaFlex"
                    style="background:#5b5b5b; color:#fff; padding:8px 20px; border-radius:6px; font-weight:500;">
              <i class="fas fa-times me-1"></i> Batal
            </button>

            <button type="button" class="btn" id="btnLihatKelolaFlex"
                    style="background:#c18b4a; color:#fff; padding:8px 20px; border-radius:6px; font-weight:500;">
              <i class="fas fa-cog me-1"></i> Kelola
            </button>

            <button type="submit" class="btn"
                    style="background:#c18b4a; color:#fff; padding:8px 20px; border-radius:6px; font-weight:500;">
              <i class="fas fa-save me-1"></i> Simpan
            </button>
          </div>

        </div>
      </form>
    </div>
  </div>
</div>

<!-- ===== Modal Kelola Meja (Percantik Tipis & Fungsi Tombol) ===== -->
<div class="modal fade" id="kelolaMejaModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width:1200px;">
    <div class="modal-content" style="background:#2b2b2b; border:1px solid #3a3a3a; border-radius:16px; color:#FFF; box-shadow: 0 8px 20px rgba(0,0,0,0.5);">

      <!-- Header -->
      <div class="modal-header border-0 d-flex justify-content-between align-items-center">
        <!-- Tombol Kembali -->
        <button type="button" class="btn btn-secondary btn-sm d-flex align-items-center" style="padding:0.3rem 0.6rem; height:32px; border-radius:8px; background:#3a3a3a; border:none;" id="btnKembaliTambahTopFlex">
          <i class="fas fa-arrow-left me-1"></i> <span style="line-height:1;">Kembali</span>
        </button>

        <!-- Judul -->
        <h4 class="modal-title text-center flex-grow-1" style="color:#c18b4a; margin:0; font-weight:700; text-shadow:1px 1px 4px rgba(0,0,0,0.5);">
          Kelola Meja
        </h4>

        <!-- Tombol X -->
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Body -->
      <div class="modal-body px-4 pb-4">
        <div class="row g-3 justify-content-center" id="daftarMejaKelola">
          @foreach($mejas as $meja)
            <div class="col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center" id="mejaKelola-{{ $meja->id }}">
              <div class="card text-center shadow-sm" style="background: linear-gradient(145deg, #3b3b3b, #4b4b4b); color:#FFF; border-radius:1rem; width:130px; transition: transform 0.3s, box-shadow 0.3s;">
                <div class="card-body py-3 d-flex flex-column justify-content-between align-items-center">
                  <h5 class="card-title fw-semibold mb-2" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.4);">{{ $meja->nama_meja }}</h5>
                  <button class="btn btn-danger btn-sm rounded-pill px-2 py-1 w-100" onclick="hapusMejaKelola({{ $meja->id }})" title="Hapus" style="transition: all 0.2s; box-shadow:0 3px 10px rgba(0,0,0,0.3);">
                    <i class="fas fa-trash me-1"></i> Hapus
                  </button>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>

    </div>
  </div>
</div>

<script>
  // Tombol Buka Modal Tambah Meja
  const btnOpenTambahFlex = document.getElementById('btnOpenTambahFlex');
  if(btnOpenTambahFlex){
    btnOpenTambahFlex.addEventListener('click', function(){
      const tambahModal = new bootstrap.Modal(document.getElementById('tambahMejaModal'));
      tambahModal.show();
    });
  }

  // Tombol Lihat Kelola → tutup Tambah → buka Kelola
  const btnLihatKelolaFlex = document.getElementById('btnLihatKelolaFlex');
  btnLihatKelolaFlex.addEventListener('click', function(){
    const tambahModalEl = document.getElementById('tambahMejaModal');
    const tambahModal = bootstrap.Modal.getInstance(tambahModalEl) || new bootstrap.Modal(tambahModalEl);
    tambahModal.hide();

    const kelolaModal = new bootstrap.Modal(document.getElementById('kelolaMejaModal'));
    kelolaModal.show();
  });

  // Tombol Kembali → tutup Kelola → buka Tambah
  const btnKembali = document.getElementById('btnKembaliTambahTopFlex');
  btnKembali.addEventListener('click', function(){
    const kelolaModalEl = document.getElementById('kelolaMejaModal');
    const kelolaModal = bootstrap.Modal.getInstance(kelolaModalEl) || new bootstrap.Modal(kelolaModalEl);
    kelolaModal.hide();

    const tambahModal = new bootstrap.Modal(document.getElementById('tambahMejaModal'));
    tambahModal.show();
  });

  // Tombol Batal Tambah
  const btnBatalTambah = document.getElementById('btnBatalTambahMejaFlex');
  btnBatalTambah.addEventListener('click', function(){
    const modalEl = document.getElementById('tambahMejaModal');
    const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
    modal.hide();
  });

  // Submit Tambah Meja via AJAX
  const formTambah = document.getElementById('formTambahMeja');
  formTambah.addEventListener('submit', function(e){
    e.preventDefault();
    const formData = new FormData(this);

    fetch(this.action, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Accept': 'application/json'
      },
      body: formData
    })
    .then(res => res.json())
    .then(res => {
      if(res.success){
        tambahMejaBaru(res.data.id, res.data.nama_meja, res.data.status_meja);
        this.reset();
        Swal.fire('Berhasil!', res.message, 'success');
      }
    })
    .catch(err => console.error(err));
  });

  // Fungsi hapus meja
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
            const el = document.getElementById('mejaKelola-' + id);
            if(el) el.remove();
            Swal.fire('Dihapus!', res.message, 'success');
          }
        })
        .catch(err => console.error(err));
      }
    });
  }

  // Tambah meja baru ke modal Kelola
  function tambahMejaBaru(id, nama, status='Kosong'){
    const daftar = document.getElementById('daftarMejaKelola');
    const div = document.createElement('div');
    div.className = 'col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center';
    div.id = 'mejaKelola-' + id;
    div.innerHTML = `
      <div class="card text-center shadow-sm" style="background:#3a3a3a; color:#FFF; border-radius:1rem; width:120px;">
        <div class="card-body py-3 d-flex flex-column justify-content-between align-items-center">
          <h5 class="card-title fw-semibold mb-2">${nama}</h5>
          <p class="mb-2">Status: <span class="badge ${status === 'Kosong' ? 'bg-success' : 'bg-danger'}">${status}</span></p>
          <button class="btn btn-danger btn-sm rounded-pill px-2 py-1 mt-2 w-100" onclick="hapusMejaKelola(${id})">
            <i class="fas fa-trash me-1"></i> Hapus
          </button>
        </div>
      </div>
    `;
    daftar.appendChild(div);
  }
</script>
