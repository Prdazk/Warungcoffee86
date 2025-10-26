@extends('admin.layout.app')

@section('content')

@if(session('success'))
  <div id="pesanSukses" data-message="{{ session('success') }}"></div>
@endif

<!-- ===== Area Tombol Aksi & Pencarian ===== -->
<div style="
  margin-bottom:20px; 
  display:flex; 
  justify-content:space-between; 
  align-items:center; 
  flex-wrap:wrap; 
  gap:10px;
">

  <!-- Tombol Tambah Meja -->
  <div>
    <button 
      type="button" 
      class="btn" 
      data-bs-toggle="modal" 
      data-bs-target="#tambahMejaModal"
      style="
        background:#6F4E37; 
        color:white; 
        border:none; 
        padding:10px 20px; 
        border-radius:8px; 
        cursor:pointer; 
        font-size:14px; 
        display:flex; 
        align-items:center; 
        gap:6px; 
        box-shadow:0 2px 5px rgba(0,0,0,0.2);
        transition:all 0.2s ease;
      "
      onmouseover="this.style.background='#5B3E2E'"
      onmouseout="this.style.background='#6F4E37'"
    >
      <i class="fas fa-plus"></i> Tambah Meja
    </button>
  </div>

  <!-- Kolom Pencarian -->
  <div>
    <input 
      type="text" 
      id="searchInput" 
      placeholder="🔍 Cari nama reservasi..."
      style="
        padding:10px 12px; 
        border:1px solid #c4bebe; 
        border-radius:8px; 
        width:260px; 
        font-size:14px; 
        box-shadow:0 2px 5px rgba(0,0,0,0.1); 
        transition:all 0.25s ease; 
        outline:none;
      "
      onfocus="this.style.borderColor='#4CAF50'; this.style.boxShadow='0 3px 8px rgba(76,175,80,0.3)';" 
      onblur="this.style.borderColor='#ccc'; this.style.boxShadow='0 2px 4px rgba(0,0,0,0.1)';"
    >
  </div>

</div>

<!-- ===== Tabel Reservasi ===== -->
<div style="overflow-x:auto; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.1);">
  <table id="reservasiTable" style="width:100%; border-collapse:collapse; font-size:14px;">
    <thead style="background:#6F4E37; color:white;">
      <tr>
        <th style="padding:10px;">No</th>
        <th>Nama</th>
        <th>Jumlah</th>
        <th>Meja</th>
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
          $status = $meja ? $meja->status_meja : 'Kosong';
          $warna = $status === 'Dipesan' ? '#f44336' : '#4CAF50';
        @endphp
        <tr style="text-align:center; border-bottom:1px solid #ddd;">
          <td style="padding:8px;">{{ $index + 1 }}</td>
          <td>{{ $r->nama }}</td>
          <td>{{ $r->jumlah_orang }}</td>
          <td>{{ $meja ? $meja->nama_meja : '-' }}</td>
          <td>
            <span style="background:{{ $warna }}; color:white; padding:4px 8px; border-radius:4px; font-size:12px;">
              {{ $status }}
            </span>
          </td>
          <td>{{ \Carbon\Carbon::parse($r->tanggal)->format('d-m-Y') }}</td>
          <td>{{ $r->jam }}</td>
          <td>
            @if($r->catatan)
              <span class="catatan-pesan-baru">Pesan Baru</span>
            @else
              -
            @endif
          </td>
          <td>
            <div style="display:flex; justify-content:center; gap:8px; flex-wrap:wrap;">

              <!-- Tombol Lihat -->
              <button 
                class="btn-lihat"
                style="background:#2196F3; color:white; border:none; padding:6px 12px; border-radius:6px; cursor:pointer; font-size:13px; display:flex; align-items:center; gap:5px;"
                data-nama="{{ $r->nama }}"
                data-jumlah="{{ $r->jumlah_orang }}"
                data-meja="{{ $meja ? $meja->nama_meja : '-' }}"
                data-status="{{ $status }}"
                data-tanggal="{{ \Carbon\Carbon::parse($r->tanggal)->format('d-m-Y') }}"
                data-jam="{{ $r->jam }}"
                data-catatan="{{ $r->catatan ?? '-' }}"
                data-bs-toggle="modal" data-bs-target="#lihatReservasiModal">
                <i class="fas fa-eye"></i> Lihat
              </button>

              <!-- Tombol Edit -->
              <button 
                class="btn-edit" 
                style="background:#4CAF50; color:white; border:none; padding:6px 12px; border-radius:6px; cursor:pointer; font-size:13px; display:flex; align-items:center; gap:5px;"
                data-id="{{ $r->id }}"
                data-nama="{{ $r->nama }}"
                data-jumlah="{{ $r->jumlah_orang }}"
                data-meja="{{ $meja ? $meja->id : '' }}"
                data-status="{{ $status }}"
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
                <button type="button" class="btn-hapus"
                        style="background:#f44336; color:white; border:none; padding:6px 12px; border-radius:6px; cursor:pointer; font-size:13px; display:flex; align-items:center; gap:5px;">
                  <i class="fas fa-trash"></i> Hapus
                </button>
              </form>

            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="9" style="text-align:center; padding:12px;">Belum ada reservasi masuk</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

