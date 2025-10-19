<div id="modalLihatReservasi" 
     style="display:none;
            position:fixed;
            top:0; left:0;
            width:100%; height:100%;
            background:rgba(0,0,0,0.5);
            justify-content:center;
            align-items:center;
            transition:opacity 0.3s ease;">
  
  <div id="modalContent"
       style="background:#fff;
              padding:30px;
              border-radius:12px;
              width:600px;
              max-width:90%;
              box-shadow:0 10px 25px rgba(0,0,0,0.3);
              transform:scale(0.8);
              opacity:0;
              transition:all 0.3s ease;">
    
    <!-- Tombol Tutup -->
    <button id="closeModalBtn" 
            style="float:right;
                   background:#f44336;
                   color:#fff;
                   border:none;
                   padding:6px 12px;
                   border-radius:6px;
                   cursor:pointer;
                   font-size:14px;">
      Tutup
    </button>

    <h2 style="margin-top:10px; margin-bottom:25px; text-align:center; font-size:22px;">Detail Reservasi</h2>

    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:15px;">
      <div style="border:1px solid #ddd; border-radius:8px; padding:10px 15px;">
        <strong>Nama</strong>
        <p id="detail-nama" style="margin:5px 0 0 0;"></p>
      </div>
      <div style="border:1px solid #ddd; border-radius:8px; padding:10px 15px;">
        <strong>Jumlah Orang</strong>
        <p id="detail-jumlah" style="margin:5px 0 0 0;"></p>
      </div>
      <div style="border:1px solid #ddd; border-radius:8px; padding:10px 15px;">
        <strong>Meja</strong>
        <p id="detail-meja" style="margin:5px 0 0 0;"></p>
      </div>
      <div style="border:1px solid #ddd; border-radius:8px; padding:10px 15px;">
        <strong>Tanggal</strong>
        <p id="detail-tanggal" style="margin:5px 0 0 0;"></p>
      </div>
      <div style="border:1px solid #ddd; border-radius:8px; padding:10px 15px;">
        <strong>Jam</strong>
        <p id="detail-jam" style="margin:5px 0 0 0;"></p>
      </div>
      <div style="grid-column: span 2; border:1px solid #ddd; border-radius:8px; padding:10px 15px;">
        <strong>Catatan</strong>
        <p id="detail-catatan" style="margin:5px 0 0 0; white-space:pre-line;"></p>
      </div>
    </div>
  </div>
</div>
    