<section id="popular-menu" class="menu-section">
  <div class="container">
    <h2 class="menu-title text-center mb-4" style="color:#b3885d;">MENU TERPOPULER</h2>
    
    <div class="menu-grid" style="display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:20px;">
      @foreach ($menus as $menu)
        <div class="menu-item shadow-lg rounded-4" style="background:#815b3b; color:#FFF; overflow:hidden; text-align:center; padding:15px; transition:transform 0.2s;">
          <img src="{{ $menu->gambar ? asset('images/'.$menu->gambar) : asset('images/kopi2.jpg') }}" 
               alt="{{ $menu->nama }}" style="width:100%; height:150px; object-fit:cover; border-radius:10px;">
          <h3 class="menu-name mt-2 mb-3" style="font-weight:600;">{{ $menu->nama }}</h3>

          <div class="menu-buttons">
            <button class="btn btn-detail" 
                    style="background:#6A4827; border:none; color:#FFF; padding:8px 18px; border-radius:10px; font-weight:600; cursor:pointer; box-shadow:0 3px 6px rgba(0,0,0,0.2); transition: transform 0.2s;"
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

<!-- ===== Popup Detail Menu ===== -->
<div id="menuPopup2" class="popup-overlay" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6); justify-content:center; align-items:center; z-index:9999;">
  <div class="popup-box shadow-lg rounded-4" style="background:#4B3621; color:#FFF; padding:25px; width:400px; max-width:90%; position:relative;">
    <div class="popup-header d-flex justify-content-between align-items-center mb-3">
      <h3 style="margin:0; font-size:20px;">Detail Menu</h3>
      <button class="popup-close-btn" onclick="closeMenu2()" 
              style="background:#D32F2F; color:#FFF; border:none; padding:5px 12px; border-radius:8px; cursor:pointer; font-weight:600;">
        Tutup
      </button>
    </div>
    <table class="popup-table" style="width:100%; border-collapse:collapse;">
      <tr>
        <th style="text-align:left; padding:8px;">Nama</th>
        <td id="popupName2" style="padding:8px;"></td>
      </tr>
      <tr>
        <th style="text-align:left; padding:8px;">Harga</th>
        <td style="padding:8px;">Rp <span id="popupPrice2"></span></td>
      </tr>
      <tr>
        <th style="text-align:left; padding:8px;">Status</th>
        <td id="popupStatus2" style="padding:8px;"></td>
      </tr>
    </table>
  </div>
</div>

<script src="{{ asset('js/user/popup-menu.js') }}"></script>
