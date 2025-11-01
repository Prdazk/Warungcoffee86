<section id="popular-menu" class="menu-section">
  <div class="container">
    <h2 class="menu-title text-center mb-4" style="margin-top: -30px;">MENU TERPOPULER</h2>

    <div class="menu-grid">
      @foreach ($menus as $menu)
      <div class="menu-item">
        <img src="{{ $menu->gambar ? asset('images/'.$menu->gambar) : asset('images/kopi2.jpg') }}" alt="{{ $menu->nama }}">
        <h3 class="menu-name">{{ $menu->nama }}</h3>
        <div class="menu-buttons">
          <button 
            class="btn-detail"
            data-nama="{{ $menu->nama }}"
            data-harga="{{ $menu->harga }}"
            data-status="{{ $menu->status }}">
            Lihat
          </button>
        </div>
      </div>
      @endforeach
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