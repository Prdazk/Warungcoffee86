@php
use App\Models\Meja;
$mejaKosong = $mejaKosong ?? Meja::where('status_meja', 'Kosong')->orderBy('id')->get();
@endphp

<section id="reservasi">
    <div class="reservasi-container" style="gap:40px; margin-top:50px;">

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
                        <input type="time" 
                            id="jamInput" 
                            name="jam" 
                            required 
                            class="input-field"
                            style="padding:7px 10px; font-size:13px;"
                            value="{{ old('jam') ?? \Carbon\Carbon::now()->format('H:i') }}">
                    </div>



                </div>

                <div class="full-width" style="margin-bottom:12px;">
                    <label style="font-size:12px;">Pilih Meja</label>

                  <select id="mejaSelect" name="meja_id" required class="input-field" style="padding:7px 10px; font-size:13px;">
                        <option value="">-- Pilih Meja --</option>
                        @foreach($mejaKosong as $meja)
                            <option value="{{ $meja->id }}">{{ $meja->nama_meja }} (Kosong)</option>
                        @endforeach
                    </select>


                </div>

                <div class="full-width" style="margin-bottom:14px;">
                    <label style="font-size:12px;">Pesan</label>
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
    <h3 style="text-align:center; margin-bottom:10px; font-size:15px;">Syarat & Ketentuan Reservasi</h3>
    <ul style="line-height:1.4; font-size:13px;">
        <li>Reservasi bisa dilakukan online atau langsung di tempat.</li>
        <li>Reservasi online minimal 30 menit sebelum kedatangan.</li>
        <li>Jam reservasi: 07:00 – 22:00.</li>
        <li>Maksimal 4 orang per meja.</li>
        <li>Datang tepat waktu agar meja siap.</li>
        <li>Tulis alergi atau permintaan khusus di catatan.</li>
        <li>Pembatalan maksimal 1 jam sebelum kedatangan.</li>
        <li>Hanya meja yang tersedia yang bisa dipilih.</li>
        <li>Reservasi hanya untuk tanggal sekarang atau berikutnya.</li>
    </ul>
</div>


    </div>
</section>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('reservasiForm');
    const mejaSelect = document.getElementById('mejaSelect');
    const tanggalInput = document.getElementById('tanggalInput');
    const jamInput = document.getElementById('jamInput');

    function loadMejaKosong() {
        const tanggal = tanggalInput.value || ''; // tetap fetch walau kosong
        const jam = jamInput.value || '';

        fetch(`/user/reservasi/available-meja?tanggal=${tanggal}&jam=${jam}`)
            .then(r => r.json())
            .then(data => {
                const selected = mejaSelect.value;

                const existingIds = Array.from(mejaSelect.options).map(o => o.value);
                const dataIds = data.map(m => m.id.toString());

                // Hapus opsi yang sudah tidak ada
                existingIds.forEach(id => {
                    if (id !== '' && !dataIds.includes(id)) {
                        const opt = mejaSelect.querySelector(`option[value="${id}"]`);
                        if(opt) opt.remove();
                    }
                });

                // Tambahkan opsi baru
                data.forEach(m => {
                    if (!existingIds.includes(m.id.toString())) {
                        const opt = document.createElement('option');
                        opt.value = m.id;
                        opt.textContent = `${m.nama_meja} (Kosong)`;
                        mejaSelect.appendChild(opt);
                    }
                });

                // Kembalikan pilihan user jika masih tersedia
                if (selected && mejaSelect.querySelector(`option[value="${selected}"]`)) {
                    mejaSelect.value = selected;
                }
            })
            .catch(err => console.error('Gagal load meja:', err));
    }

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(form);
        const selectedMeja = mejaSelect.value;

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
                    // Hilangkan meja yang dipilih
                    if (selectedMeja) {
                        const optionToRemove = mejaSelect.querySelector(`option[value="${selectedMeja}"]`);
                        if (optionToRemove) optionToRemove.remove();
                    }

                    loadMejaKosong(); // refresh meja terbaru

                    if (window.reloadAdminTable) window.reloadAdminTable();

                    setTimeout(() => form.reset(), 300);
                });
            }
        })
        .catch(() => Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: 'Terjadi kesalahan.'
        }));
    });

    document.addEventListener('meja:added', e => loadMejaKosong());
    document.addEventListener('meja:removed', e => loadMejaKosong());

    window.reloadUserMeja = loadMejaKosong;

    tanggalInput.addEventListener('change', loadMejaKosong);
    jamInput.addEventListener('change', loadMejaKosong);

    // Load awal meja kosong
    loadMejaKosong();

    const container = document.querySelector('.reservasi-container');
    const formSide = document.querySelector('.form-side');
    const syaratSide = document.querySelector('.syarat-side');

    function responsiveReservasi() {
        if (!container || !formSide || !syaratSide) return;

        if (window.innerWidth <= 600) {
            container.style.flexDirection = 'column';
            container.style.gap = '16px';
            formSide.style.width = '100%';
            formSide.style.maxWidth = '92%';
            formSide.style.margin = '20px 0 0 -8%';
            formSide.style.padding = '18px';
            syaratSide.style.width = '100%';
            syaratSide.style.maxWidth = '92%';
            syaratSide.style.margin = '0 auto';
            syaratSide.style.marginLeft = '-2%';
            syaratSide.style.padding = '15px';
        } else {
            container.style.flexDirection = 'row';
            container.style.gap = '25px';
            formSide.style.width = '60%';
            formSide.style.maxWidth = '100%';
            formSide.style.margin = '0';
            formSide.style.padding = '35px';
            syaratSide.style.width = '35%';
            syaratSide.style.maxWidth = '100%';
            syaratSide.style.margin = '0';
            syaratSide.style.padding = '16px 18px';
        }
    }

    responsiveReservasi();
    window.addEventListener('resize', responsiveReservasi);

    // Refresh meja setiap detik tanpa cek fokus
setInterval(loadMejaKosong, 1000);

});
</script>