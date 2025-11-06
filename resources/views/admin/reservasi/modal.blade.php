<div class="modal fade" id="modalLihatReservasi" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width:450px;">
    <div class="modal-content" style="background:#2b2b2b; border:1px solid #3a3a3a; border-radius:14px; color:#FFF; padding:20px;">

      <!-- Header -->
      <div class="modal-header border-0" style="justify-content:center; position:relative;">
        <h5 class="modal-title" style="color:#c18b4a; font-weight:700; text-align:center; width:100%;">Catatan Reservasi</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" style="position:absolute; right:15px; top:15px;"></button>
      </div>

        <div class="modal-body">
      <div id="catatanWrapper" style="background:#3a3a3a; border-radius:10px; padding:15px; min-height:120px; width:100%; max-width:550px; margin:0 auto;">
        <p id="detail-catatan" style="margin:0; color:#FFF; word-wrap:break-word;">-</p>
      </div>
    </div>


    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const modalEl = document.getElementById('modalLihatReservasi');
    const detailCatatan = document.getElementById('detail-catatan');

    // Event delegation untuk tombol lihat catatan
    document.addEventListener('click', e => {
        const btn = e.target.closest('.btn-lihat');
        if (!btn) return;
        const catatan = btn.getAttribute('data-catatan');
        detailCatatan.textContent = catatan || '-';

        // Tampilkan modal Bootstrap
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
    });
});
</script>