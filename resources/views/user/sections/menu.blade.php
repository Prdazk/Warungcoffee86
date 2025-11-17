<section id="popular-menu" class="menu-section">
  <div class="container">
    <h2 class="menu-title text-center mb-4" style="margin-top: -30px;">MENU TERPOPULER</h2>

    <!-- ==================== MAKANAN ==================== -->
    <h3 class="category-title">Makanan</h3>
    <div class="menu-grid-wrapper">
      <div class="menu-grid" id="makananGrid">
        @foreach ($menus->where('kategori', 'Makanan') as $menu)
        <div class="menu-item">
          <img src="{{ $menu->gambar ? asset('images/'.$menu->gambar) : asset('images/kopi2.jpg') }}" alt="{{ $menu->nama }}">
          <h3 class="menu-name" style="font-family:'Playfair Display','Times New Roman',serif;font-weight:700;font-style:italic;font-size:1.4rem;letter-spacing:0.8px;color:#fff;text-shadow:1px 1px 3px rgba(0,0,0,0.6);">
            {{ $menu->nama }}
          </h3>
          <div class="menu-detail">
            <p>{{ number_format($menu->harga,0,',','.') }}K</p>
            <p>Status: 
              <span style="color: {{ $menu->status == 'Tersedia' ? '#c9ff70' : '#ff6b6b' }}">
                {{ $menu->status }}
              </span>
            </p>
          </div>
        </div>
        @endforeach
      </div>
    </div>

    <!-- ==================== MINUMAN ==================== -->
    <h3 class="category-title">Minuman</h3>
    <div class="menu-grid-wrapper">
      <div class="menu-grid" id="minumanGrid">
        @foreach ($menus->where('kategori', 'Minuman') as $menu)
        <div class="menu-item">
          <img src="{{ $menu->gambar ? asset('images/'.$menu->gambar) : asset('images/kopi2.jpg') }}" alt="{{ $menu->nama }}">
          <h3 class="menu-name" style="font-family:'Playfair Display','Times New Roman',serif;font-weight:700;font-style:italic;font-size:1.4rem;letter-spacing:0.8px;color:#fff;text-shadow:1px 1px 3px rgba(0,0,0,0.6);">
            {{ $menu->nama }}
          </h3>
          <div class="menu-detail">
            <p>{{ number_format($menu->harga,0,',','.') }}K</p>
            <p>Status: 
              <span style="color: {{ $menu->status == 'Tersedia' ? '#c9ff70' : '#ff6b6b' }}">
                {{ $menu->status }}
              </span>
            </p>
          </div>
        </div>
        @endforeach
      </div>
    </div>

  </div>
</section>
