<style>
/* Laptop */
.menu-grid {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 20px;
}

/* Item lebih pendek */
.menu-item {
    background: #2d1f16;
    padding: 10px;
    border-radius: 12px;
    text-align: center;
    min-height: 150px; /* pendek */
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
}

/* Gambar lebih rounded */
.menu-item img {
    width: 100%;
    height: 80px;       /* pendek */
    object-fit: cover;
    border-radius: 20px; /* lebih bulat */
    margin-bottom: 8px;
}

.menu-name {
    font-size: 0.9rem;
    color: #e0a96d;
    margin: 4px 0;
}

.menu-detail p {
    margin: 0;
    font-size: 0.85rem;
    color: #fff;
}

/* HP: 3 kolom */
@media (max-width: 480px) {
    .menu-grid {
        grid-template-columns: repeat(3, 1fr) !important;
        gap: 12px; /* jarak antar tabel lebih lega */
    }

    .menu-item {
        padding: 6px;
        min-height: 135px; /* lebih pendek lagi */
    }

    .menu-item img {
        height: 70px;   /* pendek untuk HP */
        border-radius: 15px; /* tetap rounded tapi lebih kecil */
    }

    .menu-name {
        font-size: 0.8rem;
    }

    .menu-detail p {
        font-size: 0.75rem;
    }
}
</style>


<section id="popular-menu" class="menu-section" style="margin-top: 50px;">
  <div class="container">
    <h2 class="menu-title text-center mb-4" style="margin-top: -20px;">MENU TERPOPULER</h2>

    <!-- ================== MAKANAN ================== -->
    <h3 class="category-title">Makanan</h3>
    <div class="menu-grid-wrapper">
      <div class="menu-grid" id="makananGrid">
        
        @foreach ($menus->where('kategori', 'Makanan') as $menu)
        <div class="menu-item">
          <img src="{{ asset('images/' . ($menu->gambar ?: 'kopi2.jpg')) }}" alt="{{ $menu->nama }}">
          <h3 class="menu-name">{{ $menu->nama }}</h3>

          <div class="menu-detail">
            <p>{{ number_format($menu->harga, 0, ',', '.') }}K</p>
              <span style="color: {{ $menu->status == 'Tersedia' ? '#c9ff70' : '#ff6b6b' }}">
                {{ $menu->status }}
              </span>
            </p>
          </div>
        </div>
        @endforeach

      </div>
    </div>

    <!-- ================== MINUMAN ================== -->
    <h3 class="category-title">Minuman</h3>
    <div class="menu-grid-wrapper">
      <div class="menu-grid" id="minumanGrid">
        
        @foreach ($menus->where('kategori', 'Minuman') as $menu)
        <div class="menu-item">
          <img src="{{ asset('images/' . ($menu->gambar ?: 'kopi2.jpg')) }}" alt="{{ $menu->nama }}">
          <h3 class="menu-name">{{ $menu->nama }}</h3>

          <div class="menu-detail">
            <p>{{ number_format($menu->harga, 0, ',', '.') }}K</p>
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
