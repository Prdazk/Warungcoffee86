@php
use App\Models\Meja;
$availableMejas = Meja::orderBy('id', 'asc')->get();
@endphp

<section id="reservasi">
  <div class="reservasi-container">

    {{-- Form Reservasi --}}
    <div class="form-side">
      <h2 class="form-title">Silakan Pilih Meja</h2>

      <form id="reservasiForm" action="{{ route('user.reservasi.store') }}" method="POST">
        @csrf

        <div class="row" style="gap:15px;">
          <div class="col">
            <label>Nama <span class="text-danger">*</span></label>
            <input type="text" name="nama" placeholder="Masukkan nama" required maxlength="255" class="input-field">
          </div>
          <div class="col">
            <label>Jumlah Orang <span class="text-danger">*</span></label>
            <input type="number" name="jumlah_orang" placeholder="Jumlah orang" required min="1" max="10" class="input-field">
          </div>
        </div>

        <div class="row" style="gap:15px; margin-top:15px;">
          <div class="col">
            <label>Tanggal <span class="text-danger">*</span></label>
            <input type="date" id="tanggalInput" name="tanggal" value="{{ date('Y-m-d') }}" required class="input-field">
          </div>
          <div class="col">
            <label>Jam <span class="text-danger">*</span></label>
            <input type="time" id="jamInput" name="jam" required class="input-field">
          </div>
        </div>

            <div class="full-width" style="margin-top:15px;">
          <label>Pilih Meja <span class="text-danger">*</span></label>
          <select id="mejaSelect" name="meja_id" required class="input-field">
              <option value="">-- Pilih Meja --</option>
              @foreach($availableMejas as $meja)
                  <option 
                      value="{{ $meja['id'] }}" 
                      {{ in_array($meja['status_meja'], ['Dipesan','Terisi']) ? 'disabled' : '' }}
                      style="color:{{ in_array($meja['status_meja'], ['Dipesan','Terisi']) ? 'red' : 'green' }};">
                      {{ $meja['nama_meja'] }} ({{ in_array($meja['status_meja'], ['Dipesan','Terisi']) ? 'Terpakai' : 'Kosong' }})
                  </option>
              @endforeach
          </select>
      </div>


        <div class="full-width" style="margin-top:15px;">
          <label>Catatan</label>
          <textarea name="catatan" placeholder="Tulis catatan di sini..." rows="3" class="input-field"></textarea>
        </div>

        <button type="submit" id="submitBtn" class="btn-submit">Pesan Sekarang</button>
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

{{-- Panggil JS --}}
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/user/servasi.js') }}"></script>

{{-- Styling --}}
<style>
.reservasi-container { display: flex; flex-wrap: wrap; gap: 30px; justify-content: space-between; margin-top: 20px; }
.form-side, .syarat-side { flex: 1; min-width: 320px; }
.form-title { margin-bottom: 15px; color: #6c4f1e; }
.input-field { width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ccc; box-sizing: border-box; }
.btn-submit { margin-top: 20px; background: #6c4f1e; color: white; border: none; border-radius: 8px; padding: 10px 20px; cursor: pointer; font-size: 15px; transition: background 0.3s ease; }
.btn-submit:hover { background: #8b6428; }
.btn-submit:disabled { background: #a68c6d; cursor: not-allowed; }
.text-danger { color: red; }
@media screen and (max-width: 768px) { .reservasi-container { flex-direction: column; } }
</style>
