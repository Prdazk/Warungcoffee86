@extends('admin.layout.app')
@section('title','Edit Menu')
@section('content')

<h1>Edit Menu</h1>

<form action="{{ route('admin.menu.update',$menu->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label>Nama</label>
    <input type="text" name="name" value="{{ $menu->name }}" required>

    <label>Harga</label>
    <input type="number" name="harga" value="{{ $menu->harga }}" required>

    <label>Kategori</label>
    <select name="kategori" required>
        <option value="Makanan" {{ $menu->kategori=='Makanan'?'selected':'' }}>Makanan</option>
        <option value="Minuman" {{ $menu->kategori=='Minuman'?'selected':'' }}>Minuman</option>
    </select>

    <label>Status</label>
    <select name="status" required>
        <option value="Tersedia" {{ $menu->status=='Tersedia'?'selected':'' }}>Tersedia</option>
        <option value="Habis" {{ $menu->status=='Habis'?'selected':'' }}>Habis</option>
    </select>

    <label>Gambar</label>
    @if($menu->gambar)
        <img src="{{ asset('images/'.$menu->gambar) }}" width="80" alt="{{ $menu->name }}">
    @endif
    <input type="file" name="gambar" accept="image/*">

    <button type="submit">Update</button>
</form>

@endsection
