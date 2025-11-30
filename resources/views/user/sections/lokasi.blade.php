<section id="lokasi" class="lokasi" style="margin-top: 5px; margin-bottom: 80px;">
  <div class="container">
    
    <div class="lokasi-wrapper text-center">
      
      <div class="lokasi-header">
        <h2 class="lokasi-title">LOKASI KAMI</h2>
      </div>

      <div class="map-frame">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.885884733737!2d111.61082828885498!3d-7.477851999999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e79c5b605deb7bd%3A0xebe9fa230d8bee10!2sTaman%20Lembang%20Desa%20Ngale!5e0!3m2!1sid!2sid!4v1758192257827!5m2!1sid!2sid"
          allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
        </iframe>
      </div>
      
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
/* 1. WRAPPER UTAMA */
.lokasi-wrapper {
    position: relative;
    padding-top: 25px;
}

/* 2. JUDUL (Badge Emas) */
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

/* 3. FRAME PETA */
.map-frame {
    width: 100%;
    height: 500px; /* Tinggi Laptop Besar */
    border-radius: 20px;
    overflow: hidden;
    border: 3px solid #e0a96d;
    box-shadow: 0 15px 40px rgba(0,0,0,0.5);
    background: #2d1f16;
    position: relative;
    z-index: 1;
}

.map-frame iframe {
    width: 100%;
    height: 100%;
    border: 0;
    display: block;
    filter: contrast(1.1) opacity(0.95);
}

/* 4. KONTAK GRID */
.contact-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr); /* 3 Kolom di Laptop */
    gap: 15px; /* Gap sedikit dirapatkan */
    margin-top: 30px;
}

/* KOTAK KONTAK (ITEM) - DIPERKECIL */
.contact-item {
    background: rgba(45, 31, 22, 0.6);
    border: 1px solid rgba(224, 169, 109, 0.3);
    
    border-radius: 10px; /* Radius sedikit dikecilkan */
    
    /* PADDING DIKURANGI AGAR LEBIH RAMPING */
    padding: 10px 15px; 
    
    display: flex;
    align-items: center;
    justify-content: center; /* Posisi Tengah */
    gap: 12px;
    transition: all 0.3s ease;
    text-decoration: none;
}

.link-item:hover {
    background: rgba(224, 169, 109, 0.1);
    border-color: #e0a96d;
    transform: translateY(-3px);
}

/* KOTAK IKON - DIPERKECIL */
.icon-box {
    /* UKURAN DIPERKECIL DARI 50px KE 42px */
    width: 42px;
    height: 42px;
    
    background: #2d1f16;
    border: 1px solid #e0a96d;
    
    border-radius: 8px; /* Radius menyesuaikan */
    
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px; /* Ikon menyesuaikan */
    color: #e0a96d;
    flex-shrink: 0;
}

/* Khusus Gambar PNG (Email) */
.custom-icon-img {
    width: 55%;
    height: 55%;
    object-fit: contain;
}

/* TEKS */
.text-box {
    display: flex;
    flex-direction: column;
    text-align: left;
}

.text-box .label {
    font-size: 0.7rem; /* Font Label diperkecil */
    color: #aaa;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 2px;
}

.text-box .value {
    font-size: 0.85rem; /* Font Isi diperkecil */
    color: #fff;
    font-weight: 600;
}

/* 5. RESPONSIVE HP */
@media (max-width: 768px) {
    .map-frame {
        height: 350px; /* Tinggi di HP */
    }

    .lokasi-title {
        font-size: 1rem;
        padding: 8px 25px;
    }

    .contact-grid {
        grid-template-columns: 1fr; /* 1 Kolom di HP */
        gap: 10px;
    }
    
    .contact-item {
        padding: 12px 15px;
        justify-content: flex-start; /* Di HP rata kiri lebih rapi */
    }
}
</style>