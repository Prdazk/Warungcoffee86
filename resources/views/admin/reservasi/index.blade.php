@extends('admin.layout.app')

@section('content')

@if(session('success'))
  <div id="pesanSukses" data-message="{{ session('success') }}"></div>
@endif

<!-- Tombol Kelola Meja -->
<div class="action-bar" style="margin-bottom:20px; display:flex; justify-content:flex-start; align-items:center; flex-wrap:wrap; gap:10px;">
  <!-- Tombol Kelola Meja -->
  <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#kelolaMejaModal">
    <i class="fas fa-cog"></i> Kelola Meja
  </button>
</div>

<!-- Tabel Reservasi -->
<div class="table-wrapper">
  <table id="reservasiTable">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Jumlah</th>
        <th>Status Meja</th>
        <th>Tanggal</th>
        <th>Jam</th>
        <th>Catatan</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($reservasis as $index => $r)
        @php
          $meja = $r->meja;
          $status = $r->status ?? 'Dipesan';
          $warna = $status === 'Dipesan' ? '#f44336' : '#4CAF50';
        @endphp
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $r->nama }}</td>
          <td>{{ $r->jumlah_orang }}</td>
          <td>
            @if($meja)
              {{ $meja->nama_meja }}
              <span class="status-label" style="background:{{ $warna }};">
                {{ $status }}
              </span>
            @else
              -
            @endif
          </td>
          <td>{{ \Carbon\Carbon::parse($r->tanggal)->format('d-m-Y') }}</td>
          <td>{{ $r->jam }}</td>
          <td>@if($r->catatan) <span class="catatan-pesan-baru">Pesan Baru</span> @else - @endif</td>
          <td>
            <div class="aksi-group">
              <!-- Lihat -->
              <button class="btn-lihat" data-bs-toggle="modal" data-bs-target="#lihatReservasiModal"
                data-nama="{{ $r->nama }}" data-jumlah="{{ $r->jumlah_orang }}" data-meja="{{ $meja ? $meja->nama_meja : '-' }}"
                data-tanggal="{{ \Carbon\Carbon::parse($r->tanggal)->format('d-m-Y') }}" data-jam="{{ $r->jam }}"
                data-catatan="{{ $r->catatan ?? '-' }}">
                <i class="fas fa-eye"></i> Lihat
              </button>

              <!-- Edit -->
              <button class="btn-edit" 
                  data-bs-toggle="modal" data-bs-target="#editReservasiModal"
                  data-id="{{ $r->id }}"
                  data-nama="{{ $r->nama }}"
                  data-jumlah="{{ $r->jumlah_orang }}"
                  data-meja="{{ $meja ? $meja->id : '' }}"
                  data-status="{{ $r->status ?? 'Dipesan' }}"
                  data-tanggal="{{ $r->tanggal }}"
                  data-jam="{{ $r->jam }}"
                  data-catatan="{{ $r->catatan ?? '' }}">
                  <i class="fas fa-edit"></i> Edit
              </button>

              <!-- Hapus -->
              <form action="{{ route('admin.reservasi.destroy', $r->id) }}" method="POST" class="hapusForm">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-hapus">
                  <i class="fas fa-trash"></i> Hapus
                </button>
              </form>
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="8" class="text-center">Belum ada reservasi masuk</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

<!-- Pagination -->
<div class="pagination-wrapper">
  <button id="prevBtn">⬅ Kembali</button>
  <button id="nextBtn">Lanjut ➡</button>
</div>

@include('admin.reservasi.modal')
@include('admin.reservasi.edit')
@include('admin.reservasi.kelola')

<style>
.table-wrapper { overflow-x:auto; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.1); }
#reservasiTable { width:100%; border-collapse:collapse; font-size:14px; }
#reservasiTable th { background:#6F4E37; color:white; padding:10px; }
#reservasiTable td { text-align:center; padding:8px; border-bottom:1px solid #ddd; }

.status-label { color:white; padding:4px 8px; border-radius:4px; font-size:12px; margin-left:6px; }
.catatan-pesan-baru { background:#FF9800; color:white; padding:3px 6px; border-radius:4px; font-size:12px; }

.aksi-group { display:flex; justify-content:center; gap:8px; flex-wrap:wrap; }
.btn-lihat { background:#2196F3; color:white; border:none; padding:6px 12px; border-radius:6px; cursor:pointer; font-size:13px; display:flex; align-items:center; gap:5px; }
.btn-edit { background:#4CAF50; color:white; border:none; padding:6px 12px; border-radius:6px; cursor:pointer; font-size:13px; display:flex; align-items:center; gap:5px; }
.btn-hapus { background:#f44336; color:white; border:none; padding:6px 12px; border-radius:6px; cursor:pointer; font-size:13px; display:flex; align-items:center; gap:5px; }

.btn-tambah { background:#6F4E37; color:white; border:none; padding:10px 20px; border-radius:8px; cursor:pointer; font-size:14px; display:flex; align-items:center; gap:6px; box-shadow:0 2px 5px rgba(0,0,0,0.2); transition:all 0.2s ease; }
.btn-tambah:hover { background:#5B3E2E; }

.search-input { padding:10px 12px; border:1px solid #c4bebe; border-radius:8px; width:260px; font-size:14px; box-shadow:0 2px 5px rgba(0,0,0,0.1); outline:none; transition:all 0.25s ease; }
.search-input:focus { border-color:#4CAF50; box-shadow:0 3px 8px rgba(76,175,80,0.3); }

.pagination-wrapper { margin-top:25px; display:flex; justify-content:center; align-items:center; gap:15px; }
.pagination-wrapper button { padding:10px 18px; border-radius:8px; border:none; background:#8D6E63; color:white; cursor:pointer; font-size:14px; font-weight:500; box-shadow:0 3px 6px rgba(0,0,0,0.2); transition:all 0.25s ease; }
.pagination-wrapper button:hover { background:#6F4E37; }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  // Notifikasi sukses
  const pesan = document.getElementById('pesanSukses');
  if(pesan){
    Swal.fire({
      icon:'success',
      title:'Berhasil ✨',
      text: pesan.dataset.message,
      background:'rgba(255,255,255,0.95)',
      backdrop:`rgba(0,0,0,0.4) url("https://i.gifer.com/7efs.gif") center top no-repeat`,
      showConfirmButton:false,
      timer:2000,
      timerProgressBar:true
    });
  }

  // Konfirmasi Hapus
  document.querySelectorAll('.hapusForm').forEach(form => {
    const btn = form.querySelector('.btn-hapus');
    btn.addEventListener('click', e => {
      e.preventDefault();
      Swal.fire({
        title:'Yakin ingin menghapus?',
        text:'Data ini akan dihapus permanen.',
        icon:'warning',
        showCancelButton:true,
        confirmButtonColor:'#d33',
        cancelButtonColor:'#aaa',
        confirmButtonText:'Ya, hapus!',
        cancelButtonText:'Batal',
      }).then(result => {
        if(result.isConfirmed){
          form.submit();
        }
      });
    });
  });
});
</script>

@endsection
