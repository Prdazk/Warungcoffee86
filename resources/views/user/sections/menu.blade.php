<!-- ===== Section Menu Terpopuler ===== -->
<section id="popular-menu" class="menu-section" style="padding: 50px 0;">
  <div class="container" style="max-width: 1400px; margin: 0 auto; padding: 0 20px;">
    <h2 class="menu-title text-center mb-4" style="color:#b3885d; font-size:2rem; font-weight:700;">MENU TERPOPULER</h2>
    
    <div class="menu-grid">
      @foreach ($menus as $menu)
      <div class="menu-item shadow-lg rounded-4" style="text-align:center; padding:15px; background:#815b3b; color:#fff;">
        <img src="{{ $menu->gambar ? asset('images/'.$menu->gambar) : asset('images/kopi2.jpg') }}" alt="{{ $menu->nama }}" style="width:100%; height:160px; object-fit:cover; border-radius:10px;">
        <h3 class="menu-name" style="margin:12px 0 15px; font-weight:600; font-size:1.1rem;">{{ $menu->nama }}</h3>
        <div class="menu-buttons">
          <button 
            onclick="showMenu2(
              '{{ addslashes($menu->nama) }}', 
              '{{ $menu->harga }}', 
              '{{ addslashes($menu->status) }}'
            )"
            style="
              background:#6A4827; 
              color:#FFF; 
              border:none; 
              padding:10px 20px; 
              border-radius:12px; 
              font-weight:600; 
              font-size:1rem; 
              cursor:pointer; 
              box-shadow:0 4px 8px rgba(0,0,0,0.2);
              transition:0.2s;"
            onmouseover="this.style.transform='scale(1.05)'; this.style.background='#7b5330';"
            onmouseout="this.style.transform='scale(1)'; this.style.background='#6A4827';"
          >Lihat</button>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>


<!-- ===== Popup Detail Menu ===== -->
<div id="menuPopup2" class="popup-overlay">
  <div class="popup-box shadow-lg rounded-4">
    <div class="popup-header d-flex justify-content-between align-items-center mb-3">
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

<!-- ===== CSS ===== -->
<style>
  /* ===== Grid Menu ===== */
  .menu-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr); /* 5 kolom tetap di desktop */
    gap: 25px;
    justify-content: center;
    margin-top: 30px;
  }

  /* ===== Menu Item ===== */
  .menu-item {
    background: #815b3b; /* hanya warna item */
    color: #fff;
    text-align: center;
    padding: 15px;
    border-radius: 15px;
    overflow: hidden;
    transition: transform 0.2s;
  }
  .menu-item:hover {
    transform: translateY(-5px);
  }
  .menu-item img {
    width: 100%;
    height: 160px;
    object-fit: cover;
    border-radius: 10px;
  }
  .menu-name {
    margin: 12px 0 15px;
    font-weight: 600;
    font-size: 1.1rem;
  }

  /* ===== Tombol Lihat ===== */
  .btn-detail {
    background: #6A4827;
    border: none;
    color: #FFF;
    padding: 8px 18px;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    box-shadow: 0 3px 6px rgba(0,0,0,0.2);
    transition: transform 0.2s;
  }
  .btn-detail:hover {
    transform: scale(1.05);
  }

  /* ===== Popup ===== */
  .popup-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.6);
    justify-content: center;
    align-items: center;
    z-index: 9999;
  }
  .popup-box {
    background: #4B3621;
    color: #FFF;
    padding: 25px;
    width: 400px;
    max-width: 90%;
    border-radius: 10px;
    position: relative;
  }
  .popup-header h3 {
    margin: 0;
    font-size: 20px;
  }
  .popup-close-btn {
    background: #D32F2F;
    color: #FFF;
    border: none;
    padding: 5px 12px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
  }
  .popup-table {
    width: 100%;
    border-collapse: collapse;
  }
  .popup-table th, .popup-table td {
    text-align: left;
    padding: 8px;
  }

  /* ===== Responsif ===== */
  @media (max-width: 1200px) {
    .menu-grid {
      grid-template-columns: repeat(4, 1fr);
    }
  }
  @media (max-width: 992px) {
    .menu-grid {
      grid-template-columns: repeat(3, 1fr);
    }
  }
  @media (max-width: 768px) {
    .menu-grid {
      grid-template-columns: repeat(2, 1fr);
      gap: 15px;
    }
    .menu-item img {
      height: 140px;
    }
    .popup-box {
      width: 90%;
    }
  }
  @media (max-width: 480px) {
    .menu-grid {
      grid-template-columns: 1fr;
    }
    .menu-item img {
      height: 120px;
    }
  }
</style>

<!-- ===== JS Popup ===== -->
<script>
  function showMenu2(nama, harga, status) {
    // Tampilkan nama
    document.getElementById('popupName2').innerText = nama;

    // Tampilkan harga + huruf K
    document.getElementById('popupPrice2').innerText = harga + 'K';

    // Tampilkan status
    document.getElementById('popupStatus2').innerText = status;

    // Tampilkan popup
    document.getElementById('menuPopup2').style.display = 'flex';
  }

  function closeMenu2() {
    document.getElementById('menuPopup2').style.display = 'none';
  }
</script>

