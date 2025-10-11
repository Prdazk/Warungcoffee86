function showSection(section) {
    const sections = ['beranda', 'menu', 'reservasi'];
    sections.forEach(s => {
        const el = document.getElementById(s);
        if (el) el.style.display = (s === section) ? 'block' : 'none';
    });
}
