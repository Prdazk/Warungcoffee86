@extends('admin.layout.app')

@section('content')

@if(session('success'))
  <div id="pesanSukses" data-message="{{ session('success') }}"></div>
@endif

<div class="action-bar mb-3">
  <button type="button" class="btn btn-warning" id="btnOpenTambahFlex">
    <i class="fas fa-cog me-1"></i> Kelola Meja
  </button>
</div>

<div class="table-wrapper">
  <table id="reservasiTable">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Jumlah</th>
        <th>Meja</th>
        <th>Status</th>
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
          <td>{{ $meja ? $meja->nama_meja : '-' }}</td>
          <td>
            <span class="status-label" style="background:{{ $warna }};">
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
            <div class="aksi-group">
              <button class="btn-lihat" data-catatan="{{ $r->catatan ?? '-' }}">
                <i class="fas fa-eye"></i> Lihat
              </button>

            <button class="btn-edit"
                  data-id="{{ $r->id }}"
                  data-nama="{{ $r->nama }}"
                  data-jumlah="{{ $r->jumlah_orang }}"
                  data-meja="{{ $r->meja_id ?? '' }}"
                  data-status="{{ $r->status }}"
                  data-tanggal="{{ $r->tanggal ? \Carbon\Carbon::parse($r->tanggal)->format('Y-m-d') : now()->format('Y-m-d') }}"
                  data-jam="{{ $r->jam }}"
                  data-catatan="{{ $r->catatan ?? '' }}">
                  <i class="fas fa-edit"></i> Edit
              </button>


              <button type="button" class="btn-hapus" 
                      data-bs-toggle="modal" data-bs-target="#modalHapus"
                      data-id="{{ $r->id }}">
                <i class="fas fa-trash"></i> Hapus
              </button>
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="9" class="text-center">Belum ada reservasi masuk</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="pagination-wrapper">
  <button id="prevBtn">Kembali</button>
  <button id="nextBtn">Lanjut</button>
</div>

@include('admin.reservasi.modal')
@include('admin.reservasi.edit')
@include('admin.reservasi.tambah')
@include('admin.reservasi.hapus')

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  let currentPage = 1;
  const pageSize = 5;
  let reservasiData = [];

  function renderTable() {
    const tbody = document.querySelector("#reservasiTable tbody");
    tbody.innerHTML = "";

    if (reservasiData.length === 0) {
      tbody.innerHTML = `<tr><td colspan="9" class="text-center">Belum ada reservasi masuk</td></tr>`;
      return;
    }

    const totalPages = Math.ceil(reservasiData.length / pageSize);
    if (currentPage > totalPages) currentPage = totalPages;
    if (currentPage < 1) currentPage = 1;

    const start = (currentPage - 1) * pageSize;
    const end = start + pageSize;
    const pageData = reservasiData.slice(start, end);

   pageData.forEach((r, i) => {
  const meja = r.meja ? r.meja.nama_meja : '-';
  
  // Ambil status
  let status = r.status ?? 'Dipesan';

  // Cek 24 jam untuk ubah status ke Selesai
  const reservasiTime = new Date(`${r.tanggal}T${r.jam}`);
  const now = new Date();
  if(status === 'Dipesan' && (now - reservasiTime) >= 24*60*60*1000){
      status = 'Selesai';
  }

  // Tentukan warna sesuai status
  let warna;
  if(status === "Dipesan") warna = "#f44336";
  else if(status === "Selesai") warna = "#4CAF50";
  else if(status === "Dibatalkan") warna = "#424242"; // abu-abu gelap
  else warna = "#4CAF50";

  const catatan = r.catatan ? `<span class="catatan-pesan-baru">Pesan Baru</span>` : "-";

  tbody.insertAdjacentHTML("beforeend", `
    <tr>
      <td>${start + i + 1}</td>
      <td>${r.nama}</td>
      <td>${r.jumlah_orang}</td>
      <td>${meja}</td>
      <td><span class="status-label" style="background:${warna};">${status}</span></td>
      <td>${new Date(r.tanggal).toLocaleDateString("id-ID")}</td>
      <td>${r.jam}</td>
      <td>${catatan}</td>
      <td>
        <div class="aksi-group">
          <button class="btn-lihat" data-catatan="${r.catatan ?? '-'}">
            <i class="fas fa-eye"></i> Lihat
          </button>
          <button class="btn-edit"
            data-bs-toggle="modal" data-bs-target="#editReservasiModal"
            data-id="${r.id}"
            data-nama="${r.nama}"
            data-jumlah="${r.jumlah_orang}"
            data-meja="${r.meja ? r.meja.id : ''}"
            data-status="${status}"
            data-tanggal="${r.tanggal}"
            data-jam="${r.jam}"
            data-catatan="${r.catatan ?? ''}">
            <i class="fas fa-edit"></i> Edit
          </button>
          <button type="button" class="btn-hapus"
            data-bs-toggle="modal" data-bs-target="#modalHapus"
            data-id="${r.id}">
            <i class="fas fa-trash"></i> Hapus
          </button>
        </div>
      </td>
    </tr>
  `);
});


    document.getElementById("prevBtn").disabled = currentPage === 1;
    document.getElementById("nextBtn").disabled = currentPage === totalPages;
  }

  function loadReservasi() {
    fetch("{{ url('/admin/reservasi/latest') }}")
      .then(r => r.json())
      .then(res => {
        reservasiData = res.data;
        renderTable();
      });
  }

  document.getElementById("prevBtn").addEventListener("click", () => {
    if (currentPage > 1) { currentPage--; renderTable(); }
  });

  document.getElementById("nextBtn").addEventListener("click", () => {
    const totalPages = Math.ceil(reservasiData.length / pageSize);
    if (currentPage < totalPages) { currentPage++; renderTable(); }
  });

  // === Buat fungsi global agar user JS bisa update tabel ===
 window.reloadAdminTable = function() {
  loadReservasi();
};
  // ==========================================================

  loadReservasi();
  setInterval(loadReservasi, 1000); // opsional polling
});
</script>
@endpush
