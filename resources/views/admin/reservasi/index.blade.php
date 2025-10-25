@extends('admin.layout.app')

@section('content')

@if(session('success'))
  <div id="pesanSukses">{{ session('success') }}</div>
@endif

<!-- ===== Kolom Pencarian & Tombol Tambah Meja ===== -->
<div style="margin-bottom:15px; display:flex; justify-content:space-between; align-items:center;">

  <!-- Tombol Tambah Meja -->
  <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#tambahMejaModal"
          style="background:#6F4E37; color:white; border:none; padding:6px 16px; border-radius:6px; cursor:pointer; font-size:14px;">
    <i class="fas fa-plus me-1"></i> Tambah Meja
  </button>

  <!-- Pencarian -->
  <input 
    type="text" 
    id="searchInput" 
    placeholder="Cari nama..." 
    style="padding:6px 10px; border:1px solid #beb5b5; border-radius:6px; width:220px; font-size:14px; box-shadow:0 1px 3px rgba(0,0,0,0.1); transition:all 0.2s ease; outline:none;" 
    onfocus="this.style.borderColor='#4CAF50'; this.style.boxShadow='0 2px 6px rgba(76,175,80,0.3)';" 
    onblur="this.style.borderColor='#ccc'; this.style.boxShadow='0 1px 3px rgba(0,0,0,0.1)';">
</div>

<!-- ===== Tabel Reservasi ===== -->
<table id="reservasiTable" style="width:100%; border-collapse:collapse;">
  <thead>
    <tr>
      <th>No</th>
      <th>Nama</th>
      <th>Jumlah</th>
      <th>Meja</th>
      <th>Tanggal</th>
      <th>Jam</th>
      <th>Catatan</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    @forelse ($reservasis as $index => $r)
      <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $r->nama }}</td>
        <td>{{ $r->jumlah_orang }}</td>
        <td>{{ $r->pilihan_meja }}</td>
        <td>{{ \Carbon\Carbon::parse($r->tanggal)->format('d-m-Y') }}</td>
        <td>{{ $r->jam }}</td>
        <td>@if($r->catatan) <span class="catatan-pesan-baru">Pesan Baru</span> @else - @endif</td>
        <td>
          <div style="display:flex; justify-content:center; gap:8px; align-items:center;">
            
            <!-- Tombol Lihat -->
            <button 
              class="btn-lihat" 
              style="background:#2196F3; color:white; border:none; padding:6px 12px; border-radius:6px; cursor:pointer; font-size:13px; display:flex; align-items:center; gap:5px; box-shadow:0 2px 4px rgba(0,0,0,0.2);"
              data-nama="{{ $r->nama }}"
              data-jumlah="{{ $r->jumlah_orang }}"
              data-meja="{{ $r->pilihan_meja }}"
              data-tanggal="{{ \Carbon\Carbon::parse($r->tanggal)->format('d-m-Y') }}"
              data-jam="{{ $r->jam }}"
              data-catatan="{{ $r->catatan ?? '-' }}"
              data-bs-toggle="modal" data-bs-target="#lihatReservasiModal">
              <i class="fas fa-eye"></i> Lihat
            </button>

            <!-- Tombol Edit -->
            <button 
              class="btn-edit" 
              style="background:#4CAF50; color:white; border:none; padding:6px 12px; border-radius:6px; cursor:pointer; font-size:13px; display:flex; align-items:center; gap:5px; box-shadow:0 2px 4px rgba(0,0,0,0.2);"
              data-id="{{ $r->id }}"
              data-nama="{{ $r->nama }}"
              data-jumlah="{{ $r->jumlah_orang }}"
              data-meja="{{ $r->pilihan_meja }}"
              data-tanggal="{{ $r->tanggal }}"
              data-jam="{{ $r->jam }}"
              data-catatan="{{ $r->catatan ?? '' }}"
              data-bs-toggle="modal" data-bs-target="#editReservasiModal">
              <i class="fas fa-edit"></i> Edit
            </button>

            <!-- Tombol Hapus -->
            <form action="{{ route('admin.reservasi.destroy', $r->id) }}" method="POST" class="hapusForm" style="margin:0;">
                @csrf
                @method('DELETE')
                <button 
                    type="button" 
                    class="btn-hapus"
                    style="background:#f44336; color:white; border:none; padding:6px 12px; border-radius:6px; cursor:pointer; font-size:13px; display:flex; align-items:center; gap:5px; box-shadow:0 2px 4px rgba(0,0,0,0.2);">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </form>

          </div>
        </td>
      </tr>
    @empty
      <tr><td colspan="8" style="text-align:center;">Belum ada reservasi masuk</td></tr>
    @endforelse
  </tbody>
