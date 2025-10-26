document.addEventListener('DOMContentLoaded', function() {
    const userMenu = document.getElementById('userMenu');
    if (!userMenu) return;

    const dropdown = userMenu.querySelector('.user-dropdown');
    const notificationIcon = userMenu.querySelector('.notification-icon');
    const notificationBadge = userMenu.querySelector('.notification-badge');

    if (!dropdown) return;

    // Toggle dropdown saat klik userMenu (kecuali klik tombol/anchor)
    userMenu.addEventListener('click', function(e) {
        if(e.target.closest('.notification-btn') || e.target.closest('a') || e.target.closest('button')) return;
        e.stopPropagation();
        userMenu.classList.toggle('active');
    });

    // Tutup dropdown ketika klik di luar
    document.addEventListener('click', function() {
        userMenu.classList.remove('active');
    });

    // Efek notifikasi jika ada reservation baru
    if(notificationBadge) {
        // Tambahkan efek pulse ke badge, bukan userMenu
        notificationBadge.classList.add('new');

        // Opsional: animasi pulse sekali setiap beberapa detik
        setInterval(() => {
            notificationBadge.classList.add('new');
            setTimeout(() => {
                notificationBadge.classList.remove('new');
            }, 1000);
        }, 5000);
    }
});
