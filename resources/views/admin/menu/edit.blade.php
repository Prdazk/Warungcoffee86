@extends('admin.layout.app')
@section('title','Edit Menu')
@section('content')

<div class="form-container">
    <h1>Edit Menu</h1>

    <form class="form-tambah-menu" action="{{ route('admin.menu.update',$menu->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Baris 1: Nama | Harga -->
        <div class="form-row">
            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="nama" value="{{ $menu->name }}" required placeholder="Masukkan nama menu">
            </div>

            <div class="form-group">
                <label>Harga</label>
                <input type="number" name="harga" value="{{ $menu->harga }}" required placeholder="Masukkan harga">
            </div>
        </div>

        <!-- Baris 2: Kategori | Status -->
        <div class="form-row">
            <div class="form-group">
                <label>Kategori</label>
                <select name="kategori" required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="Makanan" {{ $menu->kategori=='Makanan'?'selected':'' }}>Makanan</option>
                    <option value="Minuman" {{ $menu->kategori=='Minuman'?'selected':'' }}>Minuman</option>
                </select>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="Tersedia" {{ $menu->status=='Tersedia'?'selected':'' }}>Tersedia</option>
                    <option value="Habis" {{ $menu->status=='Habis'?'selected':'' }}>Habis</option>
                </select>
            </div>
        </div>

        <!-- Baris 3: Gambar -->
        <div class="form-group">
            <label>Gambar</label>
            @if($menu->gambar)
                <img src="{{ asset('images/'.$menu->gambar) }}" width="80" alt="{{ $menu->name }}" style="margin-bottom:10px;">
            @endif
            <input type="file" name="gambar" accept="image/*">
        </div>

        <!-- Tombol -->
        <div class="form-buttons">
            <button type="submit" class="btn-submit">Update</button>
            <button type="button" onclick="history.back()">Kembali</button>
        </div>
    </form>
</div>

@endsection
