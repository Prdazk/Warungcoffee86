<!-- ===== Modal Lihat Reservasi ===== -->
<div id="modalLihatReservasi" 
     style="display:none;
            position:fixed;
            inset:0;
            width:100%; height:100%;
            background:rgba(0,0,0,0.6);
            justify-content:center;
            align-items:center;
            z-index:9999;
            opacity:0;
            transition:opacity 0.25s ease;">
  
  <div id="modalContent"
       style="background:#4B3621;
              color:#FFF;
              padding:30px;
              border-radius:16px;
              width:600px;
              max-width:90%;
              box-shadow:0 10px 30px rgba(0,0,0,0.4);
              transform:scale(0.85);
              opacity:0;
              transition:all 0.3s ease;">
    
    <!-- Tombol Tutup -->
    <button id="closeModalBtn" 
            style="float:right;
                   background:#f44336;
                   color:#fff;
                   border:none;
                   padding:6px 12px;
                   border-radius:8px;
                   cursor:pointer;
                   font-size:14px;
                   box-shadow:0 2px 6px rgba(0,0,0,0.3);">
      <i class="fas fa-times"></i>
    </button>

    <!-- Judul -->
    <h2 style="margin-top:10px; margin-bottom:25px; text-align:center; font-size:22px; font-weight:600;">
      <i class="fas fa-info-circle me-2"></i> Detail Reservasi
    </h2>

    <!-- Isi Detail -->
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">

      <div style="background:#815b3b; border-radius:8px; padding:12px 15px;">
        <strong>Nama</strong>
        <p id="detail-nama" style="margin:5px 0 0 0;"></p>
      </div>

      <div style="background:#815b3b; border-radius:8px; padding:12px 15px;">
        <strong>Jumlah Orang</strong>
        <p id="detail-jumlah" style="margin:5px 0 0 0;"></p>
      </div>

      <div style="background:#815b3b; border-radius:8px; padding:12px 15px;">
        <strong>Status Meja</strong>
        <p id="detail-meja" 
           style="margin:5px 0 0 0; 
                  font-weight:bold; 
                  padding:4px 8px; 
                  border-radius:6px; 
                  display:inline-block; 
                  color:#FFF;">
        </p>
      </div>

      <div style="background:#815b3b; border-radius:8px; padding:12px 15px;">
        <strong>Tanggal</strong>
        <p id="detail-tanggal" style="margin:5px 0 0 0;"></p>
      </div>

      <div style="background:#815b3b; border-radius:8px; padding:12px 15px;">
        <strong>Jam</strong>
        <p id="detail-jam" style="margin:5px 0 0 0;"></p>
      </div>

      <div style="grid-column: span 2; background:#815b3b; border-radius:8px; padding:12px 15px;">
        <strong>Catatan</strong>
        <p id="detail-catatan" style="margin:5px 0 0 0; white-space:pre-line;"></p>
      </div>
    </div>

  </div>
</div>

<!-- ===== Style Animasi ===== -->
<style>
#modalLihatReservasi.show { display:flex !important; opacity:1; }
#modalContent.show { transform:scale(1); opacity:1; }
</style>

<!-- ===== Script Modal ===== -->
<script>
const modal = document.getElementById('modalLihatReservasi');
const modalContent = document.getElementById('modalContent');
const closeModalBtn = document.getElementById('closeModalBtn');

function openModalLihatReservasi(data) {
    // Nama & Jumlah
    document.getElementById('detail-nama').textContent = data.nama || '-';
    document.getElementById('detail-jumlah').textContent = data.jumlah || '-';

    // Status meja otomatis: hanya Dipesan / Batal
    const mejaEl = document.getElementById('detail-meja');
    const status = (data.status || 'Dipesan').toLowerCase();
    if(status === 'batal'){
        mejaEl.textContent = 'Batal';
        mejaEl.style.background = '#e53935';
    } else {
        mejaEl.textContent = 'Dipesan';
        mejaEl.style.background = '#FF9800';
    }
    mejaEl.style.color = '#FFF';

    // Tanggal, Jam, Catatan
    document.getElementById('detail-tanggal').textContent = data.tanggal || '-';
    document.getElementById('detail-jam').textContent = data.jam || '-';
    document.getElementById('detail-catatan').textContent = data.catatan || '-';

    // Tampilkan modal
    modal.style.display = 'flex';
    requestAnimationFrame(()=>{ 
        modal.classList.add('show'); 
        modalContent.classList.add('show'); 
    });
}

function closeModal() {
    modal.classList.remove('show');
    modalContent.classList.remove('show');
    modal.style.opacity = '0';
    setTimeout(()=>{ modal.style.display='none'; modal.style.opacity='1'; }, 250);
}

// Event tombol
closeModalBtn.addEventListener('click', closeModal);
modal.addEventListener('click', e => { if(e.target===modal) closeModal(); });

// Tombol lihat di tabel
document.querySelectorAll('.btn-lihat').forEach(btn=>{
    btn.addEventListener('click', ()=>{
        const data = {
            nama: btn.getAttribute('data-nama'),
            jumlah: btn.getAttribute('data-jumlah'),
            status: btn.getAttribute('data-status') || 'Dipesan',
            tanggal: btn.getAttribute('data-tanggal'),
            jam: btn.getAttribute('data-jam'),
            catatan: btn.getAttribute('data-catatan')
        };
        openModalLihatReservasi(data);
    });
});
</script>
