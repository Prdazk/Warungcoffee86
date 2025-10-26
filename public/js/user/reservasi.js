document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('reservasiForm');
  const submitBtn = document.getElementById('submitBtn');
  const tanggalInput = document.getElementById('tanggalInput');
  const jamInput = document.getElementById('jamInput');
  const mejaSelect = document.getElementById('mejaSelect');

  // 🔄 Ambil daftar meja sesuai tanggal & jam
  async function updateAvailableMeja() {
    const tanggal = tanggalInput.value;
    const jam = jamInput.value;
    if (!tanggal || !jam) return;

    try {
      const response = await fetch(`/api/available-meja?tanggal=${tanggal}&jam=${jam}`);
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
      showPopup('Gagal memuat data meja.', true);
      console.error(err);
    }
  }

  tanggalInput.addEventListener('change', updateAvailableMeja);
  jamInput.addEventListener('change', updateAvailableMeja);

  // 📩 Kirim form tanpa reload
  form.addEventListener('submit', async (e) => {
    e.preventDefault();
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

      const result = await response.json();

      if (response.ok && result.status === 'success') {
        showPopup(result.message);
        form.reset();
        updateAvailableMeja();
      } else {
        showPopup(result.message || 'Terjadi kesalahan.', true);
      }
    } catch (err) {
      console.error(err);
      showPopup('Koneksi gagal. Silakan coba lagi.', true);
    } finally {
      submitBtn.disabled = false;
      submitBtn.textContent = 'Pesan Sekarang';
    }
  });

  // 🌟 Popup Cantik
  function showPopup(message, isError = false) {
    const overlay = document.createElement('div');
    Object.assign(overlay.style, {
      position:'fixed', top:0, left:0, width:'100%', height:'100%',
      background:'rgba(0,0,0,0.45)', display:'flex', justifyContent:'center', alignItems:'center',
      zIndex:9999, opacity:0, transition:'opacity 0.4s ease'
    });

    const popup = document.createElement('div');
    Object.assign(popup.style, {
      background:isError?'#f8d7da':'#fff',
      color:isError?'#721c24':'#333',
      padding:'25px 30px',
      borderRadius:'16px',
      textAlign:'center',
      boxShadow:'0 8px 25px rgba(0,0,0,0.2)',
      transform:'scale(0.8)',
      opacity:0,
      transition:'transform 0.3s ease, opacity 0.3s ease',
      fontFamily:'Poppins, Arial, sans-serif',
      maxWidth:'400px',
      width:'80%'
    });

    popup.innerHTML = `
      <p style="font-size:17px; margin-bottom:20px;">${message}</p>
      <button id="popup-close" style="background:${isError?'#721c24':'#6c4f1e'}; color:white; border:none; border-radius:8px; padding:10px 18px; font-size:15px; cursor:pointer;">Tutup</button>
    `;

    overlay.appendChild(popup);
    document.body.appendChild(overlay);

    setTimeout(() => { overlay.style.opacity='1'; popup.style.opacity='1'; popup.style.transform='scale(1)'; }, 50);
    document.getElementById('popup-close').addEventListener('click', () => closePopup(overlay, popup));
    setTimeout(() => closePopup(overlay, popup), 4000);
  }

  function closePopup(overlay, popup) {
    popup.style.opacity='0';
    popup.style.transform='scale(0.9)';
    overlay.style.opacity='0';
    setTimeout(() => overlay.remove(), 300);
  }
});
