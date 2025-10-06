<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Warung Coffee 86 - Admin</title>
  <link rel="stylesheet" href="{{ asset('css/admin/beranda.css') }}">
  <link rel="stylesheet" href="{{ asset('css/admin/halaman_menu.css') }}">
  <link rel="stylesheet" href="{{ asset('css/admin/menu.css') }}">
  <link rel="stylesheet" href="{{ asset('css/admin/reservasi.css') }}">
  <link rel="stylesheet" href="{{ asset('css/admin/statistik.css') }}">
   <link rel="stylesheet" href="{{ asset('css/admin/tambahmenu.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
 <!-- Sidebar kanan -->
<div class="sidebar">
  <h2>Warung Coffee 86</h2>
  <ul class="menu">
    <li><a href="#" onclick="showSection('beranda')"><i class="fas fa-home"></i> Beranda</a></li>
    <li><a href="#" onclick="showSection('menu')"><i class="fas fa-utensils"></i> Menu</a></li>
    <li><a href="#" onclick="showSection('reservasi')"><i class="fas fa-calendar-check"></i> Reservasi</a></li>
    <li><a href="{{ url('/admin/logout') }}"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
  </ul>
</div>

<!-- Konten utama -->
<div class="content">
  <!-- Halaman Beranda -->
  <div id="beranda" class="content-section active">
    <h1>Selamat Datang di Dashboard</h1>

    <!-- Statistik hanya muncul di Beranda -->
    <div class="stats-container">
      <div class="stat-box">
        <h2 id="count-admin">12</h2>
        <p>Admin</p>
      </div>
      <div class="stat-box">
        <h2 id="count-menu">48</h2>
        <p>Menu</p>
      </div>
      <div class="stat-box">
        <h2 id="count-reservasi">23</h2>
        <p>Reservasi</p>
      </div>
    </div>
  </div>

  <!-- Halaman Menu -->
<div id="menu" class="content-section">
  <h1>Kelola Menu</h1>

  <div class="menu-actions">
    <button class="btn btn-tambah" id="openModalBtn">
    <i class="fas fa-plus"></i> Tambah Menu
