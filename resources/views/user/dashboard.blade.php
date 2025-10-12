<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Warung Coffee 86</title>
  <link rel="stylesheet" href="{{ asset('css/user/dashboard.css') }}">
  <link rel="stylesheet" href="{{ asset('css/user/menu.css') }}">
  <link rel="stylesheet" href="{{ asset('css/user/reservasi.css') }}">
  <link rel="stylesheet" href="{{ asset('css/user/tentang.css') }}">
  <link rel="stylesheet" href="{{ asset('css/user/lokasi.css') }}">
  <link rel="stylesheet" href="{{ asset('css/user/about.css') }}">
</head>
<body>
  <div class="page-wrapper">

    <!-- Header -->
    <header class="site-header">
      <div class="nav-container">
        <a href="#hero" class="logo">COFFEE </a>
        <div class="nav-right">
          <nav class="main-nav">
            <a href="#hero" class="nav-link">Beranda</a>
            <a href="#popular-menu" class="nav-link">Menu</a>
            <a href="#reservasi" class="nav-link">Reservasi</a>
            <a href="#lokasi" class="nav-link">Kontak</a>
            <a href="#about" class="nav-link">Tentang</a>
          </nav>
        </div>
      </div>
    </header>

    <!-- Hero Section -->
    <section id="hero" class="hero-section">
      <div class="hero-container">
        <div class="hero-text">
          <p class="pre-title">BangRouf</p>
          <h1 class="hero-title">Warung<br>Coffee 86</h1>
          <p class="hero-subtitle">Mari Nikmati Secangkir Kopi</p>
          <a href="#popular-menu" class="hero-cta">Lihat Menu</a>
        </div>
        <div class="hero-image">
          <img src="{{ asset('images/grup.png') }}" alt="A cup of coffee with coffee beans">
        </div>
      </div>
    </section>

    <!-- Menu Section -->
    <section id="popular-menu" class="menu-section">
      <div class="container">
        <h2 class="menu-title">MENU TERPOPULER</h2>
        <div class="menu-grid">

          <!-- Menu Items -->
          <div class="menu-item">
            <img src="{{ asset('images/kopi2.jpg') }}" alt="Espresso">
            <h3 class="menu-name">Espresso</h3>
            <p class="menu-price">Rp15.000</p>
            <p class="menu-desc">Kopi hitam pekat dengan cita rasa klasik.</p>
            <div class="menu-buttons">
              <button class="btn-view">Lihat</button>
              <button class="btn-checkout">Rating</button>
            </div>
          </div>

          <div class="menu-item">
            <img src="{{ asset('images/kopi2.jpg') }}" alt="Cappuccino">
            <h3 class="menu-name">Cappuccino</h3>
            <p class="menu-price">Rp20.000</p>
            <p class="menu-desc">Espresso dengan susu panas dan foam lembut.</p>
            <div class="menu-buttons">
              <button class="btn-view">Lihat</button>
              <button class="btn-checkout">Checkout</button>
            </div>
          </div>

          <div class="menu-item">
            <img src="{{ asset('images/kopi2.jpg') }}" alt="Latte">
            <h3 class="menu-name">Latte</h3>
            <p class="menu-price">Rp22.000</p>
            <p class="menu-desc">Kopi susu dengan rasa creamy dan lembut.</p>
            <div class="menu-buttons">
              <button class="btn-view">Lihat</button>
              <button class="btn-checkout">Checkout</button>
            </div>
          </div>

          <div class="menu-item">
            <img src="{{ asset('images/kopi2.jpg') }}" alt="Americano">
            <h3 class="menu-name">Americano</h3>
            <p class="menu-price">Rp18.000</p>
            <p class="menu-desc">Espresso dicampur air panas, rasa ringan dan segar.</p>
            <div class="menu-buttons">
              <button class="btn-view">Lihat</button>
              <button class="btn-checkout">Checkout</button>
            </div>
          </div>

          <div class="menu-item">
            <img src="{{ asset('images/kopi2.jpg') }}" alt="Mocha">
            <h3 class="menu-name">Mocha</h3>
            <p class="menu-price">Rp25.000</p>
            <p class="menu-desc">Kopi, cokelat, dan susu, kombinasi manis dan nikmat.</p>
            <div class="menu-buttons">
              <button class="btn-view">Lihat</button>
              <button class="btn-checkout">Checkout</button>
            </div>
          </div>

          <div class="menu-item">
            <img src="{{ asset('images/kopi2.jpg') }}" alt="Macchiato">
            <h3 class="menu-name">Macchiato</h3>
            <p class="menu-price">Rp21.000</p>
            <p class="menu-desc">Espresso dengan sedikit foam susu di atasnya.</p>
            <div class="menu-buttons">
              <button class="btn-view">Lihat</button>
              <button class="btn-checkout">Checkout</button>
            </div>
          </div>

          <div class="menu-item">
            <img src="{{ asset('images/kopi2.jpg') }}" alt="Ice Coffee">
            <h3 class="menu-name">Ice Coffee</h3>
            <p class="menu-price">Rp20.000</p>
            <p class="menu-desc">Kopi dingin segar dengan es batu dan sirup.</p>
            <div class="menu-buttons">
              <button class="btn-view">Lihat</button>
              <button class="btn-checkout">Checkout</button>
            </div>
          </div>

          <div class="menu-item">
            <img src="{{ asset('images/kopi2.jpg') }}" alt="Affogato">
            <h3 class="menu-name">Affogato</h3>
            <p class="menu-price">Rp28.000</p>
            <p class="menu-desc">Espresso dituangkan di atas es krim vanilla.</p>
            <div class="menu-buttons">
              <button class="btn-view">Lihat</button>
              <button class="btn-checkout">Checkout</button>
            </div>
          </div>

        </div>
      </div>
    </section>

   <!-- Reservasi Section -->
