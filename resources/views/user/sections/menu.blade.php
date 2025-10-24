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
/* ===== Overlay ===== */
.popup-overlay {
  display: none;
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.55);
  justify-content: center;
  align-items: center;
  z-index: 9999;
  font-family: 'Poppins', 'Segoe UI', sans-serif;
  backdrop-filter: blur(4px);
  animation: fadeIn 0.4s ease forwards;
}

/* ===== Kotak Popup ===== */
.popup-box {
  background: linear-gradient(160deg, #f9f4ef 0%, #fffaf5 100%);
  color: #3e2723;
  padding: 28px 32px;
  border-radius: 18px;
  box-shadow: 0 18px 45px rgba(0, 0, 0, 0.35);
  max-width: 420px;
  width: 90%;
  border: 1px solid #e0c8b0;
  transform: translateY(40px) scale(0.9);
  opacity: 0;
  animation: popupEnter 0.45s ease forwards;
}

/* ===== Animasi ===== */
@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}
@keyframes popupEnter {
  from {
    transform: translateY(40px) scale(0.9);
    opacity: 0;
  }
  to {
    transform: translateY(0) scale(1);
    opacity: 1;
  }
}

/* ===== Header Popup ===== */
.popup-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
  border-bottom: 2px solid #d7ccc8;
  padding-bottom: 8px;
}
.popup-header h3 {
  margin: 0;
  font-size: 22px;
  font-weight: 600;
  color: #4e342e;
  letter-spacing: 0.5px;
}

/* ===== Tombol Tutup ===== */
.popup-close-btn {
  background: linear-gradient(135deg, #6d4c41, #8d6e63);
  color: white;
  border: none;
  padding: 6px 14px;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 500;
  transition: all 0.3s ease;
}
.popup-close-btn:hover {
  background: linear-gradient(135deg, #5d4037, #795548);
  transform: rotate(8deg) scale(1.05);
}

/* ===== Tabel Popup ===== */
.popup-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 12px;
  overflow: hidden;
  border-radius: 10px;
  box-shadow: 0 4px 14px rgba(0,0,0,0.08);
  animation: tableFade 0.5s ease forwards;
}
@keyframes tableFade {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}
.popup-table th {
  text-align: left;
  font-weight: 600;
  color: #6d4c41;
  background: #fbe9e7;
  padding: 10px 14px;
  border-bottom: 1px solid #e0c8b0;
}
.popup-table td {
  text-align: right;
  color: #3e2723;
  background: #fffdfa;
  padding: 10px 14px;
  border-bottom: 1px solid #e0c8b0;
}

/* ===== Efek Hover Baris ===== */
.popup-table tr:hover td {
  background: #fff3e0;
  transition: background 0.3s ease;
}
</style>