</button>
  </div>

  <!-- Pesan sukses -->
  @if(session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif

  <table>
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
          <td>{{ $menu->name }}</td>
          <td>Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
          <td>{{ $menu->kategori }}</td>
          <td>{{ $menu->status }}</td>
          <td>
            @if($menu->gambar)
              <img src="{{ asset('images/' . $menu->gambar) }}" alt="{{ $menu->name }}" width="60">
            @else
              <span>Tidak ada gambar</span>
            @endif
          </td>
         <td>
          <!-- Tombol Edit -->
          <a href="{{ route('admin.menu.edit', $menu->id) }}" class="btn-aksi btn-edit">
              <i class="fas fa-edit"></i> Edit
          </a>

          <!-- Form Hapus -->
          <form action="{{ route('admin.menu.hapus', $menu->id) }}" method="POST" style="display:inline;">
              @csrf
              @method('DELETE')
              <button class="btn-aksi btn-hapus" data-id="{{ $menu->id }}">
                  <i class="fas fa-trash"></i> Hapus
              </button>
          </form>

          <!-- Tombol Lihat -->
          <button class="btn-aksi btn-lihat" 
              onclick="showMenu('{{ $menu->name }}', '{{ $menu->harga }}', '{{ $menu->kategori }}', '{{ $menu->status }}', '{{ $menu->gambar ? asset('images/'.$menu->gambar) : '' }}')">
            <i class="fas fa-eye"></i> Lihat
          </button>
      </td>

        </tr>
      @empty
        <tr>
          <td colspan="7" style="text-align:center;">Belum ada data menu.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

<!-- Modal Tambah Menu -->
<div class="modal" id="menuModal">
  <div class="modal-content">
    <span class="close-modal" id="closeModalBtn">&times;</span>
    <h2>Tambah Menu Baru 🍽️</h2>

    <form action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <label>Nama Menu</label>
      <input type="text" name="nama" placeholder="Masukkan nama menu" required>

      <label>Harga</label>
      <input type="number" name="harga" placeholder="Masukkan harga" required>

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
      <div class="file-upload">
        <input type="file" name="gambar" id="image" accept="image/*">
        <label for="image" class="file-label"><i class="fas fa-upload"></i> Pilih Gambar</label>
      </div>

      <div class="form-buttons">
        <button type="button" class="btn-batal" id="closeModalBtn2">Batal</button>
        <button type="submit" class="btn-tambah">Simpan</button>
      </div>
    </form>
  </div>
</div>


<div id="modal-lihat">
  <div class="modal-content">
    
    <div class="modal-box">
      <span class="label">Nama Menu:</span>
      <span class="value" id="modal-nama"></span>
    </div>

    <div class="modal-box">
      <span class="label">Harga:</span>
      <span class="value" id="modal-harga"></span>
    </div>

    <div class="modal-box">
      <span class="label">Kategori:</span>
      <span class="value" id="modal-kategori"></span>
    </div>

    <div class="modal-box">
      <span class="label">Status:</span>
      <span class="value" id="modal-status"></span>
    </div>

    <!-- Container gambar dengan scroll -->
    <div id="modal-gambar-container">
        <img id="modal-gambar" src="" alt="Menu Image">
    </div>

    <button id="modal-close" onclick="closeModal()">Tutup</button>
  </div>
</div>


<!-- Modal Hapus -->
<div id="modal-hapus" class="modal" style="display:none;">
    <div class="modal-content">
        <h3>Konfirmasi Hapus</h3>
        <p>Apakah Anda yakin ingin menghapus menu ini?</p>
        <div class="modal-buttons">
            <button id="hapus-cancel" class="btn-cancel">Batal</button>
            <button id="hapus-confirm" class="btn-confirm">Hapus</button>
        </div>
    </div>
</div>

<!-- Pesan sukses -->
<div id="toast-success" style="display:none;">Menu berhasil dihapus!</div>


<script src="{{ asset('js/admin/menutambah.js') }}"></script>
<script src="{{ asset('js/admin/menu.js') }}"></script>


<!-- Halaman Reservasi -->
<div id="reservasi" class="content-section" style="margin-top: 40px;">
  <h1>Kelola Reservasi</h1>

  <!-- Pesan sukses -->
  @if(session('success'))
    <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 8px; margin-bottom: 15px;">
      {{ session('success') }}
    </div>
  @endif

  <!-- Tabel Reservasi -->
  <table style="width: 100%; border-collapse: collapse; text-align: center;">
    <thead style="background-color: #5a3e2b; color: white;">
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Jumlah</th>
        <th>Meja</th>
        <th>Tanggal</th>
        <th>Jam</th>
        <th>Catatan</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($reservasis as $index => $r)
        <tr style="background: #fff8f0; border-bottom: 1px solid #ccc;">
          <td>{{ $index + 1 }}</td>
          <td>{{ $r->nama }}</td>
          <td>{{ $r->jumlah_orang }}</td>
          <td>{{ $r->pilihan_meja }}</td>
          <td>{{ \Carbon\Carbon::parse($r->tanggal)->format('d-m-Y') }}</td>
          <td>{{ $r->jam }}</td>
          <td>{{ $r->catatan ?? '-' }}</td>
          <td>
            <button class="btn-aksi btn-lihat" style="background: #007bff; color: white; border: none; padding: 6px 10px; border-radius: 6px; cursor: pointer;">
              <i class="fas fa-eye"></i> Lihat
            </button>

            <form action="{{ route('admin.reservasi.hapus', $r->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus reservasi ini?');">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn-aksi btn-hapus" style="background: red; color: white; border: none; padding: 6px 10px; border-radius: 6px; cursor: pointer;">
                <i class="fas fa-trash"></i> Hapus
              </button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="8" style="padding: 10px;">Belum ada reservasi masuk</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>




<script src="{{ asset('js/script.js') }}"></script>

</body>
</html>
