document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('reservasiForm');
    const submitBtn = document.getElementById('submitBtn');
    const tanggalInput = document.getElementById('tanggalInput');
    const jamInput = document.getElementById('jamInput');
    const mejaSelect = document.getElementById('mejaSelect');

    // Fungsi update daftar meja
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

    // Event change tanggal/jam langsung refresh meja
    tanggalInput.addEventListener('change', updateAvailableMeja);
    jamInput.addEventListener('change', updateAvailableMeja);

    // Submit form via AJAX
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        submitBtn.disabled = true;
        submitBtn.textContent = 'Mengirim...';

        const formData = new FormData(form);

        try {
            const res = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json'
                },
                body: formData
            });

            const result = await res.json();

            if (res.ok && result.status === 'success') {
                // SweetAlert sukses
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: result.message,
                    showConfirmButton: false,
                    timer: 1500 // otomatis close
                });

                // Reset form & reload halaman
                form.reset();
                setTimeout(() => {
                    window.location.reload();
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

    // Inisialisasi saat page load
    updateAvailableMeja();
});
