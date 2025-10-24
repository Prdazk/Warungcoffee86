<!-- Modal Lihat Menu -->
<div class="modal fade" id="modalLihat" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg rounded-4" style="background:#4B3621; color:#FFF;">
      <div class="modal-header border-0">
        <h5 class="modal-title" id="modalNama">Menu</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body d-flex gap-3">
        <img id="modalGambar" src="{{ asset('images/placeholder.png') }}" class="rounded" style="max-width:200px;">
        <div>
          <p><strong>Harga:</strong> Rp <span id="modalHarga">0</span></p>
          <p><strong>Kategori:</strong> <span id="modalKategori">-</span></p>
          <p><strong>Status:</strong> <span id="modalStatus">-</span></p>
        </div>
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.view-menu').forEach(btn => {
        btn.addEventListener('click', function() {
            const nama = btn.dataset.nama;
            const harga = btn.dataset.harga;
            const kategori = btn.dataset.kategori;
            const status = btn.dataset.status;
            const gambar = btn.dataset.gambar;

            document.getElementById('modalNama').textContent = nama;
            document.getElementById('modalHarga').textContent = Number(harga).toLocaleString('id-ID');
            document.getElementById('modalKategori').textContent = kategori;
            document.getElementById('modalStatus').textContent = status;
            document.getElementById('modalGambar').src = gambar;

            new bootstrap.Modal(document.getElementById('modalLihat')).show();
        });
    });
});
</script>
