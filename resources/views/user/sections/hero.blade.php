<section id="hero" class="hero-section">
  <div class="container">
    
    <div class="hero-wrapper">
      
      <div class="hero-text">
        
        <span class="hero-badge">WARUNGCOFFEE86</span>

        <h1 class="hero-title">
          Nikmati Rasa <br> 
          <span class="highlight">Kopi Sebenarnya</span>
        </h1>

        <p class="hero-subtitle">
          Rasakan kehangatan dalam setiap cangkir. Dibuat dari biji kopi pilihan 
          dan disajikan dengan sepenuh hati.
        </p>

        <div class="hero-buttons">
        <a href="#popular-menu" class="nav-link" 
        style="background: #e0a96d; color: #2d1f16; padding: 10px 30px; border-radius: 50px; text-decoration: none; font-weight: bold; font-size: 14px; box-shadow: 0 4px 15px rgba(224, 169, 109, 0.4); display: inline-block;">
            Lihat Menu
        </a>
    </div>

      </div>

      <div class="hero-image">
        <img src="{{ asset('images/logonya.png') }}" alt="Logo Warung Coffee">
      </div>

    </div>

  </div>
</section>

<style>
/* ========================================= */
/* 1. STYLE UMUM (LAPTOP/DESKTOP)            */
/* ========================================= */
.hero-section {
    padding: 40px 20px;
    margin-top: 60px;
    min-height: 80vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.hero-wrapper {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 40px;
    max-width: 1000px;
    width: 100%;
    margin: 0 auto;
}

.hero-text {
    flex: 1;
    max-width: 500px;
}

.hero-badge {
    background: rgba(224, 169, 109, 0.15);
    color: #e0a96d;
    padding: 6px 16px;
    border-radius: 20px;
    border: 1px solid #e0a96d;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    display: inline-block;
    margin-bottom: 15px;
}

.hero-title {
    font-size: 2.8rem; /* Ukuran Laptop */
    font-weight: 800;
    line-height: 1.2;
    color: #fff;
    margin-bottom: 15px;
}

.highlight {
    color: #e0a96d;
}

.hero-subtitle {
    font-size: 0.95rem;
    color: #ccc;
    line-height: 1.6;
    margin-bottom: 25px;
    font-weight: 300;
}

.hero-buttons {
    display: flex;
    gap: 15px;
}

/* Style Tombol Default (Laptop) */
.btn-utama, .btn-outline {
    padding: 12px 30px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 14px;
    text-decoration: none;
    transition: 0.3s;
}

.btn-utama {
    background: #e0a96d;
    color: #2d1f16;
    box-shadow: 0 5px 15px rgba(224, 169, 109, 0.4);
}

.btn-outline {
    border: 2px solid #e0a96d;
    color: #e0a96d;
}

.btn-utama:hover, .btn-outline:hover {
    transform: translateY(-3px);
    opacity: 0.9;
}

.hero-image {
    flex: 1;
    display: flex;
    justify-content: flex-end;
}

.hero-image img {
    width: 100%;
    max-width: 380px;
    height: auto;
    filter: drop-shadow(0 10px 20px rgba(0,0,0,0.5));
    animation: floating 3s ease-in-out infinite;
}

@keyframes floating {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
    100% { transform: translateY(0px); }
}

/* ========================================= */
/* 2. RESPONSIVE HP (PERBAIKAN DI SINI)      */
/* ========================================= */
@media (max-width: 768px) {
    .hero-section {
        padding: 20px 20px; /* Padding section dikurangi */
        min-height: auto;
    }

    .hero-wrapper {
        flex-direction: column-reverse; /* Logo di Atas */
        text-align: center;
        gap: 15px; /* Jarak antara logo dan teks dirapatkan */
    }

    .hero-text {
        max-width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    /* Badge lebih kecil */
    .hero-badge {
        font-size: 10px;
        padding: 4px 12px;
        margin-bottom: 10px;
    }

    /* Judul DIPERKECIL agar tidak memenuhi layar */
    .hero-title {
        font-size: 1.75rem; /* Sebelumnya 2rem+, sekarang 1.75rem */
        margin-bottom: 10px;
    }

    /* Deskripsi lebih ringkas */
    .hero-subtitle {
        font-size: 0.8rem; /* Huruf lebih kecil */
        max-width: 300px;
        margin-bottom: 20px;
        line-height: 1.5;
    }

    /* Tombol LEBIH RAMPING */
    .hero-buttons {
        gap: 10px;
    }

    .btn-utama, .btn-outline {
        padding: 8px 24px;   /* Padding diperkecil (Slim) */
        font-size: 12px;     /* Font tombol diperkecil */
        border-width: 1.5px; /* Garis outline lebih tipis */
    }

    /* Gambar Logo LEBIH KECIL */
    .hero-image {
        margin-bottom: 5px;
    }

    .hero-image img {
        max-width: 180px; /* Logo diperkecil dari 220px ke 180px */
    }
}
</style>