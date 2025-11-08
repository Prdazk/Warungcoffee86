document.addEventListener('DOMContentLoaded', function() {
    // ======== POPUP MENU ========
    const popup = document.getElementById('menuPopup2');
    const popupBox = popup.querySelector('.popup-box');
    const popupName = document.getElementById('popupName2');
    const popupPrice = document.getElementById('popupPrice2');
    const popupStatus = document.getElementById('popupStatus2');
    const copyBtn = document.getElementById('copyPriceBtn');

    // Tampilkan popup dengan animasi slide
    const showPopup = () => {
        popup.style.display = 'flex';
        popupBox.classList.add('slide-in');
        popupBox.classList.remove('hide');
    };

    // Tutup popup
    const hidePopup = () => {
        popupBox.classList.add('hide');
        popupBox.classList.remove('slide-in');
        setTimeout(() => popup.style.display = 'none', 300); // delay sesuai animasi
    };

    // Event tombol "Lihat"
    document.querySelectorAll('.btn-detail').forEach(button => {
        button.addEventListener('click', function() {
            popupName.innerText = this.dataset.nama;
            popupPrice.innerText = this.dataset.harga + 'K';
            popupStatus.innerText = this.dataset.status;

            // Animasi tombol klik
            button.classList.add('btn-click');
            setTimeout(() => button.classList.remove('btn-click'), 200);

            showPopup();
        });
    });

    // Tombol tutup
    const closeBtn = popup.querySelector('.popup-close-btn');
    closeBtn.addEventListener('click', e => {
        e.stopPropagation();
        hidePopup();
    });

    // Tutup popup jika klik di luar box
    popup.addEventListener('click', e => {
        if(e.target === popup) hidePopup();
    });

    // Tombol salin harga (opsional)
    if(copyBtn){
        copyBtn.addEventListener('click', () => {
            navigator.clipboard.writeText(popupPrice.innerText)
                .then(() => alert('Harga disalin ke clipboard!'))
                .catch(() => alert('Gagal menyalin.'));
        });
    }

    // ======== SMOOTH HORIZONTAL SCROLL ========
    const wrappers = document.querySelectorAll('.menu-grid-wrapper');

    wrappers.forEach(wrapper => {
        let isDown = false, startX, scrollLeft;

        // Mouse events
        wrapper.addEventListener('mousedown', e => {
            isDown = true;
            wrapper.classList.add('active-grab');
            startX = e.pageX - wrapper.offsetLeft;
            scrollLeft = wrapper.scrollLeft;
        });

        wrapper.addEventListener('mouseleave', () => { isDown = false; wrapper.classList.remove('active-grab'); });
        wrapper.addEventListener('mouseup', () => { isDown = false; wrapper.classList.remove('active-grab'); });
        wrapper.addEventListener('mousemove', e => {
            if(!isDown) return;
            e.preventDefault();
            const x = e.pageX - wrapper.offsetLeft;
            const walk = (x - startX) * 1.8; // kecepatan santai tapi responsive
            wrapper.scrollLeft = scrollLeft - walk;
        });

        // Touch events (mobile)
        wrapper.addEventListener('touchstart', e => {
            startX = e.touches[0].pageX - wrapper.offsetLeft;
            scrollLeft = wrapper.scrollLeft;
        });

        wrapper.addEventListener('touchmove', e => {
            const x = e.touches[0].pageX - wrapper.offsetLeft;
            const walk = (x - startX) * 1.8;
            wrapper.scrollLeft = scrollLeft - walk;
        });
    });

    // ======== POINTER HOVER SCALE EFEK ========
    const allItems = document.querySelectorAll('.menu-item');
    allItems.forEach(item => {
        item.addEventListener('mousemove', e => {
            const rect = item.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const moveX = (x - rect.width/2) / 15; // geser horizontal
            const moveY = (y - rect.height/2) / 15; // geser vertikal
            item.style.transform = `scale(1.07) translate(${moveX}px, ${moveY}px)`;
        });
        item.addEventListener('mouseleave', () => {
            item.style.transform = 'scale(1.0) translate(0,0)';
        });
    });
});
