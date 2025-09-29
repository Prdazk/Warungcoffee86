// Fungsi untuk menampilkan section tertentu
function showSection(sectionId) {
  // sembunyikan semua section
  document.querySelectorAll('.content-section').forEach(sec => sec.classList.remove('active'));
  // tampilkan section yang dipilih
  document.getElementById(sectionId).classList.add('active');
}

// default saat pertama kali masuk tetap Beranda
window.onload = function() {
  showSection('beranda');
};
