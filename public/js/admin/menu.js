function showMenu(name, harga, kategori, status, gambar){
    const modal = document.getElementById('modal-lihat');
    document.getElementById('modal-nama').innerText = name;
    document.getElementById('modal-harga').innerText = 'Rp ' + Number(harga).toLocaleString('id-ID');
    document.getElementById('modal-kategori').innerText = kategori;
    document.getElementById('modal-status').innerText = status;
    document.getElementById('modal-gambar').src = gambar;
    document.getElementById('modal-gambar').alt = name;
    
    modal.classList.add('show');
}

document.getElementById('modal-close').addEventListener('click', function(){
    document.getElementById('modal-lihat').classList.remove('show');
});

window.addEventListener('click', function(e){
    const modal = document.getElementById('modal-lihat');
    if(e.target === modal){
        modal.classList.remove('show');
    }
});
