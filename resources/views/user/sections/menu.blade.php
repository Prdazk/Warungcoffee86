<section id="popular-menu" class="menu-section">
  <div class="container">
    <h2 class="menu-title">MENU TERPOPULER</h2>
    <div class="menu-grid">
      @foreach ($menus as $menu)
        <div class="menu-item">
          <img src="{{ $menu->gambar ? asset('images/'.$menu->gambar) : asset('images/kopi2.jpg') }}" alt="{{ $menu->nama }}">
          <h3 class="menu-name">{{ $menu->nama }}</h3>
          <div class="menu-buttons">
            <button class="btn-view"
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
</section>

<script>
function showMenu2(name, price, status){
  document.getElementById('popupName2').innerText = name;
  document.getElementById('popupPrice2').innerText = Number(price).toLocaleString('id-ID');
  document.getElementById('popupStatus2').innerText = status || '-';
  document.getElementById('menuPopup2').style.display = 'flex';
}

function closeMenu2(){
  document.getElementById('menuPopup2').style.display = 'none';
}
</script>

<style>
/* Overlay */
.popup-overlay {
  display: none;
  position: fixed;
  top:0; left:0;
  width:100%; height:100%;
  background: rgba(0,0,0,0.5);
  justify-content:center;
  align-items:center;
  z-index: 9999;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Kotak popup */
.popup-box {
  background: #f5f0eb;
  color: #3e2723;
  padding: 20px 25px;
  border-radius: 12px;
  box-shadow: 0 12px 30px rgba(0,0,0,0.4);
  max-width: 380px;
  width: 90%;
  border: 1px solid #d7ccc8;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.popup-box:hover {
  transform: scale(1.02);
  box-shadow: 0 15px 35px rgba(0,0,0,0.5);
}

/* Header popup */
.popup-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 15px;
}
.popup-header h3 { margin:0; font-weight:600; }

/* Tombol Tutup */
.popup-close-btn {
  background:#6d4c41;
  color:white;
  border:none;
  padding:5px 12px;
  border-radius:6px;
  cursor:pointer;
  font-weight:bold;
  transition: background 0.2s, transform 0.2s;
}
.popup-close-btn:hover { background:#5d4037; transform:scale(1.05); }

/* Tabel popup */
.popup-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 10px;
}
.popup-table th, .popup-table td {
  padding: 8px 12px;
  border-left: 1px solid #d7ccc8;
  border-right: 1px solid #d7ccc8;
}
.popup-table th {
  text-align: left;
  font-weight:600;
  color:#6d4c41;
  background:#fff8f0;
}
.popup-table td {
  text-align: right;
  color:#3e2723;
  background:#fff8f0;
}
</style>
