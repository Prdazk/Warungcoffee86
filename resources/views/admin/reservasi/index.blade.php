@extends('admin.layout.app')

@section('content')

@if(session('success'))
  <div id="pesanSukses">{{ session('success') }}</div>
@endif

<!-- ===== Kolom Pencarian ===== -->
<div style="margin-bottom:15px; display:flex; justify-content:flex-end;">
  <input 
    type="text" 
    id="searchInput" 
    placeholder="Cari nama..." 
    style="padding:6px 10px; border:1px solid #ccc; border-radius:6px; width:250px;">
</div>

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
        <td>
          @if($r->catatan)
            <span class="catatan-pesan-baru">Pesan Baru</span>
          @else
            -
          @endif
        </td>
        <td class="aksi" style="display:flex; gap:6px;">

          <!-- Tombol Lihat -->
          <button 
            class="btn-lihat" 
            style="background:#2196F3; color:white; border:none; padding:6px 12px; border-radius:6px; cursor:pointer; font-size:13px; display:flex; align-items:center; gap:5px; box-shadow:0 2px 4px rgba(0,0,0,0.2);"
            data-nama="{{ $r->nama }}"
            data-jumlah="{{ $r->jumlah_orang }}"
            data-meja="{{ $r->pilihan_meja }}"
            data-tanggal="{{ \Carbon\Carbon::parse($r->tanggal)->format('d-m-Y') }}"
            data-jam="{{ $r->jam }}"
            data-catatan="{{ $r->catatan ?? '-' }}">
            <i class="fas fa-eye"></i> Lihat
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

{{-- Modal untuk detail reservasi --}}
@include('admin.reservasi.modal')

{{-- File JS --}}
<script src="{{ asset('js/admin/reservasi_modal.js') }}"></script>

<!-- ===== Konfirmasi Popup Hapus ===== -->
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
const rows = document.querySelectorAll('#reservasiTable tbody tr');
const rowsPerPage = 5;
let currentPage = 1;

// Pagination
function showPage(page){
  const start = (page-1)*rowsPerPage;
  const end = start + rowsPerPage;
  rows.forEach((row, index) => {
    row.style.display = (index >= start && index < end) ? '' : 'none';
  });
}
showPage(currentPage);

document.getElementById('nextBtn').addEventListener('click', () => {
  if(currentPage * rowsPerPage < rows.length){ currentPage++; showPage(currentPage); }
});
document.getElementById('prevBtn').addEventListener('click', () => {
  if(currentPage > 1){ currentPage--; showPage(currentPage); }
});

// Pencarian
document.getElementById('searchInput').addEventListener('keyup', function() {
  const filter = this.value.toLowerCase();
  rows.forEach(row => {
    const nama = row.cells[1].textContent.toLowerCase();
    row.style.display = nama.includes(filter) ? '' : 'none';
  });
});

// Popup konfirmasi hapus
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

batalBtn.addEventListener('click', () => {
  popup.style.display = 'none';
  formToSubmit = null;
});

yakinBtn.addEventListener('click', () => {
  if(formToSubmit) formToSubmit.submit();
});
</script>

@endsection