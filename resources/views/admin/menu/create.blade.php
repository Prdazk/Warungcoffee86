@extends('admin.layout.app')
@section('title','Tambah Menu')
@section('content')

<h1>Tambah Menu Baru</h1>

<form class="form-tambah-menu" action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <label>Nama</label>
    <input type="text" name="nama" required>

    <label>Harga</label>
    <input type="number" name="harga" required>

    <label>Kategori</label>
    <select name="kategori" required>
        <option value="">-- Pilih Kategori --</option>
        <option value="Makanan">Makanan</option>
        <option value="Minuman">Minuman</option>
    </select>

    <label>Status</label>
    <select name="status" required>
        <option value="">-- Pilih Status --</option>
        <option value="Tersedia">Tersedia</option>
        <option value="Habis">Habis</option>
    </select>

    <label>Gambar</label>
    <input type="file" name="gambar" accept="image/*">

    <button type="submit" class="btn-submit">Simpan</button>
</form>

@endsection
