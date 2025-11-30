<section id="about" class="about-section">
  <div class="container">
    
    <div class="about-card">
      <span class="pre-title">Cerita Kami</span>
      <h2 class="about-title">TENTANG</h2>
      
      <div class="about-divider"></div>
      
      <div class="about-content">
        <p>
          Lebih dari sekadar kedai kopi, <span class="highlight">WarungCoffee86</span> adalah rumah bagi setiap cerita. Kami percaya bahwa kopi terbaik tidak perlu rumit, cukup diseduh dengan hati dan dinikmati bersama sahabat.
        </p>
        <p>
          Di sini, waktu berjalan sedikit lebih lambat. Lupakan hiruk-pikuk sejenak, duduklah dengan nyaman, dan biarkan aroma kopi kami menghangatkan suasana hati Anda.
        </p>
      </div>

    </div>

  </div>
</section>

<style>
/* 1. WRAPPER UTAMA */
.about-section {
    padding: 80px 20px;
    margin-top: 50px;
}

/* 2. KARTU TENTANG (Hanya Garis, Tanpa Background) */
.about-card {
    max-width: 750px;       /* Lebar sedikit dikecilkan biar teks lebih enak dibaca */
    margin: 0 auto;
    
    /* HAPUS BACKGROUND (Jadi transparan) */
    background: none; 
    
    /* Garis Emas Tipis */
    border: 1px solid rgba(224, 169, 109, 0.5); 
    
    padding: 60px 40px;     /* Padding lega */
    text-align: center;
    position: relative;
    border-radius: 4px;     /* Sudut sedikit lebih tegas */
}

/* Dekorasi Siku Emas (Pemanis) */
.about-card::before, .about-card::after {
    content: '';
    position: absolute;
    width: 20px;
    height: 20px;
    border: 2px solid #e0a96d;
    transition: 0.3s;
}
/* Siku Kiri Atas */
.about-card::before { top: -1px; left: -1px; border-right: 0; border-bottom: 0; }
/* Siku Kanan Bawah */
.about-card::after { bottom: -1px; right: -1px; border-left: 0; border-top: 0; }


/* 3. JUDUL */
.pre-title {
    display: block;
    font-size: 0.85rem;
    letter-spacing: 4px;    /* Huruf dijarangkan biar elegan */
    color: #e0a96d;
    text-transform: uppercase;
    margin-bottom: 10px;
}

.about-title {
    font-size: 2.2rem;
    font-weight: 700;
    color: #fff;
    margin: 0;
    letter-spacing: 2px;
}

/* 4. GARIS PEMISAH */
.about-divider {
    width: 50px;
    height: 2px;
    background: #e0a96d;
    margin: 25px auto;      /* Jarak atas bawah divider */
}

/* 5. ISI TEKS (Dibuat Nyaman Dibaca) */
.about-content p {
    color: #e0e0e0;         /* Warna mendekati putih tapi tidak silau */
    font-size: 1.05rem;     /* Ukuran font sedikit diperbesar */
    line-height: 1.8;       /* Jarak antar baris renggang */
    font-weight: 300;       /* Huruf agak tipis biar modern */
    margin-bottom: 25px;
}

.about-content p:last-child {
    margin-bottom: 0;
}

.highlight {
    color: #e0a96d;
    font-weight: 600;
}

/* 6. RESPONSIVE HP */
@media (max-width: 480px) {
    .about-card {
        padding: 40px 20px;
        border-color: rgba(224, 169, 109, 0.3); /* Border lebih tipis di HP */
    }

    .about-title {
        font-size: 1.8rem;
    }

    .about-content p {
        font-size: 0.95rem;
        line-height: 1.7;
    }
}
</style>