<section id="reservasi" class="reservasi-section">
  <div style="background: #927950; padding: 30px; border-radius: 20px; box-shadow: 0 8px 20px rgba(90,62,43,0.3); max-width: 950px; margin: auto;">

    <div style="display: flex; gap: 20px; flex-wrap: wrap; justify-content: space-between;">

      <!-- Form Reservasi -->
      <div style="flex: 1 1 45%; background: #4a3f35; padding: 25px; border-radius: 15px; color: #c49a6c; min-height: 520px;">
        <h2 style="color: #beb5af; margin-bottom: 20px;">Silakan Pilih Meja</h2>

        <!-- ✅ Pesan sukses -->
        @if(session('success'))
          <div style="background: #d4edda; color: #155724; padding: 12px; border-radius: 8px; margin-bottom: 20px; text-align: center;">
            {{ session('success') }}
          </div>
        @endif

        <form method="POST" action="{{ route('user.reservasi.store') }}">
          @csrf
          <div style="display: flex; gap: 15px; margin-bottom: 15px;">
            <div style="flex: 1;">
              <label>Nama</label>
              <input type="text" name="nama" placeholder="Masukkan nama"
                style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #c49a6c;
                background-color: #6b5239; color: #fff;" required>
            </div>
            <div style="flex: 1;">
              <label>Jumlah Orang</label>
              <input type="number" name="jumlah_orang" placeholder="Jumlah orang"
                style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #c49a6c;
                background-color: #6b5239; color: #fff;" required>
            </div>
          </div>

          <div style="display: flex; gap: 15px; margin-bottom: 15px;">
            <div style="flex: 1;">
              <label>Pilih Meja</label>
              <select name="pilihan_meja"
                style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #c49a6c;
                background-color: #6b5239; color: #fff;" required>
                <option value="">-- Pilih Meja --</option>
                <option value="Meja 1">Meja 1</option>
                <option value="Meja 2">Meja 2</option>
                <option value="Meja 3">Meja 3</option>
                <option value="Meja 4">Meja 4</option>
                <option value="Meja 5">Meja 5</option>
                <option value="VIP">VIP</option>
              </select>
            </div>
            <div style="flex: 1;">
              <label>Tanggal</label>
              <input type="date" name="tanggal"
                style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #c49a6c;
                background-color: #6b5239; color: #fff;" required>
            </div>
          </div>

          <div style="margin-bottom: 15px; text-align: center;">
            <label style="display: block; margin-bottom: 5px;">Jam</label>
            <input type="time" name="jam"
              style="width: 50%; padding: 10px; border-radius: 8px; border: 1px solid #c49a6c;
              background-color: #a68154; color: #fff; text-align: center;" required>
          </div>

          <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px;">Catatan</label>
            <textarea name="catatan" placeholder="Tulis catatan di sini..."
              style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #c49a6c;
              background-color: #a68154; color: #fff; min-height: 100px; resize: vertical;"></textarea>
          </div>

          <button type="submit"
            style="width: 100%; background: #160b0b; color: #9b992f; padding: 12px; border: none;
            border-radius: 8px; font-size: 16px; cursor: pointer; transition: 0.3s;">
            Pesan Sekarang
          </button>
        </form>
      </div>

      <!-- Syarat & Ketentuan -->
      <div style="flex: 1 1 45%; background: #5a3e2b; padding: 25px; border-radius: 15px; min-height: 520px;">
        <h3 style="color: #fff8f0; margin-bottom: 20px;">Syarat & Ketentuan</h3>
        <ul style="text-align: left; color: #fff8f0; line-height: 1.6; padding-left: 20px;">
          <li>Reservasi minimal 45 menit sebelum kedatangan.</li>
          <li>Mohon datang tepat waktu untuk memudahkan persiapan.</li>
          <li>Setiap reservasi maksimal untuk 10 orang.</li>
          <li>Harap informasikan alergi atau permintaan khusus di kolom tambahan.</li>
          <li>Pembatalan reservasi dapat dilakukan 2 jam sebelum waktu reservasi.</li>
        </ul>
      </div>

    </div>
  </div>
