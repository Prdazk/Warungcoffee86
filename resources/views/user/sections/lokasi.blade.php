<section id="lokasi" class="lokasi py-5" style="margin-top: 100px;">

  <div class="lokasi-container">
    
    <h2 class="lokasi-title">Lokasi Kami</h2>

    <div class="map-wrapper">
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.885884733737!2d111.61082828885498!3d-7.477851999999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e79c5b605deb7bd%3A0xebe9fa230d8bee10!2sTaman%20Lembang%20Desa%20Ngale!5e0!3m2!1sid!2sid!4v1758192257827!5m2!1sid!2sid"
        allowfullscreen="" loading="lazy">
      </iframe>
    </div>

  </div>
</section>

<style>
.lokasi-container {
  width: 90%;
  max-width: 1100px;
  margin: 0 auto;
  position: relative;
}

.lokasi-title {
  position: absolute;
  top: -25px;
  left: 50%;
  transform: translateX(-50%);
  background: #2d1f16;
  padding: 6px 20px;
  color: #e0a96d;
  font-weight: 700;
  letter-spacing: 1px;
  border-radius: 12px;
  font-size: 1.5rem;
  z-index: 10;
  text-align: center;
}

.map-wrapper {
  border-radius: 25px;
  overflow: hidden;
  box-shadow: 0 4px 18px rgba(0,0,0,.2);
  width: 100%;
  /* Trick responsif: tinggi mengikuti rasio 16:9 */
  aspect-ratio: 16/9;
}

.map-wrapper iframe {
  width: 100%;
  height: 100%;
  border: 0;
  display: block;
}
</style>
