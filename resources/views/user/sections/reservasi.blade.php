<section id="reservasi">
  <div class="reservasi-container">
    <div class="form-side">
      <h2>Silakan Pilih Meja</h2>
      <form action="{{ route('user.reservasi.store') }}" method="POST">
        @csrf

        <div class="row">
          <div class="col">
            <label>Nama</label>
            <input type="text" name="nama" placeholder="Masukkan nama">
          </div>
          <div class="col">
            <label>Jumlah Orang</label>
            <input type="number" name="jumlah_orang" placeholder="Jumlah orang">
          </div>
        </div>

        <div class="row">
          <div class="col">
            <label>Tanggal</label>
            <input type="date" name="tanggal">
          </div>
          <div class="col">
            <label>Jam</label>
            <input type="time" name="jam">
          </div>
        </div>

        <div class="full-width">
          <label>Pilih Meja</label>
          <select name="pilihan_meja">
            <option value="">-- Pilih Meja --</option>
            <option value="Meja 1">Meja 1</option>
            <option value="Meja 2">Meja 2</option>
          </select>
        </div>

        <div class="full-width">
          <label>Catatan</label>
          <textarea name="catatan" placeholder="Tulis catatan di sini..."></textarea>
        </div>

        <button type="submit">Pesan Sekarang</button>

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