</table>

<!-- Tombol Pagination -->
<div style="margin-top:10px; display:flex; justify-content:center; gap:10px;">
  <button id="prevBtn" style="padding:6px 12px; border-radius:6px; border:none; background:#795548; color:white; cursor:pointer;">kembali</button>
  <button id="nextBtn" style="padding:6px 12px; border-radius:6px; border:none; background:#795548; color:white; cursor:pointer;">lanjut</button>
</div>

{{-- Modal Tambah Meja --}}
<div class="modal fade" id="tambahMejaModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content shadow-lg rounded-4" style="overflow:hidden; border:none;">
      <div class="modal-header" style="background:#4B3621; color:#FFF; border-bottom:none; padding:15px 20px;">
        <h5 class="modal-title" style="font-weight:600; font-size:18px; display:flex; align-items:center; gap:10px;">
          <i class="fas fa-chair"></i> Tambah Meja
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <form action="{{ route('admin.reservasi.meja.store') }}" method="POST">
        @csrf
        <div class="modal-body" style="background:#6B4B32; padding:30px; display:flex; flex-direction:column; gap:15px; align-items:center;">
          <label class="form-label" style="color:#FFF; font-weight:500; width:100%;">Nama Meja</label>
          <input type="text" name="nama_meja" class="form-control" required 
                 placeholder="Masukkan nama meja"
                 style="background:#815b3b; color:#FFF; border:none; padding:12px 15px; border-radius:10px; font-size:14px; width:100%; max-width:300px;">
        </div>

        <div class="modal-footer" style="display:flex; justify-content:center; gap:20px; background:#6B4B32; border-top:none; padding:20px 0;">
          <button type="button" class="btn" data-bs-dismiss="modal" 
                  style="background:#8B5E3C; color:#FFF; border:none; padding:10px 28px; border-radius:10px; font-weight:500; transition:0.2s; box-shadow:0 2px 5px rgba(0,0,0,0.2);">
            Batal
          </button>
          <button type="submit" class="btn" 
                  style="background:#6F4E37; color:#FFF; border:none; padding:10px 28px; border-radius:10px; font-weight:500; transition:0.2s; box-shadow:0 2px 5px rgba(0,0,0,0.2);">
            Simpan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Modal Edit Reservasi --}}
<div class="modal fade" id="editReservasiModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow-lg rounded-4" style="background:#4B3621; color:#FFF;">
      <div class="modal-header border-0">
        <h5 class="modal-title"><i class="fas fa-edit"></i> Edit Reservasi</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form id="editReservasiForm" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Nama</label>
              <input type="text" name="nama" id="editNama" class="form-control" required style="background:#815b3b; color:#FFF; border:none;">
            </div>
            <div class="col-md-6">
              <label class="form-label">Jumlah Orang</label>
              <input type="number" name="jumlah_orang" id="editJumlah" class="form-control" required style="background:#815b3b; color:#FFF; border:none;">
            </div>
            <div class="col-md-6">
              <label class="form-label">Meja</label>
              <input type="text" name="pilihan_meja" id="editMeja" class="form-control" required style="background:#815b3b; color:#FFF; border:none;">
            </div>
            <div class="col-md-6">
              <label class="form-label">Tanggal</label>
              <input type="date" name="tanggal" id="editTanggal" class="form-control" required style="background:#815b3b; color:#FFF; border:none;">
            </div>
            <div class="col-md-6">
              <label class="form-label">Jam</label>
              <input type="time" name="jam" id="editJam" class="form-control" required style="background:#815b3b; color:#FFF; border:none;">
            </div>
            <div class="col-md-6">
              <label class="form-label">Catatan</label>
              <textarea name="catatan" id="editCatatan" class="form-control" rows="3" style="background:#815b3b; color:#FFF; border:none;"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

@include('admin.reservasi.modal')

<!-- Popup Konfirmasi Hapus -->
<div id="confirmPopup" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); justify-content:center; align-items:center; z-index:9999;">
  <div style="background:white; padding:25px; border-radius:12px; text-align:center; box-shadow:0 4px 10px rgba(0,0,0,0.3); animation:scaleIn 0.25s ease;">
    <h3 style="margin-bottom:15px; color:#333;">Konfirmasi Hapus</h3>
    <p style="margin-bottom:20px; color:#555;">Apakah Anda yakin ingin menghapus data ini?</p>
    <div style="display:flex; justify-content:center; gap:12px;">
      <button id="batalHapus" style="background:#9e9e9e; color:white; border:none; padding:8px 16px; border-radius:8px; cursor:pointer;">Batal</button>
      <button id="yakinHapus" style="background:#f44336; color:white; border:none; padding:8px 16px; border-radius:8px; cursor:pointer;">Yakin</button>
    </div>
  </div>
