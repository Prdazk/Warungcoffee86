document.addEventListener('DOMContentLoaded', () => {
    const wrapper = document.querySelector('.kontak-wrapper');
    const map = document.querySelector('.kontak-image');
    const title = document.querySelector('.kontak-info h2');

    if(wrapper && map && title) {
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if(entry.isIntersecting){
                    wrapper.classList.add('visible');
                    map.classList.add('visible');
                    title.classList.add('visible');
                }
            });
        }, { threshold: 0.2 });
        observer.observe(wrapper);
    }

    const infoItems = document.querySelectorAll('.info-item');
    infoItems.forEach(item => {
        item.addEventListener('click', () => {
            item.classList.remove('click-effect'); 
            void item.offsetWidth; 
            item.classList.add('click-effect');
        });
    });
});