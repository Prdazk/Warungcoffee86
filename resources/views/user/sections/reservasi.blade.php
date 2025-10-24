<section id="reservasi">
  <div class="reservasi-container">

    {{-- Flash container untuk pesan sukses AJAX --}}
    <div id="flash-container"></div>

    <div class="form-side">
      <h2>Silakan Pilih Meja</h2>
      
      <form id="reservasiForm" action="{{ route('user.reservasi.store') }}" method="POST">
        @csrf

        <div class="row">
          <div class="col">
            <label>Nama <span style="color:red;">*</span></label>
            <input type="text" name="nama" placeholder="Masukkan nama" required maxlength="255">
          </div>
          <div class="col">
            <label>Jumlah Orang <span style="color:red;">*</span></label>
            <input type="number" name="jumlah_orang" placeholder="Jumlah orang" required min="1" max="10">
          </div>
        </div>

        <div class="row">
          <div class="col">
            <label>Tanggal <span style="color:red;">*</span></label>
            <input type="date" name="tanggal" required>
          </div>
          <div class="col">
            <label>Jam <span style="color:red;">*</span></label>
            <input type="time" name="jam" required>
          </div>
        </div>

        <div class="full-width">
          <label>Pilih Meja <span style="color:red;">*</span></label>
          <select name="pilihan_meja" required>
            <option value="">-- Pilih Meja --</option>
            <option value="Meja 1">Meja 1</option>
            <option value="Meja 2">Meja 2</option>
          </select>
        </div>

        <div class="full-width">
          <label>Catatan</label>
          <textarea name="catatan" placeholder="Tulis catatan di sini..." rows="3"></textarea>
        </div>

        <button type="submit" id="submitBtn">Pesan Sekarang</button>
      </form>
    </div>

    <div class="syarat-side">
      <h3>Syarat & Ketentuan</h3>
      <ul>
        <li>Reservasi minimal 45 menit sebelum kedatangan.</li>
        <li>Datang tepat waktu untuk memudahkan persiapan.</li>
        <li>Reservasi maksimal untuk 10 orang.</li>
        <li>Tulis alergi atau permintaan khusus di catatan.</li>
        <li>Pembatalan bisa dilakukan 2 jam sebelumnya.</li>
      </ul>
    </div>
  </div>
</section>
<script>
document.getElementById('reservasiForm').addEventListener('submit', async function(e) {
  e.preventDefault();
  const form = e.target;
  const formData = new FormData(form);
  const submitBtn = document.getElementById('submitBtn');

  submitBtn.disabled = true;
  submitBtn.textContent = 'Mengirim...';

  try {
    const response = await fetch(form.action, {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': formData.get('_token') },
      body: formData
    });

    const result = await response.json();

    if (result.status === 'success') {
      showPopup(result.message);
      form.reset();
    } else {
      showPopup(result.message || 'Gagal mengirim reservasi.', true);
    }
  } catch {
    showPopup('Koneksi gagal, coba lagi.', true);
  } finally {
    submitBtn.disabled = false;
    submitBtn.textContent = 'Pesan Sekarang';
  }
});

function showPopup(message, isError = false) {
  // Overlay
  const overlay = document.createElement('div');
  overlay.id = 'popup-overlay';
  Object.assign(overlay.style, {
    position: 'fixed',
    top: '0',
    left: '0',
    width: '100%',
    height: '100%',
    background: 'rgba(0,0,0,0.45)',
    display: 'flex',
    alignItems: 'center',
    justifyContent: 'center',
    zIndex: '9999',
    opacity: '0',
    transition: 'opacity 0.4s ease'
  });

  // Popup
  const popup = document.createElement('div');
  Object.assign(popup.style, {
    background: isError ? '#f8d7da' : 'white',
    color: isError ? '#721c24' : '#333',
    padding: '25px 30px',
    borderRadius: '16px',
    boxShadow: '0 8px 25px rgba(0,0,0,0.2)',
    textAlign: 'center',
    position: 'relative',
    transform: 'scale(0.8)',
    transition: 'transform 0.3s ease, opacity 0.3s ease',
    opacity: '0',
    fontFamily: 'Poppins, Arial, sans-serif',
    maxWidth: '400px',
    width: '80%'
  });

  popup.innerHTML = `
    <p style="font-size:17px; margin-bottom:20px;">
      ${message}
    </p>
    <button id="popup-close" style="
      background:${isError ? '#721c24' : '#6c4f1e'};
      color:white;
      border:none;
      border-radius:8px;
      padding:10px 18px;
      font-size:15px;
      cursor:pointer;
      transition:background 0.2s ease;
    ">Tutup</button>
  `;

  overlay.appendChild(popup);
  document.body.appendChild(overlay);

  // Fade + Zoom animation
  setTimeout(() => {
    overlay.style.opacity = '1';
    popup.style.opacity = '1';
    popup.style.transform = 'scale(1)';
  }, 50);

  // Tutup manual
  document.getElementById('popup-close').addEventListener('click', () => {
    closePopup(overlay, popup);
  });

  // Auto close 4 detik
  setTimeout(() => {
    closePopup(overlay, popup);
  }, 4000);
}

function closePopup(overlay, popup) {
  popup.style.opacity = '0';
  popup.style.transform = 'scale(0.9)';
  overlay.style.opacity = '0';
  setTimeout(() => overlay.remove(), 300);
}
</script>
