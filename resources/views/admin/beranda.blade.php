<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Warung Coffee 86 - Admin</title>
  <link rel="stylesheet" href="{{ asset('css/admin/beranda.css') }}">
  <link rel="stylesheet" href="{{ asset('css/admin/halaman_menu.css') }}">
  <link rel="stylesheet" href="{{ asset('css/admin/reservasi.css') }}">
  <link rel="stylesheet" href="{{ asset('css/admin/statistik.css') }}">
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
    <p>Ini adalah halaman beranda admin Warung Coffee 86.</p>

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
    <a href="{{ route('admin.menu.tambah') }}" class="btn btn-tambah">
        <i class="fas fa-plus"></i> Tambah Menu
    </a>
    <button class="btn btn-edit">
        <i class="fas fa-edit"></i> Edit Menu
    </button>
  </div>

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
      <tr>
        <td>1</td>
        <td>Kopi Hitam</td>
        <td>Rp 10.000</td>
        <td>Minuman</td>
        <td>Tersedia</td>
        <td><img src="{{ asset('images/kopi1.png') }}" alt="Kopi Hitam" width="60"></td>
        <td>
          <button class="btn-aksi btn-hapus"><i class="fas fa-trash"></i> Hapus</button>
          <button class="btn-aksi btn-lihat"><i class="fas fa-eye"></i> Lihat</button>
        </td>
      </tr>
    </tbody>
  </table>
</div>

 <!-- Halaman Reservasi -->
<div id="reservasi" class="content-section">
  <h1>Kelola Reservasi</h1>
  <p>Halaman reservasi akan menampilkan daftar reservasi yang masuk.</p>

  <!-- Tabel Reservasi -->
  <table>
    <thead>
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
      <tr>
        <td>1</td>
        <td>Andi</td>
        <td>2</td>
        <td>Meja 3</td>
        <td>28-09-2025</td>
        <td>19:00</td>
        <td>Birthday celebration</td>
        <td>
          <button class="btn-aksi btn-lihat"><i class="fas fa-eye"></i> Lihat</button>
          <button class="btn-aksi btn-hapus"><i class="fas fa-trash"></i> Hapus</button>
        </td>
      </tr>
      <tr>
        <td>2</td>
        <td>Sari</td>
        <td>4</td>
        <td>Meja 5</td>
        <td>28-09-2025</td>
        <td>20:00</td>
        <td>Meeting bisnis</td>
        <td>
          <button class="btn-aksi btn-lihat"><i class="fas fa-eye"></i> Lihat</button>
          <button class="btn-aksi btn-hapus"><i class="fas fa-trash"></i> Hapus</button>
        </td>
      </tr>
      <!-- Tambahkan baris reservasi lain sesuai kebutuhan -->
    </tbody>
  </table>
</div>

<script src="{{ asset('js/script.js') }}"></script>

</body>
</html>
