document.addEventListener('DOMContentLoaded', () => {
    // Ambil modal menggunakan Bootstrap Modal API
    const modalEl = document.getElementById('modalTambah');
    if (!modalEl) return;

    const modal = new bootstrap.Modal(modalEl, {
        backdrop: 'static', // klik di luar modal tidak menutup otomatis
        keyboard: false     // tekan Esc tidak menutup modal
    });

    // Tombol "Tambah Menu"
    const openBtn = document.querySelector('[data-bs-target="#modalTambah"]');
    openBtn?.addEventListener('click', () => {
        modal.show();
    });

    // Reset form dan preview gambar saat modal ditutup
    modalEl.addEventListener('hidden.bs.modal', () => {
        const form = modalEl.querySelector('form');
        if (form) form.reset();

        // Hapus preview gambar jika ada
        const imgPreview = modalEl.querySelector('.img-preview');
        if (imgPreview) imgPreview.src = '';
    });

    // Preview gambar sebelum upload (opsional)
    const fileInput = modalEl.querySelector('input[name="gambar"]');
    const imgPreview = modalEl.querySelector('.img-preview');

    if (fileInput && imgPreview) {
        fileInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (!file) {
                imgPreview.src = '';
                return;
            }
            const reader = new FileReader();
            reader.onload = (event) => {
                imgPreview.src = event.target.result;
            };
            reader.readAsDataURL(file);
        });
    }

    // Tombol submit tetap bekerja normal, tidak ada preventDefault
    // Jika ingin AJAX, bisa ditambahkan di sini
});
