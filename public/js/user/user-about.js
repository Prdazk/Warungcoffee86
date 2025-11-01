document.addEventListener('DOMContentLoaded', () => {
    // Ambil semua about-wrapper, jadi bisa multiple sections
    const aboutWrappers = document.querySelectorAll('.about-wrapper');

    if (aboutWrappers.length > 0) {
        // Intersection Observer untuk animasi fade-in + slide-up
        const observerOptions = { threshold: 0.2 };
        const aboutObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    // Bisa di-unobserve jika tidak ingin animasi berulang
                    // aboutObserver.unobserve(entry.target);
                }
            });
        }, observerOptions);

        aboutWrappers.forEach(wrapper => {
            aboutObserver.observe(wrapper);

            // Animasi click berulang
            wrapper.addEventListener('click', () => {
                wrapper.classList.remove('click-effect'); // reset animasi
                void wrapper.offsetWidth; // trigger reflow untuk restart animasi
                wrapper.classList.add('click-effect');  // jalankan animasi
            });

            // Optional: hover effect tambahan (smooth scale)
            wrapper.addEventListener('mouseenter', () => {
                wrapper.style.transform = 'translateY(-5px)';
            });
            wrapper.addEventListener('mouseleave', () => {
                wrapper.style.transform = 'translateY(0)';
            });
        });
    }
});
