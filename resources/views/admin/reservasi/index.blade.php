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
        <form action="{{ route('admin.reservasi.destroy', $r->id) }}" method="POST" style="margin:0;">
            @csrf
            @method('DELETE')
            <button 
                type="submit" 
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

<!-- Script pencarian + pagination -->
<script>
const rows = document.querySelectorAll('#reservasiTable tbody tr');
const rowsPerPage = 5;
let currentPage = 1;

// Function tampilkan halaman
function showPage(page){
  const start = (page-1)*rowsPerPage;
  const end = start + rowsPerPage;

  rows.forEach((row, index) => {
    row.style.display = (index >= start && index < end) ? '' : 'none';
  });
}

// Inisialisasi tampilan halaman pertama
showPage(currentPage);

// Tombol Next
document.getElementById('nextBtn').addEventListener('click', () => {
  if(currentPage * rowsPerPage < rows.length){
    currentPage++;
    showPage(currentPage);
  }
});

// Tombol Prev
document.getElementById('prevBtn').addEventListener('click', () => {
  if(currentPage > 1){
    currentPage--;
    showPage(currentPage);
  }
});

// Pencarian real-time
document.getElementById('searchInput').addEventListener('keyup', function() {
  const filter = this.value.toLowerCase();

  rows.forEach(row => {
    const nama = row.cells[1].textContent.toLowerCase();
    if(nama.indexOf(filter) > -1){
      row.style.display = '';
    } else {
      row.style.display = 'none';
    }
  });
});
</script>
@endsection
