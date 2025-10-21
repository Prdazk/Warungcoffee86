<section id="reservasi">
  <div class="reservasi-container">
    <div class="form-side">
      <h2>Silakan Pilih Meja</h2>
      
      <!-- Form untuk reservasi -->
      <form action="{{ route('user.reservasi.store') }}" method="POST">
        @csrf <!-- CSRF token wajib -->

        <!-- Nama & Jumlah Orang -->
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

        <!-- Tanggal & Jam -->
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

        <!-- Pilih Meja -->
        <div class="full-width">
          <label>Pilih Meja <span style="color:red;">*</span></label>
          <select name="pilihan_meja" required>
            <option value="">-- Pilih Meja --</option>
            <option value="Meja 1">Meja 1</option>
            <option value="Meja 2">Meja 2</option>
          </select>
        </div>

        <!-- Catatan -->
        <div class="full-width">
          <label>Catatan</label>
          <textarea name="catatan" placeholder="Tulis catatan di sini..." rows="3"></textarea>
        </div>

        <!-- Tombol Submit -->
        <button type="submit">Pesan Sekarang</button>

      </form>
    </div>

    <!-- Syarat & Ketentuan -->
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
