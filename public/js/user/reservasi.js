document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('reservasiForm');
    const submitBtn = document.getElementById('submitBtn');
    const tanggalInput = document.getElementById('tanggalInput');
    const jamInput = document.getElementById('jamInput');
    const mejaSelect = document.getElementById('mejaSelect');

    // === Fungsi update daftar meja berdasarkan tanggal & jam ===
    async function updateAvailableMeja() {
        const tanggal = tanggalInput.value;
        const jam = jamInput.value;
        if (!tanggal || !jam) return;

        try {
            const res = await fetch(`/user/reservasi/available-meja?tanggal=${tanggal}&jam=${jam}`);
            const mejas = await res.json();

            const selectedValue = mejaSelect.value;
            mejaSelect.innerHTML = `<option value="">-- Pilih Meja --</option>`;

            mejas.forEach(m => {
                const opt = document.createElement('option');
                opt.value = m.id;
                opt.textContent = `${m.nama_meja} (${m.status_meja === 'Kosong' ? 'Kosong' : 'Terpakai'})`;

                if (m.status_meja !== 'Kosong') {
                    opt.disabled = true;
                    opt.style.color = 'red';
                    opt.textContent += ' ❌';
                } else {
                    opt.style.color = 'green';
                }

                if (m.id == selectedValue) opt.selected = true;
                mejaSelect.appendChild(opt);
            });
        } catch (err) {
            console.warn('Update meja gagal', err);
        }
    }

    // === Event change tanggal/jam langsung refresh meja ===
    tanggalInput.addEventListener('change', updateAvailableMeja);
    jamInput.addEventListener('change', updateAvailableMeja);

    // === Submit form via AJAX ===
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        submitBtn.disabled = true;
        submitBtn.textContent = 'Mengirim...';

        const formData = new FormData(form);
        const tanggal = formData.get('tanggal');
        const jam = formData.get('jam');
        const meja = formData.get('meja_id');

        if (!tanggal || !jam || !meja) {
            Swal.fire('Peringatan!', 'Mohon lengkapi semua data reservasi.', 'warning');
            submitBtn.disabled = false;
            submitBtn.textContent = 'Pesan Sekarang';
            return;
        }

        try {
            const res = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || document.querySelector('input[name="_token"]')?.value,
                    'Accept': 'application/json'
                },
                body: formData
            });

            const result = await res.json();

            if (res.ok && result.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: result.message,
                    showConfirmButton: false,
                    timer: 1500
                });

                form.reset();
                setTimeout(() => {
                    window.location.reload(); // reload otomatis setelah reservasi
                }, 1600);
            } else {
                Swal.fire('Gagal!', result.message || 'Terjadi kesalahan.', 'error');
            }
        } catch (err) {
            console.error(err);
            Swal.fire('Error!', 'Koneksi gagal. Silakan coba lagi.', 'error');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Pesan Sekarang';
        }
    });

    // === Realtime update meja saat admin tambah/hapus/edit reservasi ===
    document.addEventListener('reservasi:changed', () => {
        updateAvailableMeja(); // langsung fetch dan update tanpa reload
    });

    document.addEventListener('meja:added', () => {
        updateAvailableMeja(); // update ketika admin tambah meja
    });

    document.addEventListener('reservasi:deleted', () => {
        updateAvailableMeja(); // update ketika admin hapus reservasi
    });

    // === Inisialisasi daftar meja saat page load ===
    updateAvailableMeja();
});
