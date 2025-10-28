document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('reservasiForm');
  const submitBtn = document.getElementById('submitBtn');
  const tanggalInput = document.getElementById('tanggalInput');
  const jamInput = document.getElementById('jamInput');
  const mejaSelect = document.getElementById('mejaSelect');

  async function updateAvailableMeja() {
    const tanggal = tanggalInput.value;
    const jam = jamInput.value;
    if (!tanggal || !jam) return;

    try {
      const res = await fetch(`/available-meja?tanggal=${tanggal}&jam=${jam}`);
      const mejas = await res.json();

      // Kosongkan select
      mejaSelect.innerHTML = `<option value="">-- Pilih Meja --</option>`;

      mejas.forEach(m => {
        const opt = document.createElement('option');
        opt.value = m.id;
        opt.textContent = `${m.nama_meja} (${m.status_meja})`;

        if (m.status_meja === 'Terpakai') {
          opt.disabled = true;
          opt.style.color = 'red';
          opt.textContent += ' ❌';
        } else {
          opt.style.color = 'green';
        }

        mejaSelect.appendChild(opt);
      });
    } catch (err) {
      console.warn('Update meja gagal', err);
    }
  }

  // Event change tanggal/jam
  tanggalInput.addEventListener('change', updateAvailableMeja);
  jamInput.addEventListener('change', updateAvailableMeja);

  // Submit form
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
        Swal.fire('Berhasil!', result.message, 'success');
        form.reset();
        updateAvailableMeja();
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

  // Inisialisasi pertama
  updateAvailableMeja();
});
