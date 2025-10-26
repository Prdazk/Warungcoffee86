document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('reservasiForm');
  const submitBtn = document.getElementById('submitBtn');
  const tanggalInput = document.getElementById('tanggalInput');
  const jamInput = document.getElementById('jamInput');
  const mejaSelect = document.getElementById('mejaSelect');

  /**
   * 🔄 Update daftar meja sesuai tanggal & jam
   * Jika gagal, tetap gunakan daftar awal tanpa menampilkan error
   */
  async function updateAvailableMeja() {
    const tanggal = tanggalInput.value;
    const jam = jamInput.value;
    if (!tanggal || !jam) return;

    try {
      const response = await fetch(`/api/available-meja?tanggal=${tanggal}&jam=${jam}`);
      if (!response.ok) throw new Error('Server tidak merespon.');
      const mejas = await response.json();

      mejaSelect.innerHTML = `<option value="">-- Pilih Meja --</option>`;
      mejas.forEach(m => {
        const opt = document.createElement('option');
        opt.value = m.id;
        opt.textContent = `${m.nama_meja} (${m.status_meja})`;
        opt.style.color = m.status_meja === 'Dipesan' ? 'red' : 'green';
        if (m.status_meja === 'Dipesan') opt.disabled = true;
        mejaSelect.appendChild(opt);
      });
    } catch (err) {
      console.warn('Update meja gagal, tetap gunakan daftar awal.', err);
    }
  }

  // 🔁 Event change tanggal/jam
  tanggalInput.addEventListener('change', updateAvailableMeja);
  jamInput.addEventListener('change', updateAvailableMeja);

  // 📩 Submit form dengan SweetAlert konfirmasi
  form.addEventListener('submit', (e) => {
    e.preventDefault();

    Swal.fire({
      title: 'Konfirmasi Pesanan',
      text: 'Apakah Anda yakin ingin memesan meja ini?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Ya, pesan sekarang!',
      cancelButtonText: 'Batal'
    }).then(async (result) => {
      if (!result.isConfirmed) return;

      submitBtn.disabled = true;
      submitBtn.textContent = 'Mengirim...';

      const formData = new FormData(form);

      try {
        const response = await fetch(form.action, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'Accept': 'application/json'
          },
          body: formData
        });

        const resultJson = await response.json();

        if (response.ok && resultJson.status === 'success') {
          Swal.fire('Berhasil!', resultJson.message, 'success');
          form.reset();
          updateAvailableMeja();
        } else {
          Swal.fire('Gagal!', resultJson.message || 'Terjadi kesalahan saat memesan.', 'error');
        }
      } catch (err) {
        console.error(err);
        Swal.fire('Error!', 'Koneksi gagal. Silakan coba lagi.', 'error');
      } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Pesan Sekarang';
      }
    });
  });

  // 🔁 Init pertama kali
  updateAvailableMeja();
});
