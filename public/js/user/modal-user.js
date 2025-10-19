// Fungsi menampilkan modal menu untuk user
function showMenuUser(nama, harga, deskripsi, gambar) {
    document.getElementById('modalUserName').innerText = nama;
    document.getElementById('modalUserPrice').innerText = harga;
    document.getElementById('modalUserDesc').innerText = deskripsi;
    document.getElementById('modalUserImage').src = gambar || '';

    document.getElementById('modalUserMenu').style.display = 'block';
}

// Event listener untuk menutup modal
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('modalUserMenu');
    const closeBtn = modal.querySelector('.close');

    closeBtn.onclick = function () {
        modal.style.display = 'none';
    }

    window.onclick = function (event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    }
});
