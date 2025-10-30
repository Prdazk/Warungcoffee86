document.addEventListener('DOMContentLoaded', () => {
    const aboutWrapper = document.querySelector('.about-wrapper');

    if(aboutWrapper) {
        // Intersection Observer untuk animasi awal About
        const aboutObserver = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if(entry.isIntersecting){
                    aboutWrapper.classList.add('visible');
                }
            });
        }, { threshold: 0.2 });
        aboutObserver.observe(aboutWrapper);

        // Animasi berulang ketika klik
        aboutWrapper.addEventListener('click', () => {
            aboutWrapper.classList.remove('click-effect'); // reset
            void aboutWrapper.offsetWidth; // trigger reflow
            aboutWrapper.classList.add('click-effect');  // jalankan animasi
        });
    }
});
