<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Warung Coffee 86 - Admin</title>
  <link rel="stylesheet" href="{{ asset('css/admin/beranda.css') }}">
  <link rel="stylesheet" href="{{ asset('css/admin/halaman_menu.css') }}">
  <link rel="stylesheet" href="{{ asset('css/admin/menu.css') }}">
  <link rel="stylesheet" href="{{ asset('css/admin/ser.css') }}">
  <link rel="stylesheet" href="{{ asset('css/admin/statistik.css') }}">
  <link rel="stylesheet" href="{{ asset('css/admin/tambahmenu.css') }}">
  <link rel="stylesheet" href="{{ asset('js/admin/efe.js') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
 <!-- Sidebar kanan -->
<div class="sidebar">
  <h2>Warung Coffee 86</h2>
  <ul class="menu">
    <li>
      <a href="#" onclick="showSection('beranda')">
        <i class="fas fa-home"></i> Beranda
      </a>
    </li>
    <li>
      <a href="#" onclick="showSection('menu')">
        <i class="fas fa-utensils"></i> Menu
      </a>
    </li>
    <li>
      <a href="#" onclick="showSection('reservasi')">
        <i class="fas fa-calendar-check"></i> Reservasi
      </a>
    </li>
    <li>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>

        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </li>

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
  <h1 style="margin-bottom: 20px;">Kelola Reservasi</h1>

  <!-- Pesan sukses -->
  @if(session('success'))
    <div id="pesanSukses" style="background: #d4edda; color: #155724; padding: 10px; border-radius: 8px; margin-bottom: 15px; opacity: 1; transition: opacity 1s;">
      {{ session('success') }}
    </div>
  @endif

  <!-- Tabel Reservasi -->
  <table style="width: 100%; border-collapse: collapse; text-align: center; font-family: sans-serif;">
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
        <tr style="background: #fff8f0; border-bottom: 1px solid #ccc; transition: background 0.3s;">
          <td>{{ $index + 1 }}</td>
          <td>{{ $r->nama }}</td>
          <td>{{ $r->jumlah_orang }}</td>
          <td>{{ $r->pilihan_meja }}</td>
          <td>{{ \Carbon\Carbon::parse($r->tanggal)->format('d-m-Y') }}</td>
          <td>{{ $r->jam }}</td>
          <td>{{ $r->catatan ?? '-' }}</td>
          <td style="display: flex; justify-content: center; gap: 5px;">

            <!-- Tombol Lihat -->
            <button class="btn-lihat" 
              data-nama="{{ $r->nama }}"
              data-jumlah="{{ $r->jumlah_orang }}"
              data-meja="{{ $r->pilihan_meja }}"
              data-tanggal="{{ \Carbon\Carbon::parse($r->tanggal)->format('d-m-Y') }}"
              data-jam="{{ $r->jam }}"
              data-catatan="{{ $r->catatan ?? '-' }}"
              style="background: #007bff; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; transition: transform 0.2s;">
              <i class="fas fa-eye"></i> Lihat
            </button>

            <!-- Form Hapus -->
            <form action="{{ route('admin.reservasi.hapus', $r->id) }}" method="POST" class="form-hapus">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn-hapus" style="background: #e74c3c; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; transition: transform 0.2s;">
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

<!-- Modal Lihat Reservasi -->
<div id="modalLihat" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.6); justify-content:center; align-items:center; z-index:999; backdrop-filter: blur(4px);">
  <div style="background:white; padding:25px; border-radius:12px; width:400px; max-width:90%; box-shadow: 0 10px 30px rgba(0,0,0,0.2); transform: scale(0.8); opacity: 0; transition: all 0.3s ease;">
    <h3 style="margin-bottom:15px; text-align:center; font-family:sans-serif;">Detail Reservasi</h3>
    <p><strong>Nama:</strong> <span id="lihatNama"></span></p>
    <p><strong>Jumlah Orang:</strong> <span id="lihatJumlah"></span></p>
    <p><strong>Meja:</strong> <span id="lihatMeja"></span></p>
    <p><strong>Tanggal:</strong> <span id="lihatTanggal"></span></p>
    <p><strong>Jam:</strong> <span id="lihatJam"></span></p>
    <p><strong>Catatan:</strong> <span id="lihatCatatan"></span></p>
    <button id="tutupModal" style="background:#5a3e2b; color:white; padding:8px 12px; border:none; border-radius:6px; width:100%; margin-top:10px; cursor:pointer;">Tutup</button>
  </div>
</div>

<script src="{{ asset('js/admin/reservasi.js') }}"></script>
<script src="{{ asset('js/script.js') }}"></script>

</body>
</html>
