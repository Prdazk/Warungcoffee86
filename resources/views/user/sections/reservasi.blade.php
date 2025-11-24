@php
use App\Models\Meja;
$mejaKosong = $mejaKosong ?? Meja::where('status_meja', 'Kosong')->orderBy('id')->get();
@endphp

<section id="reservasi">
    <div class="reservasi-container" style="gap:25px; margin-top:15px;">

        <div class="form-side" style="padding:35px 35px; border-radius:12px;">
            <h2 class="form-title" style="text-align:center; margin-bottom:12px; font-size:17px;">Silakan Pilih Meja</h2>

            <form id="reservasiForm" method="POST" action="{{ route('user.reservasi.store') }}">
                @csrf

                <div class="row" style="display:flex; gap:13px; margin-bottom:13px;">
                    <div class="col" style="flex:1;">
                        <label style="font-size:12px;">Nama</label>
                        <input type="text" name="nama" placeholder="Masukkan nama" required maxlength="255"
                               class="input-field" style="padding:7px 10px; font-size:13px;">
                    </div>

                    <div class="col" style="flex:1;">
                        <label style="font-size:12px;">Jumlah Orang</label>
                        <select name="jumlah_orang" required class="input-field" style="padding:7px 10px; font-size:13px;">
                            <option value="" disabled selected>Pilih jumlah</option>
                            @for ($i = 1; $i <= 4; $i++)
                                <option value="{{ $i }}">{{ $i }} orang</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="row" style="display:flex; gap:12px; margin-bottom:12px;">
                    <div class="col" style="flex:1;">
                        <label style="font-size:12px;">Tanggal</label>
                        <input type="date" id="tanggalInput" name="tanggal"
                               value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required
                               class="input-field" style="padding:7px 10px; font-size:13px;">
                    </div>

                    <div class="col" style="flex:1;">
                        <label style="font-size:12px;">Jam</label>
                        <input type="time" id="jamInput" name="jam" required class="input-field"
                               style="padding:7px 10px; font-size:13px;">
                    </div>
                </div>

                <!-- FIXED: Hanya tampilkan meja kosong -->
                <div class="full-width" style="margin-bottom:12px;">
                    <label style="font-size:12px;">Pilih Meja</label>

                   <select id="mejaSelect" name="meja_id" required class="input-field" style="padding:7px 10px; font-size:13px;">
                        <option value="">-- Pilih Meja --</option>
                        @foreach($mejaKosong as $meja)
                            <option value="{{ $meja->id }}">
                                {{ $meja->nama_meja }} (Kosong)
                            </option>
                        @endforeach
                    </select>

                </div>

                <div class="full-width" style="margin-bottom:14px;">
                    <label style="font-size:12px;">Catatan</label>
                    <textarea name="catatan" placeholder="Tulis catatan di sini..." rows="3" class="input-field"
                              style="padding:7px 10px; font-size:13px;"></textarea>
                </div>

                <div style="text-align:center;">
                    <button type="submit" id="submitBtn" class="btn-submit"
                            style="padding:12px 32px; font-size:14px; border-radius:8px; width:auto;">
                        Pesan Sekarang
                    </button>
                </div>
            </form>
        </div>

        <div class="syarat-side" style="padding:16px 18px; border-radius:12px;">
            <h3 style="text-align:center; margin-bottom:10px; font-size:15px;">Syarat & Ketentuan</h3>
            <ul style="line-height:1.4; font-size:13px;">
                <li>Reservasi minimal 30 menit sebelum kedatangan.</li>
                <li>Datang tepat waktu untuk memudahkan persiapan.</li>
                <li>Reservasi maksimal untuk 4 orang.</li>
                <li>Tulis alergi atau permintaan khusus di catatan.</li>
                <li>Pembatalan bisa dilakukan 1 jam sebelumnya.</li>
            </ul>
        </div>

    </div>
</section>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('reservasiForm');
    const mejaSelect = document.getElementById('mejaSelect');

    // ================================
    // Fungsi reload meja kosong sesuai tanggal & jam
    // ================================
    function loadMejaKosong() {
        const tanggal = document.getElementById('tanggalInput').value;
        const jam = document.getElementById('jamInput').value;

        if (!tanggal || !jam) return;

        fetch(`/user/reservasi/available-meja?tanggal=${tanggal}&jam=${jam}`)
            .then(r => r.json())
            .then(data => {
                mejaSelect.innerHTML = `<option value="">-- Pilih Meja --</option>`;
                data.forEach(m => {
                    if (m.status_meja === 'Kosong') {
                        mejaSelect.innerHTML += `
                            <option value="${m.id}">${m.nama_meja} (Kosong)</option>
                        `;
                    }
                });
            });
    }

    // ================================
    // FORM AJAX SUBMIT
    // ================================
    form.addEventListener('submit', function(e) {
        e.preventDefault(); // cegah reload halaman

        const formData = new FormData(form);
        const selectedMeja = mejaSelect.value; // simpan meja yang dipilih

        fetch("{{ route('user.reservasi.store') }}", {
            method: "POST",
            body: formData
        })
        .then(r => r.json())
        .then(res => {
            if (res.status === 'success') {

                Swal.fire({
                    icon: 'success',
                    title: 'Reservasi Berhasil',
                    text: 'Meja berhasil dipesan.',
                    timer: 1800,
                    showConfirmButton: false
                }).then(() => {
                    // scroll ke section reservasi
                    const reservasiSection = document.getElementById('reservasi');
                    reservasiSection.scrollIntoView({ behavior: 'smooth' });

                    // Hapus meja yang baru dipesan dari dropdown
                    if (selectedMeja) {
                        const optionToRemove = mejaSelect.querySelector(`option[value="${selectedMeja}"]`);
                        if (optionToRemove) optionToRemove.remove();
                    }

                    // reload meja kosong
                    loadMejaKosong();

                    // ================================
                    // Update tabel admin secara realtime
                    // ================================
                    if (window.reloadAdminTable) {
                        window.reloadAdminTable(); // panggil fungsi global admin untuk render tabel terbaru
                    }
                });

                form.reset(); // reset form
            }
        })
        .catch(err => {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Terjadi kesalahan.'
            });
        });
    });

    // ================================
    // Fungsi global agar admin bisa memanggil reload meja user
    // ================================
    window.reloadUserMeja = function() {
        loadMejaKosong();
    };

    // Load initial meja kosong saat halaman dibuka
    loadMejaKosong();
});
</script>
