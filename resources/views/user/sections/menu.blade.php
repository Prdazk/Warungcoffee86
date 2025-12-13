<style>
/* ====== CSS UTAMA ====== */
.menu-grid {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 70px; 
    align-items: start;
}

/* TAMBAHAN BARU: Mengatur jarak Judul Kategori (Makanan/Minuman) */
.category-title {
    text-align: center;
    color: #e0a96d;
    margin-bottom: 15px !important; /* KUNCI: Jarak ke menu diperkecil (Rapat) */
    margin-top: 10px !important;
    font-size: 2rem; /* Ukuran font judul */
}

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
    transition: all 0.3s ease;
}
.menu-item img {
    width: 100%;           
    height: 160px;         
    object-fit: contain;
    border: none !important;
    outline: none !important;
    background: transparent !important;
    border-radius: 0;
    margin-bottom: 10px;
    filter: drop-shadow(0px 8px 8px rgba(0,0,0,0.4)); 
}
.menu-name {
    font-size: 1.1rem; 
    color: #e0a96d;
    margin-top: 5px;
    font-weight: bold;
    line-height: 1.2; 
}
.menu-detail p {
    font-size: 0.95rem; 
    color: #fff;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.8);
    margin-top: 3px;
}

/* Update Bagian Media Query (HP) Ini Saja */
@media (max-width: 480px) {
    .menu-grid {
        grid-template-columns: repeat(3, 1fr) !important;
        column-gap: 25px; 
        row-gap: 0px; 
        margin-top: -85px !important; 
    }

    .category-title {
        font-size: 1.8rem;
        margin-bottom: 0px !important; 
        position: relative;
        z-index: 100; 
        margin-top: 10px !important; 
    }

    .menu-item {
        min-height: auto !important; 
        height: auto !important;
        padding-bottom: 15px !important; 
        overflow: visible !important; 
        position: relative; 
    }

    /* === PENGATURAN POSISI & LAYER (Disesuaikan untuk Gambar Besar) === */
    
    /* Baris 1: Paling Atas */
    .menu-item:nth-child(-n+3) {
        z-index: 30; 
    }

    /* Baris 2: Ditarik LEBIH KUAT (-130px) karena gambar makin besar */
    .menu-item:nth-child(n+4):nth-child(-n+6) {
        z-index: 20;
        margin-top: -130px !important; /* SEBELUMNYA -115px. Ditambah biar tetap rapat */
    }

    /* Baris 3 dst */
    .menu-item:nth-child(n+7) {
        z-index: 10;
        margin-top: -130px !important;
    }

    /* ========================================= */

    .menu-item img { 
        height: 250px; /* SEBELUMNYA 190px. Saya perbesar agar lebih jelas */
        margin-bottom: 10px !important; 
        object-position: bottom; 
    }
    
    .menu-name { 
        font-size: 0.9rem; 
        margin-top: 0px !important; 
        z-index: 2; 
    }

    .menu-detail p { 
        font-size: 0.8rem;
        padding-bottom: 5px; 
        text-shadow: none !important; 
        font-weight: 600; 
        position: relative;
        z-index: 50; 
    }
    
    /* === LOGIKA ZIG-ZAG === */
    /* Item Tengah Baris 1 */
    .menu-item:nth-child(3n+2) { 
        margin-top: 55px; 
    }

    /* Koreksi Item Tengah Baris 2 ke bawah */
    /* Hitungan Baru: -130px (tarik) + 55px (zig-zag) = -75px */
    .menu-item:nth-child(n+4):nth-child(3n+2) {
        margin-top: -75px !important; 
    }
}
</style>

<section id="popular-menu" class="menu-section" style="margin-top: 50px;">
  <div class="container">
    <h3 class="menu-title text-center mb-4" style="margin-top: -10px;">MENU TERPOPULER</h3>

    <h3 class="category-title" style="font-family: 'Brush Script MT', cursive;">Makanan</h3>
    <div class="menu-grid-wrapper">
      <div class="menu-grid" id="makananGrid"></div>
    </div>

    <h3 class="category-title" style="font-family: 'Brush Script MT', cursive;">Minuman</h3>
    <div class="menu-grid-wrapper">
      <div class="menu-grid" id="minumanGrid"></div>
    </div>
  </div>
</section>

<script>
// ======= FUNCTION UNTUK RENDER MENU =======
function renderMenus(menus) {
    const makananGrid = document.getElementById('makananGrid');
    const minumanGrid = document.getElementById('minumanGrid');

    makananGrid.innerHTML = '';
    minumanGrid.innerHTML = '';

    menus.forEach(menu => {
        const html = `
            <div class="menu-item">
                <img src="/images/${menu.gambar ? menu.gambar : 'kopi2.jpg'}" alt="${menu.nama}">
                <h3 class="menu-name">${menu.nama}</h3>
                <div class="menu-detail">
                    <p>${Number(menu.harga).toLocaleString('id-ID')}K
                        <span style="color: ${menu.status === 'Tersedia' ? '#c9ff70' : '#ff6b6b'}">
                            ${menu.status}
                        </span>
                    </p>
                </div>
            </div>
        `;
        if (menu.kategori === 'Makanan') {
            makananGrid.insertAdjacentHTML('beforeend', html);
        } else if (menu.kategori === 'Minuman') {
            minumanGrid.insertAdjacentHTML('beforeend', html);
        }
    });
}

// ======= FUNCTION UNTUK FETCH MENU DARI API =======
async function fetchMenus() {
    try {
        const response = await fetch('/api/menus');
        const data = await response.json();
        renderMenus(data);
    } catch (error) {
        console.error('Gagal fetch menu:', error);
    }
}

fetchMenus(); // pertama kali load
setInterval(fetchMenus, 1000);
</script>