@extends('admin.layout.app')
@section('title','Kelola Menu')
@section('content')

<!-- Tombol Tambah Menu -->
<a href="{{ route('admin.menu.create') }}" class="btn-box btn-tambah mb-3">
    <i class="fas fa-plus"></i> Tambah menu
</a>

<table class="table table-bordered">
    <thead>
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
                <td>{{ $loop->iteration }}</td>
                <td>{{ $menu->nama }}</td>
                <td>Rp {{ number_format($menu->harga,0,',','.') }}</td>
                <td>{{ $menu->kategori }}</td>
                <td>{{ $menu->status }}</td>
                <td>
                    @if($menu->gambar)
                        <img src="{{ asset('images/'.$menu->gambar) }}" width="60" alt="{{ $menu->nama }}">
                    @else
                        <span>Tidak ada</span>
                    @endif
                </td>
                <td>
                    <!-- Tombol Edit -->
                    <a href="{{ route('admin.menu.edit',$menu->id) }}" class="btn-box btn-edit">
                        <i class="fas fa-edit"></i> Edit
                    </a>

                    <!-- Tombol Hapus -->
                   <form action="{{ route('admin.menu.destroy', $menu->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-box btn-hapus" onclick="return confirm('Yakin hapus menu ini?')">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>

                    <!-- Tombol Lihat -->
                    <button type="button" class="btn-box btn-lihat" 
                        onclick="showMenu(
                            @json($menu->nama),
                            @json($menu->harga),
                            @json($menu->kategori),
                            @json($menu->status),
                            @json($menu->gambar ? asset('images/'.$menu->gambar) : '')
                        )">
                        <i class="fas fa-eye"></i> Lihat
                    </button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">Belum ada data menu.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<!-- Modal Lihat Menu -->
<div id="modalLihat" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div class="modal-body">
            <div class="modal-left">
                <img id="modalGambar" src="" alt="Gambar Menu">
            </div>
            <div class="modal-right">
                <h2 id="modalNama"></h2>
                <p><strong>Harga:</strong> Rp <span id="modalHarga"></span></p>
                <p><strong>Kategori:</strong> <span id="modalKategori"></span></p>
                <p><strong>Status:</strong> <span id="modalStatus"></span></p>
            </div>
        </div>
    </div>
</div>

@endsection
