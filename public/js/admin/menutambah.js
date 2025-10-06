// --- Modal Tambah Menu ---
// Ambil elemen yang dibutuhkan
const modal = document.getElementById('menuModal');
const openBtn = document.getElementById('openModalBtn');
const closeBtns = [
  document.getElementById('closeModalBtn'),
  document.getElementById('closeModalBtn2')
];

// Buka modal saat tombol "Tambah Menu" diklik
openBtn?.addEventListener('click', () => {
  modal.classList.add('show');
});

// Tutup modal jika tombol "×" atau "Batal" diklik
closeBtns.forEach(btn => {
  btn?.addEventListener('click', () => {
    modal.classList.remove('show');
  });
});

// Tutup modal saat klik area luar konten
modal?.addEventListener('click', (e) => {
  if (e.target === modal) {
    modal.classList.remove('show');
  }
});

// --- Efek tambahan (opsional) ---
// Tambahkan animasi halus saat muncul
document.addEventListener('animationend', (e) => {
  if (e.animationName === 'modalIn') {
    modal.querySelector('.modal-content')?.classList.add('ready');
  }
});
