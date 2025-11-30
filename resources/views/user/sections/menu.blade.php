<style>
/* 1. Layout Grid Utama */
.menu-grid {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    /* Jarak tetap 70px untuk Laptop */
    gap: 70px; 
    align-items: start; /* PENTING: Agar item bisa diatur naik-turunnya */
}

/* 2. Container Item */
.menu-item {
    background: transparent !important;
    box-shadow: none !important;
    border: none !important;
    padding: 0;
    
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    
    min-height: 180px; 
    transition: all 0.3s ease; /* Biar smooth */
}

/* 3. BAGIAN GAMBAR */
.menu-item img {
    width: 100%;           
    height: 130px;         
    object-fit: contain;
    border: none !important;
    outline: none !important;
    background: transparent !important;
    border-radius: 0;
    margin-bottom: 10px;
    
    /* Efek bayangan */
    filter: drop-shadow(0px 8px 8px rgba(0,0,0,0.4)); 
}

/* Text Nama Menu */
.menu-name {
    font-size: 0.9rem;
    color: #e0a96d;
    margin-top: 5px;
    font-weight: bold;
}

/* Text Harga */
.menu-detail p {
    font-size: 0.85rem;
    color: #fff;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.8);
}

/* ========================================= */
/* KHUSUS TAMPILAN HP (Dibuat Zig-Zag)       */
/* ========================================= */
@media (max-width: 480px) {
    .menu-grid {
        grid-template-columns: repeat(3, 1fr) !important;
        
        /* Jarak kanan-kiri dirapatkan biar gambar agak besar */
        column-gap: 10px; 
        
        /* Jarak atas-bawah DILONGGARKAN untuk memberi ruang efek zig-zag */
        row-gap: 60px; 
    }
    
    .menu-item img {
        height: 85px; /* Sesuaikan sedikit agar proporsional */
    }
    
    .menu-name {
        font-size: 0.7rem; 
    }
    
    .menu-detail p {
        font-size: 0.7rem;
    }

    /* --- LOGIKA ZIG-ZAG (Magic Code) --- */
    
    /* Target Kolom Tengah (Item ke-2, 5, 8, dst) */
    /* Rumus 3n+2 artinya setiap kelipatan 3, ambil yg ke-2 */
    .menu-item:nth-child(3n+2) {
        margin-top: 45px; /* Turunkan item tengah sebanyak 45px */
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
