document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('reservasiForm');
    const submitBtn = document.getElementById('submitBtn');
    const tanggalInput = document.getElementById('tanggalInput');
    const jamInput = document.getElementById('jamInput');
    const mejaSelect = document.getElementById('mejaSelect');

    const blockTyping = (el) => {
        if (!el) return;
        el.addEventListener('keydown', e => e.preventDefault());
        el.addEventListener('paste', e => e.preventDefault());
    };
    blockTyping(tanggalInput);
    blockTyping(jamInput);

    async function updateAvailableMeja() {
        const tanggal = tanggalInput.value;
        const jam = jamInput.value;

        if (!tanggal || !jam) return;

        try {
            const res = await fetch(`/user/reservasi/available-meja?tanggal=${encodeURIComponent(tanggal)}&jam=${encodeURIComponent(jam)}`);
            if (!res.ok) throw new Error('Gagal fetch meja');
            const mejas = await res.json();

            mejaSelect.innerHTML = `<option value="">-- Pilih Meja --</option>`;

            mejas.forEach(m => {
                const nama = m.nama ?? m.nama_meja ?? m.name ?? '';
                const status = m.status ?? m.status_meja ?? (m.is_used ? 'Terpakai' : 'Kosong') ?? 'Kosong';
                if (status !== 'Kosong') return;

                const opt = document.createElement('option');
                opt.value = m.id;
                opt.textContent = `${nama} (Kosong)`;
                opt.dataset.nama = nama;
                mejaSelect.appendChild(opt);
            });

        } catch (err) {
            console.warn('Update meja gagal', err);
        }
    }

    tanggalInput.addEventListener('change', updateAvailableMeja);
    jamInput.addEventListener('change', updateAvailableMeja);

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        submitBtn.disabled = true;
        submitBtn.textContent = 'Mengirim...';

        const formData = new FormData(form);
        if (!formData.get('tanggal') || !formData.get('jam') || !formData.get('meja_id')) {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan!',
                text: 'Mohon lengkapi semua data reservasi.',
                width: '90%',
                customClass: { popup: 'swal-popup-responsive' }
            });
            submitBtn.disabled = false;
            submitBtn.textContent = 'Pesan Sekarang';
            return;
        }

        try {
            const res = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                        || document.querySelector('input[name="_token"]')?.value,
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
                    timer: 1500,
                    width: '90%',
                    customClass: { popup: 'swal-popup-responsive' }
                });
                form.reset();
                setTimeout(updateAvailableMeja, 300);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: result.message || 'Terjadi kesalahan.',
                    width: '90%',
                    customClass: { popup: 'swal-popup-responsive' }
                });
            }
        } catch (err) {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Koneksi gagal. Silakan coba lagi.',
                width: '90%',
                customClass: { popup: 'swal-popup-responsive' }
            });
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Pesan Sekarang';
        }
    });

    ['reservasi:changed', 'meja:added', 'reservasi:deleted'].forEach(event => {
        document.addEventListener(event, updateAvailableMeja);
        window.addEventListener(event, updateAvailableMeja);
    });

    updateAvailableMeja();

    setInterval(() => {
        if (tanggalInput.value && jamInput.value) updateAvailableMeja();
    }, 5000);

    // ================================
    // Tambahkan CSS responsif untuk popup
    // ================================
    const style = document.createElement('style');
    style.innerHTML = `
        .swal-popup-responsive {
            max-width: 95% !important;
            box-sizing: border-box;
        }

        @media (min-width: 480px) {
            .swal-popup-responsive {
                max-width: 400px !important;
            }
        }
    `;
    document.head.appendChild(style);
});
