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

        // jika belum pilih tanggal/jam -> biarkan opsi dari Blade (tidak diubah)
        if (!tanggal || !jam) return;

        try {
            const res = await fetch(`/user/reservasi/available-meja?tanggal=${encodeURIComponent(tanggal)}&jam=${encodeURIComponent(jam)}`);
            if (!res.ok) throw new Error('Gagal fetch meja');
            const mejas = await res.json();

            // reset dropdown
            mejaSelect.innerHTML = `<option value="">-- Pilih Meja --</option>`;

            mejas.forEach(m => {
                // support old/new keys
                const nama = m.nama ?? m.nama_meja ?? m.name ?? '';
                const status = m.status ?? m.status_meja ?? (m.is_used ? 'Terpakai' : 'Kosong') ?? 'Kosong';

                // tampilkan hanya meja Kosong (hilang jika Terpakai)
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
            Swal.fire('Peringatan!', 'Mohon lengkapi semua data reservasi.', 'warning');
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
                Swal.fire({ icon: 'success', title: 'Berhasil!', text: result.message, showConfirmButton: false, timer: 1500 });
                form.reset();
                // setelah sukses, refresh daftar meja (agar meja yang dipesan hilang)
                setTimeout(updateAvailableMeja, 300);
            } else {
                Swal.fire('Gagal!', result.message || 'Terjadi kesalahan.', 'error');
            }
        } catch (err) {
            Swal.fire('Error!', 'Koneksi gagal. Silakan coba lagi.', 'error');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Pesan Sekarang';
        }
    });

    ['reservasi:changed', 'meja:added', 'reservasi:deleted'].forEach(event => {
        document.addEventListener(event, updateAvailableMeja);
        window.addEventListener(event, updateAvailableMeja);
    });

    // inisialisasi: jika sudah ada tanggal+jam diisi dari server, panggil update
    updateAvailableMeja();

    setInterval(() => {
        if (tanggalInput.value && jamInput.value) updateAvailableMeja();
    }, 5000);
});
