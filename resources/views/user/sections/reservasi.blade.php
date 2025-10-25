@php
use App\Models\Meja;
use App\Models\Reservasi;

// Ambil semua meja
$allMejas = Meja::orderBy('id', 'asc')->get();

// Filter meja yang sudah dipesan untuk tanggal & jam tertentu (default hari ini)
// Kita hanya bisa filter jika user memilih tanggal & jam, jadi untuk form awal tampil semua meja dulu
$availableMejas = $allMejas; // awalnya tampil semua, nanti AJAX bisa filter
@endphp

<section id="reservasi">
  <div class="reservasi-container">

    <div id="flash-container"></div>

    <div class="form-side">
      <h2>Silakan Pilih Meja</h2>
      
      <form id="reservasiForm" action="{{ route('user.reservasi.store') }}" method="POST">
        @csrf

        {{-- Nama & Jumlah Orang --}}
        <div class="row" style="gap:15px;">
          <div class="col">
            <label>Nama <span style="color:red;">*</span></label>
            <input type="text" name="nama" placeholder="Masukkan nama" required maxlength="255"
                   style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc;">
          </div>
          <div class="col">
            <label>Jumlah Orang <span style="color:red;">*</span></label>
            <input type="number" name="jumlah_orang" placeholder="Jumlah orang" required min="1" max="10"
                   style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc;">
          </div>
        </div>

        {{-- Tanggal & Jam --}}
        <div class="row" style="gap:15px; margin-top:15px;">
          <div class="col">
            <label>Tanggal <span style="color:red;">*</span></label>
            <input type="date" name="tanggal" required id="tanggalInput"
                   style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc;">
          </div>
          <div class="col">
            <label>Jam <span style="color:red;">*</span></label>
            <input type="time" name="jam" required id="jamInput"
                   style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc;">
          </div>
        </div>

        {{-- Pilih Meja --}}
        <div class="full-width" style="margin-top:15px;">
          <label>Pilih Meja <span style="color:red;">*</span></label>
          <select name="pilihan_meja" required id="mejaSelect"
                  style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc;">
              <option value="">-- Pilih Meja --</option>
              @foreach($availableMejas as $meja)
                  <option value="{{ $meja->nama_meja }}">{{ $meja->nama_meja }}</option>
              @endforeach
          </select>
        </div>

        {{-- Catatan --}}
        <div class="full-width" style="margin-top:15px;">
          <label>Catatan</label>
          <textarea name="catatan" placeholder="Tulis catatan di sini..." rows="3"
                    style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc;"></textarea>
        </div>

        <button type="submit" id="submitBtn"
                style="margin-top:15px; background:#6c4f1e; color:white; border:none; border-radius:8px; padding:10px 20px; cursor:pointer; font-size:15px;">
          Pesan Sekarang
        </button>
      </form>
    </div>

    <div class="syarat-side" style="margin-top:20px;">
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
const form = document.getElementById('reservasiForm');
const submitBtn = document.getElementById('submitBtn');
const tanggalInput = document.getElementById('tanggalInput');
const jamInput = document.getElementById('jamInput');
const mejaSelect = document.getElementById('mejaSelect');

async function updateAvailableMeja(){
  const tanggal = tanggalInput.value;
  const jam = jamInput.value;
  if(!tanggal || !jam) return;

  try {
    const response = await fetch(`/api/available-meja?tanggal=${tanggal}&jam=${jam}`);
    const mejas = await response.json();

    // reset options
    mejaSelect.innerHTML = `<option value="">-- Pilih Meja --</option>`;
    mejas.forEach(m => {
      const opt = document.createElement('option');
      opt.value = m.nama_meja;
      opt.textContent = m.nama_meja;
      mejaSelect.appendChild(opt);
    });
  } catch {
    console.log('Gagal mengambil data meja');
  }
}

tanggalInput.addEventListener('change', updateAvailableMeja);
jamInput.addEventListener('change', updateAvailableMeja);

form.addEventListener('submit', async function(e){
  e.preventDefault();
  const formData = new FormData(form);

  submitBtn.disabled = true;
  submitBtn.textContent = 'Mengirim...';

  try {
    const response = await fetch(form.action, {
      method: 'POST',
      headers: {'X-CSRF-TOKEN': formData.get('_token')},
      body: formData
    });

    const result = await response.json();

    if(result.status === 'success'){
      showPopup(result.message);
      form.reset();
      mejaSelect.innerHTML = `<option value="">-- Pilih Meja --</option>`;
      // reload meja
      updateAvailableMeja();
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

function showPopup(message, isError = false){
  const overlay = document.createElement('div');
  Object.assign(overlay.style, {
    position:'fixed', top:'0', left:'0', width:'100%', height:'100%',
    background:'rgba(0,0,0,0.45)', display:'flex', justifyContent:'center', alignItems:'center',
    zIndex:'9999', opacity:'0', transition:'opacity 0.4s ease'
  });

  const popup = document.createElement('div');
  Object.assign(popup.style, {
    background:isError ? '#f8d7da':'white',
    color:isError ? '#721c24':'#333',
    padding:'25px 30px', borderRadius:'16px', textAlign:'center',
    boxShadow:'0 8px 25px rgba(0,0,0,0.2)',
    transform:'scale(0.8)', opacity:'0', transition:'transform 0.3s ease, opacity 0.3s ease',
    fontFamily:'Poppins, Arial, sans-serif', maxWidth:'400px', width:'80%'
  });

  popup.innerHTML = `
    <p style="font-size:17px; margin-bottom:20px;">${message}</p>
    <button id="popup-close" style="
      background:${isError ? '#721c24':'#6c4f1e'};
      color:white; border:none; border-radius:8px; padding:10px 18px;
      font-size:15px; cursor:pointer;">Tutup</button>
  `;

  overlay.appendChild(popup);
  document.body.appendChild(overlay);

  setTimeout(() => { overlay.style.opacity='1'; popup.style.opacity='1'; popup.style.transform='scale(1)'; }, 50);

  document.getElementById('popup-close').addEventListener('click', () => closePopup(overlay, popup));
  setTimeout(() => closePopup(overlay, popup), 4000);
}

function closePopup(overlay, popup){
  popup.style.opacity='0'; popup.style.transform='scale(0.9)'; overlay.style.opacity='0';
  setTimeout(() => overlay.remove(), 300);
}
</script>
