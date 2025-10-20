<section id="popular-menu" class="menu-section">
  <div class="container">
    <h2 class="menu-title">MENU TERPOPULER</h2>
    <div class="menu-grid">
      @foreach ($menus as $menu)
        <div class="menu-item">
          <img src="{{ $menu->gambar ? asset('images/'.$menu->gambar) : asset('images/kopi2.jpg') }}" alt="{{ $menu->nama }}">
          <h3 class="menu-name">{{ $menu->nama }}</h3>
          <p class="menu-price">Rp{{ number_format($menu->harga, 0, ',', '.') }}</p>
          <p class="menu-desc">{{ $menu->deskripsi ?? 'Kopi nikmat khas Warung Coffee 86' }}</p>
          <div class="menu-buttons">
            <button class="btn-view"
              onclick="alert('Nama: {{ $menu->nama }}\nHarga: Rp{{ number_format($menu->harga, 0, ',', '.') }}\nKategori: {{ $menu->kategori ?? 'Tidak ada' }}\nStatus: {{ $menu->status ?? 'Tidak ada' }}\nDeskripsi: {{ $menu->deskripsi ?? 'Tidak ada' }}')">
              Lihat
            </button>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>