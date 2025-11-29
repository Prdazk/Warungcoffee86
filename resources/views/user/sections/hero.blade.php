<section id="hero" class="hero-section">
  <div class="hero-container" style="
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:40px;
      max-width:1100px;
      margin:auto;
      padding:40px 20px;
  ">
    
    <div class="hero-text" style="
        flex:1;
    ">

      <p class="hero-subtitle" style="
          font-size:18px;
          margin-bottom:18px;
      ">Mari Nikmati Secangkir Kopi</p>

      <a href="#popular-menu" class="hero-cta" style="
          padding:12px 32px;
          background:#c49b66;
          border-radius:8px;
          text-decoration:none;
          color:#000;
          font-weight:600;
          font-size:15px;
          display:inline-block;
      ">Lihat Menu</a>
    </div>

    <div class="hero-image" style="
        flex:1;
        text-align:center;
    ">
      <img src="{{ asset('images/logonya.png') }}"
           style="width:100%; max-width:420px; height:auto;">
    </div>

  </div>
</section>

<style>
/* RESPONSIVE UNTUK HP */
@media (max-width: 768px) {

    #hero .hero-container {
        flex-direction: column-reverse;
        text-align: center;
        gap:20px;
        padding:25px 16px !important;
    }

    #hero .hero-text {
        text-align:center !important;
    }

    #hero .hero-title {
        font-size:32px !important;
    }

    #hero .hero-subtitle {
        font-size:14px !important;
    }

    #hero .hero-cta {
        padding:10px 24px !important;
        font-size:14px !important;
    }

    #hero .hero-image img {
        max-width:260px !important;
    }
}
</style>
