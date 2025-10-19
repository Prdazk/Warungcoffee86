@extends('admin.layout.app')
@section('title','Tambah Menu')
@section('content')

<div class="form-container">
    <h1>Tambah Menu Baru</h1>

    <form class="form-tambah-menu" action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Baris 1: Nama | Harga -->
        <div class="form-row">
            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="nama" required placeholder="Masukkan nama menu">
            </div>

            <div class="form-group">
                <label>Harga</label>
                <input type="number" name="harga" required placeholder="Masukkan harga">
            </div>
        </div>

        <!-- Baris 2: Kategori | Status -->
        <div class="form-row">
            <div class="form-group">
                <label>Kategori</label>
                <select name="kategori" required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="Makanan">Makanan</option>
                    <option value="Minuman">Minuman</option>
                </select>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="Tersedia">Tersedia</option>
                    <option value="Habis">Habis</option>
                </select>
            </div>
        </div>

        <!-- Baris 3: Gambar -->
        <div class="form-group">
            <label>Gambar</label>
            <input type="file" name="gambar" accept="image/*">
        </div>

        <!-- Tombol -->
        <div class="form-buttons">
            <button type="submit" class="btn-submit">Simpan</button>
            <button type="button" onclick="history.back()">Kembali</button>
        </div>
    </form>
</div>

@endsection