</div>

<style>
@keyframes scaleIn {
  from { transform: scale(0.8); opacity: 0; }
  to { transform: scale(1); opacity: 1; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {

  // ===== Pagination =====
  const rows = document.querySelectorAll('#reservasiTable tbody tr');
  const rowsPerPage = 5;
  let currentPage = 1;
  function showPage(page) {
    const start = (page - 1) * rowsPerPage;
    const end = start + rowsPerPage;
    rows.forEach((row, index) => {
      row.style.display = (index >= start && index < end) ? '' : 'none';
    });
  }
  showPage(currentPage);
  document.getElementById('nextBtn').addEventListener('click', () => {
    if (currentPage * rowsPerPage < rows.length) { currentPage++; showPage(currentPage); }
  });
  document.getElementById('prevBtn').addEventListener('click', () => {
    if (currentPage > 1) { currentPage--; showPage(currentPage); }
  });

  // ===== Pencarian =====
  const searchInput = document.getElementById('searchInput');
  searchInput.addEventListener('keyup', function() {
    const filter = this.value.toLowerCase();
    rows.forEach(row => {
      const nama = row.cells[1].textContent.toLowerCase();
      row.style.display = nama.includes(filter) ? '' : 'none';
    });
  });

  // ===== Popup Konfirmasi Hapus =====
  let formToSubmit = null;
  const popup = document.getElementById('confirmPopup');
  const batalBtn = document.getElementById('batalHapus');
  const yakinBtn = document.getElementById('yakinHapus');
  document.querySelectorAll('.btn-hapus').forEach(btn => {
    btn.addEventListener('click', e => {
      e.preventDefault();
      formToSubmit = btn.closest('form');
      popup.style.display = 'flex';
    });
  });
  batalBtn.addEventListener('click', () => { popup.style.display = 'none'; formToSubmit = null; });
  yakinBtn.addEventListener('click', () => { if (formToSubmit) formToSubmit.submit(); });

  // ===== Modal Edit =====
  document.querySelectorAll('.btn-edit').forEach(btn => {
    btn.addEventListener('click', () => {
      document.getElementById('editReservasiForm').action = `/admin/reservasi/${btn.dataset.id}`;
      document.getElementById('editNama').value = btn.dataset.nama;
      document.getElementById('editJumlah').value = btn.dataset.jumlah;
      document.getElementById('editMeja').value = btn.dataset.meja;
      document.getElementById('editTanggal').value = btn.dataset.tanggal;
      document.getElementById('editJam').value = btn.dataset.jam;
      document.getElementById('editCatatan').value = btn.dataset.catatan;
    });
  });

  // ===== Modal Lihat Reservasi =====
  const lihatModal = document.getElementById('modalLihatReservasi');
  const lihatContent = document.getElementById('modalContent');
  const closeModalBtn = document.getElementById('closeModalBtn');

  document.querySelectorAll('.btn-lihat').forEach(btn => {
    btn.addEventListener('click', () => {
      // Isi data
      document.getElementById('detail-nama').textContent = btn.dataset.nama;
      document.getElementById('detail-jumlah').textContent = btn.dataset.jumlah;
      document.getElementById('detail-meja').textContent = btn.dataset.meja;
      document.getElementById('detail-tanggal').textContent = btn.dataset.tanggal;
      document.getElementById('detail-jam').textContent = btn.dataset.jam;
      document.getElementById('detail-catatan').textContent = btn.dataset.catatan;

      // Tampilkan modal
      lihatModal.style.display = 'flex';
      setTimeout(() => {
        lihatContent.style.transform = 'scale(1)';
        lihatContent.style.opacity = '1';
      }, 10);
    });
  });

  // Tutup modal Lihat
  closeModalBtn.addEventListener('click', () => {
    lihatContent.style.transform = 'scale(0.8)';
    lihatContent.style.opacity = '0';
    setTimeout(() => { lihatModal.style.display = 'none'; }, 300);
  });

  // Tutup modal jika klik di luar konten
  lihatModal.addEventListener('click', (e) => {
    if (e.target === lihatModal) {
      lihatContent.style.transform = 'scale(0.8)';
      lihatContent.style.opacity = '0';
      setTimeout(() => { lihatModal.style.display = 'none'; }, 300);
    }
  });

});
</script>

@endsection
