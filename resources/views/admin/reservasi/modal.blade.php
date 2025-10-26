<!-- ===== Modal Lihat Reservasi (Final) ===== -->
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
        <strong>Meja</strong>
        <p id="detail-meja" style="margin:5px 0 0 0;"></p>
      </div>

      <!-- Status -->
      <div style="background:#815b3b; border-radius:8px; padding:12px 15px;">
        <strong>Status</strong>
        <p id="detail-status" 
           style="margin:5px 0 0 0; font-weight:bold; padding:4px 8px; border-radius:6px; display:inline-block;">
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

<!-- ===== Animasi Buka / Tutup ===== -->
<style>
  #modalLihatReservasi.show {
    display:flex !important;
    opacity:1;
  }

  #modalContent.show {
    transform:scale(1);
    opacity:1;
  }
</style>

<!-- ===== Script Modal ===== -->
<script>
  const modal = document.getElementById('modalLihatReservasi');
  const modalContent = document.getElementById('modalContent');
  const closeModalBtn = document.getElementById('closeModalBtn');

  // Buka modal dan isi data
  function openModalLihatReservasi(data) {
    document.getElementById('detail-nama').textContent = data.nama || '-';
    document.getElementById('detail-jumlah').textContent = data.jumlah || '-';
    document.getElementById('detail-meja').textContent = data.meja || '-';
    document.getElementById('detail-tanggal').textContent = data.tanggal || '-';
    document.getElementById('detail-jam').textContent = data.jam || '-';
    document.getElementById('detail-catatan').textContent = data.catatan || '-';

    // Status
    const statusEl = document.getElementById('detail-status');
    const status = data.status ? data.status : 'Dipesan'; // Default "Dipesan"
    statusEl.textContent = status;

    // Warna status
    if (status === 'Dipesan') {
      statusEl.style.background = '#FF9800';
    } else if (status === 'Dibatalkan') {
      statusEl.style.background = '#e53935';
    } else if (status === 'Terisi') {
      statusEl.style.background = '#4CAF50';
    } else { // fallback
      statusEl.style.background = '#757575';
    }

    // Tampilkan modal
    modal.style.display = 'flex';
    requestAnimationFrame(() => {
      modal.classList.add('show');
      modalContent.classList.add('show');
    });
  }

  // Tutup modal
  function closeModal() {
    modal.classList.remove('show');
    modalContent.classList.remove('show');
    modal.style.opacity = '0';
    setTimeout(() => {
      modal.style.display = 'none';
      modal.style.opacity = '1';
    }, 250);
  }

  closeModalBtn.addEventListener('click', closeModal);

  modal.addEventListener('click', (e) => {
    if (e.target === modal) closeModal();
  });

  // Tombol lihat di tabel (tidak perlu ubah HTML tombol)
  document.querySelectorAll('.btn-lihat').forEach(btn => {
    btn.addEventListener('click', () => {
      const data = {
        nama: btn.getAttribute('data-nama'),
        jumlah: btn.getAttribute('data-jumlah'),
        meja: btn.getAttribute('data-meja'),
        status: btn.getAttribute('data-status') || 'Dipesan', // default jika tidak ada
        tanggal: btn.getAttribute('data-tanggal'),
        jam: btn.getAttribute('data-jam'),
        catatan: btn.getAttribute('data-catatan'),
      };
      openModalLihatReservasi(data);
    });
  });
</script>
