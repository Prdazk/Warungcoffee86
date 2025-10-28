@php
use App\Models\Meja;
$availableMejas = Meja::orderBy('id', 'asc')->get();
@endphp

<section id="reservasi">
  <div class="reservasi-container" style="gap:20px;">

    <!-- Form -->
    <div class="form-side" style="padding:35px 35px; border-radius:12px;">
      <h2 class="form-title" style="text-align:center; margin-bottom:12px; font-size:17px;">Silakan Pilih Meja</h2>

      <form id="reservasiForm" action="{{ route('user.reservasi.store') }}" method="POST">
        @csrf

        <div class="row" style="display:flex; gap:13px; margin-bottom:13px;">
          <div class="col" style="flex:1;">
            <label style="font-size:12px;">Nama</label>
            <input type="text" name="nama" placeholder="Masukkan nama" required maxlength="255" class="input-field" style="padding:7px 10px; font-size:13px;">
          </div>
          <div class="col" style="flex:1;">
            <label style="font-size:12px;">Jumlah Orang</label>
            <input type="number" name="jumlah_orang" placeholder="Jumlah orang" required min="1" max="10" class="input-field" style="padding:7px 10px; font-size:13px;">
          </div>
        </div>

        <div class="row" style="display:flex; gap:12px; margin-bottom:12px;">
          <div class="col" style="flex:1;">
            <label style="font-size:12px;">Tanggal</label>
            <input type="date" id="tanggalInput" name="tanggal" value="{{ date('Y-m-d') }}" required class="input-field" style="padding:7px 10px; font-size:13px;">
          </div>
          <div class="col" style="flex:1;">
            <label style="font-size:12px;">Jam</label>
            <input type="time" id="jamInput" name="jam" required class="input-field" style="padding:7px 10px; font-size:13px;">
          </div>
        </div>

        <div class="full-width" style="margin-bottom:12px;">
          <label style="font-size:12px;">Pilih Meja</label>
          <select id="mejaSelect" name="meja_id" required class="input-field" style="padding:7px 10px; font-size:13px;">
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

        <div class="full-width" style="margin-bottom:14px;">
          <label style="font-size:12px;">Catatan</label>
          <textarea name="catatan" placeholder="Tulis catatan di sini..." rows="3" class="input-field" style="padding:7px 10px; font-size:13px;"></textarea>
        </div>

     <div style="text-align:center;">
      <button type="submit" id="submitBtn" class="btn-submit"
        style="padding:12px 32px; font-size:14px; border-radius:8px; width:auto;">
        Pesan Sekarang
      </button>
    </div>

      </form>
    </div>

    <!-- Syarat -->
    <div class="syarat-side" style="padding:16px 18px; border-radius:12px;">
      <h3 style="text-align:center; margin-bottom:10px; font-size:15px;">Syarat & Ketentuan</h3>
      <ul style="line-height:1.4; font-size:13px;">
        <li>Reservasi minimal 45 menit sebelum kedatangan.</li>
        <li>Datang tepat waktu untuk memudahkan persiapan.</li>
        <li>Reservasi maksimal untuk 10 orang.</li>
        <li>Tulis alergi atau permintaan khusus di catatan.</li>
        <li>Pembatalan bisa dilakukan 2 jam sebelumnya.</li>
      </ul>
    </div>

  </div>
</section>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/user/servasi.js') }}"></script>