</section>


    <!-- Kontak & Lokasi Section -->
<section id="lokasi" class="lokasi">
  <div class="kontak-wrapper">
    <!-- Kiri: Aplikasi / Kontak -->
    <div class="kontak-info">
      <h2>Kontak Kami</h2>
      <div class="info-grid">
        <!-- Aplikasi 1 -->
        <div class="info-item">
          <img src="{{ asset('images/email.png') }}" alt="Email">
          <h3>Email</h3>
          <p>email@warung86.com</p>
        </div>
        <!-- Aplikasi 2 -->
        <div class="info-item">
          <img src="{{ asset('images/wa.png') }}" alt="WhatsApp">
          <h3>WhatsApp</h3>
          <p>+62 812 3456 7890</p>
        </div>
        <!-- Aplikasi 3 -->
        <div class="info-item">
          <img src="{{ asset('images/maps.png') }}" alt="Alamat">
          <h3>Alamat</h3>
          <p>Taman Lembang</p>
        </div>
        <!-- Aplikasi 4 -->
        <div class="info-item">
          <img src="{{ asset('images/jam.png') }}" alt="Jam Operasi">
          <h3>Jam Operasi</h3>
          <p>07:00 - 22:00</p>
        </div>
      </div>
    </div>

    <!-- Kanan: Google Maps -->
    <div class="kontak-image">
      <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.885884733737!2d111.61082828885498!3d-7.477851999999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e79c5b605deb7bd%3A0xebe9fa230d8bee10!2sTaman%20Lembang%20Desa%20Ngale!5e0!3m2!1sid!2sid!4v1758192257827!5m2!1sid!2sid" 
        width="100%" 
        height="400" 
        style="border:0; border-radius:15px; box-shadow:0 8px 20px rgba(0,0,0,0.15);" 
        allowfullscreen="" 
        loading="lazy" 
        referrerpolicy="no-referrer-when-downgrade">
      </iframe>
    </div>
  </div>
</section>

  <!-- About / Tentang Section -->
<section id="about" class="about-section">
  <div class="about-wrapper">
   <h2>Tentang</h2>
    <p>
      WarungCoffee86 adalah tempat di mana kopi berkualitas tinggi bertemu dengan suasana yang nyaman dan hangat. 
      Berdiri dengan tujuan menghadirkan pengalaman kopi terbaik bagi setiap pengunjung, WarungCoffee86 memadukan cita rasa kopi lokal dengan pelayanan yang ramah dan profesional. 
    </p>
    <p>
      Setiap cangkir kopi dibuat dengan perhatian penuh terhadap kualitas biji kopi dan proses penyeduhan, 
      sehingga menghasilkan aroma dan rasa yang khas dan memuaskan. 
      WarungCoffee86 bukan hanya sekadar tempat minum kopi, tapi juga menjadi ruang berkumpul, berbagi cerita, dan menikmati momen istimewa bersama keluarga maupun teman.
    </p>
    <p>
      Dengan desain interior yang hangat, pencahayaan yang nyaman, dan layanan yang ramah, 
      WarungCoffee86 berkomitmen untuk memberikan pengalaman yang tak terlupakan bagi setiap pengunjung. 
      Nikmati kopi, suasana, dan keramahan yang berpadu sempurna di WarungCoffee86.
    </p>
  </div>
</section>
  </div>
</body>
</html>
