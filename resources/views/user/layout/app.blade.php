<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Warung Coffee 86</title>

  {{-- CSS Global --}}
  <link rel="stylesheet" href="{{ asset('css/user/dashboard.css') }}">
  <link rel="stylesheet" href="{{ asset('css/user/menu.css') }}">
  <link rel="stylesheet" href="{{ asset('css/user/vasi.css') }}">
  <link rel="stylesheet" href="{{ asset('css/user/tentang.css') }}">
  <link rel="stylesheet" href="{{ asset('css/user/lokasi.css') }}">
  <link rel="stylesheet" href="{{ asset('css/user/about.css') }}">
  <link rel="stylesheet" href="{{ asset('css/user/popupmenu.css') }}">
</head>
<body>
  <div class="page-wrapper">
    @include('user.partials.header')

    {{-- semua section --}}
    @include('user.sections.hero')
    @include('user.sections.menu')
    @include('user.sections.reservasi')
    @include('user.sections.lokasi')
    @include('user.sections.about')
  </div>
<script>
document.addEventListener("DOMContentLoaded", () => {
  const links = document.querySelectorAll('.nav-link');

  // Ambil semua elemen section termasuk yang pakai div dengan id
  const sections = [
    document.getElementById('hero'),
    document.getElementById('popular-menu'),
    document.getElementById('reservasi'),
    document.getElementById('lokasi'),
    document.getElementById('about')
  ].filter(Boolean); // hapus null jika ada yang tidak ditemukan

  links.forEach(link => {
    link.addEventListener('click', e => {
      e.preventDefault();
      const target = link.getAttribute('href').replace('#', '');
      const targetEl = document.getElementById(target);

      if (!targetEl) return; // jika id tidak ditemukan, abaikan

      if (target === 'hero') {
        // tampilkan semua section
        sections.forEach(s => s.style.display = 'block');
        window.scrollTo({ top: 0, behavior: 'smooth' });
      } else {
        // sembunyikan semua lalu tampilkan hanya 1
        sections.forEach(s => s.style.display = 'none');
        targetEl.style.display = 'block';
        window.scrollTo({ top: 0, behavior: 'smooth' });
      }
    });
  });
});
</script>
</body>
</html>
