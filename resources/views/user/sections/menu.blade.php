<section id="popular-menu" class="menu-section">
  <div class="container">
    <h2 class="menu-title">MENU TERPOPULER</h2>
    <div class="menu-grid">
      @foreach ($menus as $menu)
        <div class="menu-item">
          <img src="{{ $menu->gambar ? asset('images/'.$menu->gambar) : asset('images/kopi2.jpg') }}" alt="{{ $menu->nama }}">
          <h3 class="menu-name">{{ $menu->nama }}</h3>
          <div class="menu-buttons">
                <button class="btn btn-success btn-sm" style="background: #43a047; border: none; color: #fff; padding: 6px 14px; border-radius: 10px; font-weight: 600; cursor: pointer; box-shadow: 0 3px 6px rgba(0,0,0,0.2); transition: transform 0.2s ease;" 
              onmouseover="this.style.transform='scale(1.05)'" 
              onmouseout="this.style.transform='scale(1)'"
              onclick="showMenu2(
                '{{ addslashes($menu->nama) }}',
                '{{ $menu->harga }}',
                '{{ addslashes($menu->status) }}'
              )">
            Lihat
          </button>

          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>

  <!-- Popup Tabel -->
  <div id="menuPopup2" class="popup-overlay">
    <div class="popup-box">
      <div class="popup-header">
        <h3>Detail Menu</h3>
        <button class="popup-close-btn" onclick="closeMenu2()">Tutup</button>
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
  
  <script src="{{ asset('js//user/popup-menu.js') }}"></script>

</section>