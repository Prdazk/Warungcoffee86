document.addEventListener("DOMContentLoaded", function() {
    const modal = document.getElementById("modalLihat");
    const modalGambar = document.getElementById("modalGambar");
    const modalNama = document.getElementById("modalNama");
    const modalHarga = document.getElementById("modalHarga");
    const modalKategori = document.getElementById("modalKategori");
    const modalStatus = document.getElementById("modalStatus");
    const spanClose = modal.querySelector(".close");

    window.showMenu = function(nama, harga, kategori, status, gambar) {
        modalGambar.src = gambar || "";
        modalGambar.style.display = gambar ? "block" : "none";
        modalNama.textContent = nama;
        modalHarga.textContent = Number(harga).toLocaleString('id-ID');
        modalKategori.textContent = kategori;
        modalStatus.textContent = status;
        modal.style.display = "flex"; // gunakan flex biar modal center
    };

    spanClose.onclick = function() {
        modal.style.display = "none";
    };

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
});