<!-- ===== Pagination ===== -->
<div style="
  margin-top:25px; 
  display:flex; 
  justify-content:center; 
  align-items:center; 
  gap:15px;
">
  <button id="prevBtn" style="padding:10px 18px; border-radius:8px; border:none; background:#8D6E63; color:white; cursor:pointer; font-size:14px; font-weight:500; box-shadow:0 3px 6px rgba(0,0,0,0.2); transition:all 0.25s ease;"
    onmouseover="this.style.background='#6F4E37'" onmouseout="this.style.background='#8D6E63'">⬅ Kembali</button>

  <button id="nextBtn" style="padding:10px 18px; border-radius:8px; border:none; background:#8D6E63; color:white; cursor:pointer; font-size:14px; font-weight:500; box-shadow:0 3px 6px rgba(0,0,0,0.2); transition:all 0.25s ease;"
    onmouseover="this.style.background='#6F4E37'" onmouseout="this.style.background='#8D6E63'">Lanjut ➡</button>
</div>

@include('admin.reservasi.modal')
@include('admin.reservasi.tambah')
@include('admin.reservasi.edit')

<style>
@keyframes scaleIn {
  from { transform: scale(0.8); opacity: 0; }
  to { transform: scale(1); opacity: 1; }
}
.catatan-pesan-baru {
  background:#FF9800;
  color:white;
  padding:3px 6px;
  border-radius:4px;
  font-size:12px;
}
</style>

<!-- ===== SweetAlert2 Cantik ===== -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Notifikasi sukses dari session Laravel
document.addEventListener('DOMContentLoaded', () => {
  const pesan = document.getElementById('pesanSukses');
  if (pesan) {
    Swal.fire({
      icon: 'success',
      title: 'Berhasil ✨',
      text: pesan.dataset.message,
      background: 'rgba(255,255,255,0.95)',
      backdrop: `
        rgba(0,0,0,0.4)
        url("https://i.gifer.com/7efs.gif")
        center top
        no-repeat
      `,
      showConfirmButton: false,
      timer: 2000,
      timerProgressBar: true
    });
  }
});

// Konfirmasi Hapus dengan SweetAlert cantik
document.querySelectorAll('.btn-hapus').forEach(btn => {
  btn.addEventListener('click', e => {
    e.preventDefault();
    const form = btn.closest('form');
    Swal.fire({
      title: 'Yakin ingin menghapus?',
      text: 'Data ini akan dihapus permanen.',
      icon: 'warning',
      background: 'rgba(255,255,255,0.95)',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#aaa',
      confirmButtonText: 'Ya, hapus!',
      cancelButtonText: 'Batal',
      backdrop: 'rgba(0,0,0,0.5) blur(4px)'
    }).then(result => {
      if (result.isConfirmed) {
        form.submit();
      }
    });
  });
});
</script>

@endsection
