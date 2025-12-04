@extends('admin.layout.app')
@section('title','Kelola Menu')
@section('content')

@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif

<div class="d-flex justify-content-start mb-3">
    <button class="btn" 
            style="background-color:#8B5E3C; color:white; border:none; border-radius:5px; box-shadow:0 2px 5px rgba(0,0,0,0.2);" 
            data-bs-toggle="modal" data-bs-target="#modalTambah">
        + Tambah Menu
    </button>
</div>

<div class="table-responsive">
    <table class="table table-striped table-bordered align-middle text-center">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($menus as $menu)
            <tr>
                <td>{{ $loop->iteration + ($menus->currentPage()-1) * $menus->perPage() }}</td>
                <td>{{ $menu->nama }}</td>
                <td>Rp {{ number_format($menu->harga,0,',','.') }}</td>
                <td>{{ $menu->kategori }}</td>
                <td>
                    <span class="badge {{ $menu->status == 'Tersedia' ? 'bg-success' : 'bg-danger' }}">
                        {{ $menu->status }}
                    </span>
                </td>
                <td>
                    @if($menu->gambar && file_exists(public_path('images/'.$menu->gambar)))
                        <img src="{{ asset('images/'.$menu->gambar) }}" width="60" class="rounded shadow-sm" alt="{{ $menu->nama }}">
                    @else
                        <span class="text-muted">Tidak ada</span>
                    @endif
                </td>
                <td class="d-flex justify-content-center gap-2">
      
             <button type="button" class="btn btn-warning btn-sm"
                onclick="openEditModal({
                    id: {{ $menu->id }},
                    nama: '{{ addslashes($menu->nama) }}',
                    harga: '{{ $menu->harga }}',
                    kategori: '{{ addslashes($menu->kategori) }}',
                    status: '{{ addslashes($menu->status) }}'
                })"
                style="font-size:0.85rem; padding:0.35rem 0.6rem; border-radius:0.4rem; box-shadow: 0 1px 3px rgba(0,0,0,0.3);">
                ✏️ Edit
            </button>

           
              <button type="button" class="btn btn-danger btn-sm"
                  onclick="confirmDelete('{{ route('admin.menu.destroy', $menu->id) }}')"
                  style="font-size:0.85rem; padding:0.35rem 0.6rem; border-radius:0.4rem; box-shadow: 0 1px 3px rgba(0,0,0,0.3);">
                  🗑️ Hapus
              </button>


                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-muted">Belum ada data menu.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-center mt-3 gap-2">
    <a href="{{ $menus->previousPageUrl() ?? '#' }}" 
       class="btn" 
       style="background-color:#8B5E3C; color:#FFF; border:none; border-radius:5px;">
       Kembali
    </a>
    <a href="{{ $menus->nextPageUrl() ?? '#' }}" 
       class="btn" 
       style="background-color:#8B5E3C; color:#FFF; border:none; border-radius:5px;">
       Lanjut
    </a>
</div>


@include('admin.menu.partials.tambah')
@include('admin.menu.partials.edit')
@include('admin.menu.partials.hapus')

<script src="{{ asset('js/admin/tabel-admin.js') }}"></script>
@endsection