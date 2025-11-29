<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>COFFEE</title>

<style>
  body {
    margin: 0;
    font-family: Arial, sans-serif;
  }

  .site-header {
    width: 100%;
    background: #2b2b2b;
    color: white;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 999;
    transition: background 0.3s;
  }

  .nav-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 20px;
  }

  .logo {
    font-size: 22px;
    font-weight: bold;
    color: white;
    text-decoration: none;
    transition: color 0.3s;
  }

  /* HAMBURGER */
  .menu-toggle {
    display: none;
    flex-direction: column;
    gap: 5px;
    cursor: pointer;
    position: relative;
    width: 30px;
    height: 22px;
  }

  .menu-toggle span {
    display: block;
    height: 3px;
    width: 100%;
    background: white;
    border-radius: 5px;
    transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
  }

  /* Efek X keren */
  .menu-toggle.active span:nth-child(1) {
    transform: rotate(45deg) translate(5px, 5px);
    background: #e0a96d;
  }
  .menu-toggle.active span:nth-child(2) {
    opacity: 0;
    transform: scale(0);
  }
  .menu-toggle.active span:nth-child(3) {
    transform: rotate(-45deg) translate(5px, -5px);
    background: #e0a96d;
  }

  .main-nav {
    display: flex;
    gap: 22px;
  }

  .nav-link {
    color: white;
    text-decoration: none;
    font-size: 16px;
    position: relative;
    transition: color 0.3s;
  }

  .nav-link::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: -3px;
    width: 0%;
    height: 2px;
    background: #e0a96d;
    transition: width 0.3s;
  }
  .nav-link:hover::after {
    width: 100%;
  }

  /* MOBILE */
  @media (max-width: 768px) {
    .menu-toggle { display: flex; }

    .main-nav {
      position: absolute;
      top: 68px;
      left: 0;
      width: 100%;
      background: #2b2b2b;
      display: flex;
      flex-direction: column;
      padding: 0;
      border-top: 1px solid #444;
      opacity: 0;
      transform: translateY(-20px);
      pointer-events: none;
      transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    .main-nav.open {
      opacity: 1;
      transform: translateY(0);
      pointer-events: auto;
    }

    .nav-link {
      padding: 15px 20px;
      font-size: 17px;
      transition: all 0.3s;
    }

    .nav-link:hover {
      background: #3b3b3b;
    }
  }
</style>
</head>
<body>

<header class="site-header">
  <div class="nav-container">
    <a href="#hero" class="logo">COFFEE</a>

    <div class="menu-toggle" id="menuToggle">
      <span></span>
      <span></span>
      <span></span>
    </div>

    <nav class="main-nav" id="mainNav">
      <a href="#hero" class="nav-link">Beranda</a>
      <a href="#popular-menu" class="nav-link">Menu</a>
      <a href="#reservasi" class="nav-link">Reservasi</a>
      <a href="#lokasi" class="nav-link">Kontak</a>
      <a href="#about" class="nav-link">Tentang</a>
    </nav>
  </div>
</header>

<script>
const toggle = document.getElementById('menuToggle');
const nav = document.getElementById('mainNav');
const links = document.querySelectorAll('.nav-link');

toggle.addEventListener('click', () => {
  nav.classList.toggle('open');
  toggle.classList.toggle('active');
});

links.forEach(link => {
  link.addEventListener('click', () => {
    nav.classList.remove('open');
    toggle.classList.remove('active');
  });
});

document.addEventListener('click', (e) => {
  if(!nav.contains(e.target) && !toggle.contains(e.target)){
    nav.classList.remove('open');
    toggle.classList.remove('active');
  }
});
</script>

</body>
</html>
