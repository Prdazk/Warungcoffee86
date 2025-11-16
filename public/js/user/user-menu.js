document.addEventListener('DOMContentLoaded', () => {
    loadMenu();        // Ambil data menu saat halaman dibuka
    initRealtimeMenu(); // Aktifkan realtime update
});

/* ============================================================
   LOAD DATA MENU DARI SERVER
============================================================ */
function loadMenu() {
    fetch('/api/menu')
        .then(res => res.json())
        .then(data => renderMenu(data))
        .catch(err => console.error('Error load menu:', err));
}

/* ============================================================
   RENDER LIST MENU KE HALAMAN
============================================================ */
function renderMenu(menuList) {
    const container = document.getElementById('menuContainer');
    if (!container) return;

    container.innerHTML = '';

    if (menuList.length === 0) {
        container.innerHTML = `<p class="text-center text-muted">Tidak ada menu tersedia.</p>`;
        return;
    }

    menuList.forEach(item => {
        const card = document.createElement('div');
        card.classList.add('col-md-4', 'mb-3');

        card.innerHTML = `
            <div class="card shadow-sm">
                <img src="/storage/${item.foto}" class="card-img-top" alt="${item.nama}">
                <div class="card-body">
                    <h5 class="card-title">${item.nama}</h5>
                    <p class="card-text text-muted">${item.deskripsi ?? '-'}</p>
                    <p class="fw-bold">Rp ${Number(item.harga).toLocaleString()}</p>

                    <button class="btn btn-primary btn-sm w-100 mt-2" 
                        onclick="openDetail(${item.id})">
                        Detail
                    </button>

                    <button class="btn btn-success btn-sm w-100 mt-2" 
                        onclick="pesanMenu(${item.id})">
                        Pesan
                    </button>
                </div>
            </div>
        `;

        container.appendChild(card);
    });
}

/* ============================================================
   REALTIME UPDATE (OTOMATIS TANPA RELOAD)
   Trigger otomatis ketika admin menambah/mengedit/menghapus menu
============================================================ */
function initRealtimeMenu() {
    if (typeof Echo === 'undefined') return;

    Echo.channel('menu-update')
        .listen('MenuUpdated', () => {
            console.log('Menu diupdate oleh admin → refresh list');
            loadMenu();
        });
}

/* ============================================================
   BUTTON DETAIL
============================================================ */
function openDetail(id) {
    window.location.href = `/user/menu/${id}`;
}

/* ============================================================
   BUTTON PESAN
============================================================ */
function pesanMenu(id) {
    window.location.href = `/user/reservasi?menu_id=${id}`;
}
