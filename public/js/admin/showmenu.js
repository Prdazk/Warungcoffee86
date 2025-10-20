document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('modal-lihat');
    const modalNama = document.getElementById('modal-nama');
    const modalHarga = document.getElementById('modal-harga');
    const modalKategori = document.getElementById('modal-kategori');
    const modalStatus = document.getElementById('modal-status');
    const modalGambar = document.getElementById('modal-gambar');
    const modalClose = document.getElementById('modal-close');

    // Fungsi global untuk tombol Lihat
    window.showMenu = function(name, harga, kategori, status, gambar) {
        modalNama.innerText = name;
        modalHarga.innerText = Number(harga).toLocaleString('id-ID');
        modalKategori.innerText = kategori;
        modalStatus.innerText = status;

        if(gambar){
            modalGambar.src = gambar;
            modalGambar.alt = name;
            modalGambar.style.display = 'block';
        } else {
            modalGambar.style.display = 'none';
        }

        modal.classList.add('show');
    }

    // Tutup modal klik tombol X
    modalClose.addEventListener('click', function() {
        modal.classList.remove('show');
    });

    // Tutup modal klik di luar modal-content
    window.addEventListener('click', function(e) {
        if(e.target === modal){
            modal.classList.remove('show');
        }
    });
});
