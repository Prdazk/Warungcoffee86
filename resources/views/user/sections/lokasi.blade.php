<section id="lokasi" class="lokasi">
  <div class="kontak-wrapper">
    <div class="kontak-info">
      <h2>Kontak Kami</h2>
      <div class="info-grid">
        <div class="info-item">
          <img src="{{ asset('images/email.png') }}" alt="Email">
          <h3>Email</h3>
          <p>email@warung86.com</p>
        </div>
        <div class="info-item">
          <img src="{{ asset('images/wa.png') }}" alt="WhatsApp">
          <h3>WhatsApp</h3>
          <p>+62 812 3456 7890</p>
        </div>
        <div class="info-item">
          <img src="{{ asset('images/jam.png') }}" alt="Jam Operasi">
          <h3>Jam Operasi</h3>
          <p>07:00 - 22:00</p>
        </div>
      </div>
    </div>
    <div class="kontak-image">
      <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.885884733737!2d111.61082828885498!3d-7.477851999999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e79c5b605deb7bd%3A0xebe9fa230d8bee10!2sTaman%20Lembang%20Desa%20Ngale!5e0!3m2!1sid!2sid!4v1758192257827!5m2!1sid!2sid" 
        width="100%" height="400" allowfullscreen loading="lazy"></iframe>
    </div>
  </div>
</section>

<style>
/* Fade-in + slide-up section */
.kontak-wrapper {
    opacity: 0;
    transform: translateY(50px);
    transition: all 0.8s ease-out;
}
.kontak-wrapper.visible { opacity: 1; transform: translateY(0); }

.kontak-image {
    opacity: 0;
    transform: translateX(50px);
    transition: all 0.8s ease-out 0.2s;
}
.kontak-image.visible { opacity: 1; transform: translateX(0); }

.kontak-info h2 {
    opacity: 0;
    transform: translateY(-20px);
    transition: all 0.8s ease-out;
}
.kontak-info h2.visible { opacity: 1; transform: translateY(0); }

/* Info-item hover */
.info-item {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    cursor: pointer;
}
.info-item:hover {
    transform: translateY(-8px) scale(1.05);
    box-shadow: 0 8px 20px rgba(0,0,0,0.25);
}

/* Efek klik (bisa diulang) */
.info-item:active,
.info-item.click-effect {
    animation: clickAnim 0.3s ease;
}
@keyframes clickAnim {
    0% { transform: scale(1); box-shadow: 0 8px 20px rgba(0,0,0,0.25); }
    50% { transform: scale(0.9); box-shadow: 0 4px 10px rgba(0,0,0,0.3); }
    100% { transform: scale(1); box-shadow: 0 8px 20px rgba(0,0,0,0.25); }
}
</style>

<script>
// Intersection Observer untuk animasi muncul section
const wrapper = document.querySelector('.kontak-wrapper');
const map = document.querySelector('.kontak-image');
const title = document.querySelector('.kontak-info h2');

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

// Efek klik berulang untuk info-item
document.querySelectorAll('.info-item').forEach(item => {
    item.addEventListener('click', () => {
        item.classList.remove('click-effect'); // reset class
        void item.offsetWidth; // trigger reflow agar animasi bisa diulang
        item.classList.add('click-effect');
    });
});
</script>
