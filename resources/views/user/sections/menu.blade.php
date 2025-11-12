<section id="popular-menu" class="menu-section">
  <div class="container">
    <h2 class="menu-title text-center mb-4" style="margin-top: -30px;">MENU TERPOPULER</h2>

    <h3 class="category-title">Makanan</h3>
    <div class="menu-grid-wrapper">
      <div class="menu-grid">
        @foreach ($menus->where('kategori', 'Makanan') as $menu)
        <div class="menu-item">
          <img src="{{ $menu->gambar ? asset('images/'.$menu->gambar) : asset('images/kopi2.jpg') }}" alt="{{ $menu->nama }}">
          <h3 class="menu-name">{{ $menu->nama }}</h3>
          <div class="menu-buttons">
           <button 
            class="btn-detail"
            data-nama="{{ $menu->nama }}"
            data-harga="{{ $menu->harga }}"
            data-status="{{ $menu->status }}"
            style="background-color:#587a20; color:white; border:none; border-radius:6px; padding:6px 12px; cursor:pointer; box-shadow:0 2px 5px rgba(0,0,0,0.2); transition:0.3s;">
            Lihat
          </button>

          </div>
        </div>
        @endforeach
      </div>
    </div>

    <h3 class="category-title">Minuman</h3>
    <div class="menu-grid-wrapper">
      <div class="menu-grid">
        @foreach ($menus->where('kategori', 'Minuman') as $menu)
        <div class="menu-item">
          <img src="{{ $menu->gambar ? asset('images/'.$menu->gambar) : asset('images/kopi2.jpg') }}" alt="{{ $menu->nama }}">
          <h3 class="menu-name">{{ $menu->nama }}</h3>
          <div class="menu-buttons">
            <button 
            class="btn-detail"
            data-nama="{{ $menu->nama }}"
            data-harga="{{ $menu->harga }}"
            data-status="{{ $menu->status }}"
            style="background:#587a20; color:#fff; border:none; border-radius:6px; padding:6px 12px; cursor:pointer; box-shadow:0 2px 5px rgba(0,0,0,0.2); transition:0.3s;">
            Lihat
        </button>

          </div>
        </div>
        @endforeach
      </div>
    </div>

  </div>
</section>

<div id="menuPopup2" class="popup-overlay">
  <div class="popup-box">
    <div class="popup-header">
      <h3>Detail Menu</h3>
      <button class="popup-close-btn">Tutup</button>
    </div>
    <table class="popup-table">
      <tr>
        <th>Nama</th>
        <td id="popupName2"></td>
      </tr>
      <tr>
        <th>Harga</th>
        <td>Rp <span id="popupPrice2"></span></td>
      </tr>
      <tr>
        <th>Status</th>
        <td id="popupStatus2"></td>
      </tr>
    </table>
  </div>
</div>