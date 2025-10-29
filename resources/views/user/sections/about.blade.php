<!-- ===== Section Tentang / About ===== -->
<section id="about" class="about-section" style="min-height:600px; display:flex; align-items:center; justify-content:center; padding:50px 20px;">
  <div class="about-wrapper" style="max-width:900px; text-align:center; cursor:pointer;">
    
    <!-- Judul -->
    <h2 style="font-size:2rem; font-weight:700; color:#b3885d; margin-bottom:30px;">Tentang</h2>
    
    <!-- Paragraf -->
    <p style="margin-bottom:15px; font-size:1rem; line-height:1.6; color:#f1f1f1;">
      WarungCoffee86 adalah tempat di mana kopi berkualitas tinggi bertemu dengan suasana nyaman.
      Kami menghadirkan pengalaman kopi terbaik bagi setiap pengunjung dengan cita rasa lokal dan pelayanan ramah.
    </p>
    <p style="margin-bottom:15px; font-size:1rem; line-height:1.6; color:#f1f1f1;">
      Setiap cangkir dibuat dengan perhatian penuh terhadap biji kopi dan proses penyeduhan.
      WarungCoffee86 bukan hanya tempat ngopi, tapi juga ruang berkumpul dan berbagi cerita.
    </p>
    <p style="margin-bottom:0; font-size:1rem; line-height:1.6; color:#f1f1f1;">
      Dengan desain interior hangat dan pelayanan profesional,
      kami berkomitmen memberikan pengalaman yang tak terlupakan untuk setiap tamu.
    </p>
    
  </div>
</section>

<style>
/* Fade-in + slide-up section About */
.about-wrapper {
    opacity: 0;
    transform: translateY(50px);
    transition: all 0.8s ease-out;
}
.about-wrapper.visible {
    opacity: 1;
    transform: translateY(0);
}

/* Klik-trigger animasi berulang */
.about-wrapper.click-effect {
    animation: clickAnim 0.6s ease;
}
@keyframes clickAnim {
    0% { transform: translateY(0); opacity: 1; }
    50% { transform: translateY(-15px); opacity: 0.8; }
    100% { transform: translateY(0); opacity: 1; }
}
</style>

<script>
// Intersection Observer untuk animasi awal About
const aboutWrapper = document.querySelector('.about-wrapper');

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
</script>
