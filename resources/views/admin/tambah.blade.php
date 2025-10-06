<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Menu - Admin</title>
  <link rel="stylesheet" href="{{ asset('css/admin/tambahmenu.css') }}">
</head>
<body>
  <div class="form-wrapper">
    <h1>Tambah Menu Baru</h1>

    <form action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <label for="name">Nama Menu</label>
      <input type="text" id="name" name="name" placeholder="Masukkan nama menu" required>

      <label for="price">Harga</label>
      <input type="number" id="price" name="price" placeholder="Masukkan harga" required>

      <label for="category">Kategori</label>
      <select id="category" name="category" required>
        <option value="">-- Pilih Kategori --</option>
        <option value="Minuman">Minuman</option>
        <option value="Makanan">Makanan</option>
      </select>

      <label for="status">Status</label>
      <select id="status" name="status" required>
        <option value="">-- Pilih Status --</option>
        <option value="Tersedia">Tersedia</option>
        <option value="Habis">Habis</option>
      </select>

      <label for="image">Gambar</label>
      <input type="file" id="image" name="image" accept="image/*">

      <div class="form-buttons">
       <button type="button" class="btn-batal" onclick="window.location='{{ route('admin.beranda') }}?section=menu'">Batal</button>  
        <button type="submit" class="btn-tambah">Tambah</button>
      </div>
    </form>
  </div>
</body>
</html>
