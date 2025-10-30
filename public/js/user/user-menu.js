document.addEventListener('DOMContentLoaded', function() {
    const popup = document.getElementById('menuPopup2');
    const popupBox = popup.querySelector('.popup-box');
    const popupName = document.getElementById('popupName2');
    const popupPrice = document.getElementById('popupPrice2');
    const popupStatus = document.getElementById('popupStatus2');
    const copyBtn = document.getElementById('copyPriceBtn');

    // Tampilkan popup dengan slide dari kanan
    const showPopup = () => {
        popup.style.display = 'flex';
        popupBox.classList.add('slide-in'); // class animasi
    };

    // Tutup popup langsung
    const hidePopup = () => {
        popup.style.display = 'none';
        popupBox.classList.remove('slide-in');
    };

    // Event tombol "Lihat"
    document.querySelectorAll('.btn-detail').forEach(button => {
        button.addEventListener('click', function() {
            popupName.innerText = this.dataset.nama;
            popupPrice.innerText = this.dataset.harga + 'K';
            popupStatus.innerText = this.dataset.status;

            button.classList.add('btn-click');
            setTimeout(() => button.classList.remove('btn-click'), 200);

            showPopup();
        });
    });

    // Tombol tutup
    const closeBtn = popup.querySelector('.popup-close-btn');
    closeBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        hidePopup();
    });

    // Tutup popup jika klik di luar box
    popup.addEventListener('click', function(e) {
        if (e.target === popup) hidePopup();
    });

    // Tombol salin harga
    if(copyBtn){
        copyBtn.addEventListener('click', () => {
            navigator.clipboard.writeText(popupPrice.innerText)
                .then(() => alert('Harga disalin ke clipboard!'))
                .catch(() => alert('Gagal menyalin.'));
        });
    }
});