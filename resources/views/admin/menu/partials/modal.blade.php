<!-- Modal Tambah Menu -->
<div class="modal" id="menuModal">
  <div class="modal-content">
    <span class="close-modal" id="closeModalBtn">&times;</span>
    <h2>Tambah Menu Baru</h2>
    <form action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <label>Nama Menu</label>
      <input type="text" name="nama" required>

      <label>Harga</label>
      <input type="number" name="harga" required>

      <label>Kategori</label>
      <select name="kategori" required>
        <option value="">-- Pilih Kategori --</option>
        <option value="Minuman">Minuman</option>
        <option value="Makanan">Makanan</option>
      </select>

      <label>Status</label>
      <select name="status" required>
        <option value="">-- Pilih Status --</option>
        <option value="Tersedia">Tersedia</option>
        <option value="Habis">Habis</option>
      </select>

      <label>Gambar</label>
      <input type="file" name="gambar" accept="image/*">

      <div style="margin-top:10px;">
        <button type="submit">Simpan</button>
      </div>
    </form>
  </div>
</div>
