<section id="lokasi" class="lokasi" style="margin-top: 0px; margin-bottom: 80px;">
  <div class="container">
    
    <div class="lokasi-wrapper text-center">
      
      <!-- JUDUL -->
      <div class="lokasi-header">
        <h2 class="lokasi-title">LOKASI KAMI</h2>
      </div>

      <!-- MAP -->
      <div class="map-frame">

        <!-- CLICKABLE MAP OVERLAY -->
        <a href="https://maps.app.goo.gl/r2T3dYCPC1Jp5Zwi8"
           target="_blank"
           class="map-click-layer"></a>

        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.885884733737!2d111.61082828885498!3d-7.477851999999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e79c5b605deb7bd%3A0xebe9fa230d8bee10!2sTaman%20Lembang%20Desa%20Ngale!5e0!3m2!1sid!2sid!4v1758192257827!5m2!1sid!2sid"
          allowfullscreen=""
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade">
        </iframe>
      </div>
      
      <!-- CONTACT GRID -->
      <div class="contact-grid">
        
        <div class="contact-item">
            <div class="icon-box">
                <img src="{{ asset('images/jam.png') }}" alt="Email" class="custom-icon-img">
            </div>
            <div class="text-box">
                <span class="label">Jam Operasional</span>
                <span class="value">08.00 - 22.00 WIB</span>
            </div>
        </div>

        <a href="https://wa.me/6285792846420" target="_blank" class="contact-item link-item">
            <div class="icon-box">
                <img src="{{ asset('images/wa.png') }}" alt="Email" class="custom-icon-img">
            </div>
            <div class="text-box">
                <span class="label">WhatsApp</span>
                <span class="value">0812-3456-7890</span>
            </div>
        </a>

        <a href="mailto:warung86@gmail.com" class="contact-item link-item">
            <div class="icon-box">
                <img src="{{ asset('images/email.png') }}" alt="Email" class="custom-icon-img">
            </div>
            <div class="text-box">
                <span class="label">Email</span>
                <span class="value">warung86@gmail.com</span>
            </div>
        </a>

      </div>

    </div>

  </div>
</section>

<style>
/* WRAPPER */
.lokasi-wrapper {
    position: relative;
    padding-top: 25px;
}

/* JUDUL */
.lokasi-header {
    display: flex;
    justify-content: center;
    margin-bottom: -28px;
    position: relative;
    z-index: 10;
}

.lokasi-title {
    background: #2d1f16;
    color: #e0a96d;
    border: 2px solid #e0a96d;
    padding: 10px 40px;
    border-radius: 50px;
    font-size: 1.3rem;
    font-weight: 800;
    letter-spacing: 2px;
    text-transform: uppercase;
    box-shadow: 0 5px 20px rgba(0,0,0,0.6);
}

/* MAP */
.map-frame {
    width: 100%;
    height: 500px;
    border-radius: 20px;
    overflow: hidden;
    border: 3px solid #e0a96d;
    background: #2d1f16;
    position: relative;
    box-shadow: 0 15px 40px rgba(0,0,0,0.5);
}

/* LAYER YANG BISA DIKLIK */
.map-click-layer {
    position: absolute;
    inset: 0;
    z-index: 5;
    cursor: pointer;
}

/* MAP IFRAME */
.map-frame iframe {
    width: 100%;
    height: 100%;
    border: 0;
    filter: contrast(1.1) opacity(0.95);
}

/* CONTACT GRID */
.contact-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
    margin-top: 30px;
}

.contact-item {
    background: rgba(45, 31, 22, 0.6);
    border: 1px solid rgba(224, 169, 109, 0.3);
    border-radius: 10px;
    padding: 10px 15px;
    display: flex;
    gap: 12px;
    align-items: center;
    text-decoration: none;
    transition: 0.3s ease;
}

.link-item:hover {
    background: rgba(224, 169, 109, 0.1);
    border-color: #e0a96d;
    transform: translateY(-3px);
}

.icon-box {
    width: 42px;
    height: 42px;
    background: #2d1f16;
    border: 1px solid #e0a96d;
    border-radius: 8px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.custom-icon-img {
    width: 55%;
    height: 55%;
}

/* TEXT */
.text-box {
    display: flex;
    flex-direction: column;
}

.text-box .label {
    font-size: 0.7rem;
    color: #aaa;
    letter-spacing: 0.5px;
}

.text-box .value {
    font-size: 0.85rem;
    font-weight: 600;
    color: #fff;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .map-frame {
        height: 350px;
    }
    .contact-grid {
        grid-template-columns: 1fr;
        gap: 10px;
    }
    .contact-item {
        justify-content: flex-start;
    }
    .lokasi-title {
        font-size: 1rem;
        padding: 8px 25px;
    }
}
</style>
