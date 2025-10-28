document.addEventListener("DOMContentLoaded", () => {
  const links = document.querySelectorAll('.nav-link');

  const sections = [
    document.getElementById('hero'),
    document.getElementById('popular-menu'),
    document.getElementById('reservasi'),
    document.getElementById('lokasi'),
    document.getElementById('about')
  ].filter(Boolean);

  links.forEach(link => {
    link.addEventListener('click', e => {
      e.preventDefault();
      const target = link.getAttribute('href').replace('#', '');
      const targetEl = document.getElementById(target);
      if (!targetEl) return;

      if (target === 'hero') {
        sections.forEach(s => s.style.display = 'block');
        window.scrollTo({ top: 0, behavior: 'smooth' });
      } else {
        sections.forEach(s => s.style.display = 'none');
        targetEl.style.display = 'block';
        window.scrollTo({ top: 0, behavior: 'smooth' });
      }
    });
  });
});
