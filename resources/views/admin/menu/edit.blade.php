@extends('admin.layout.app')
@section('title','Edit Menu')
@section('content')

<div class="form-container">
    <h1>Edit Menu</h1>

    <form class="form-tambah-menu" action="{{ route('admin.menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Baris 1: Nama | Harga -->
        <div class="form-row">
            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="nama" value="{{ old('nama', $menu->nama) }}" required placeholder="Masukkan nama menu">
                @error('nama')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Harga</label>
                <input type="number" name="harga" value="{{ old('harga', $menu->harga) }}" required placeholder="Masukkan harga">
                @error('harga')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Baris 2: Kategori | Status -->
        <div class="form-row">
            <div class="form-group">
                <label>Kategori</label>
                <select name="kategori" required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="Makanan" {{ old('kategori', $menu->kategori) == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                    <option value="Minuman" {{ old('kategori', $menu->kategori) == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                </select>
                @error('kategori')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="Tersedia" {{ old('status', $menu->status) == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="Habis" {{ old('status', $menu->status) == 'Habis' ? 'selected' : '' }}>Habis</option>
                </select>
                @error('status')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Baris 3: Gambar -->
        <div class="form-group">
            <label>Gambar</label>
            @if($menu->gambar)
                <img src="{{ asset('images/'.$menu->gambar) }}" width="80" alt="{{ $menu->nama }}" style="margin-bottom:10px;">
            @endif
            <input type="file" name="gambar" accept="image/*">
            @error('gambar')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Tombol -->
        <div class="form-buttons">
            <button type="submit" class="btn-submit">Update</button>
            <button type="button" onclick="history.back()">Kembali</button>
        </div>
    </form>
</div>

@endsection
