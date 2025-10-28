<!-- ===== Modal Hapus Menu ===== -->
<div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" style="margin-top:80px; max-width:400px;">
    <div class="modal-content shadow-lg rounded-4 p-4 text-center" style="background:#4B3621; color:#FFF;">

      <!-- Pesan -->
      <h5 class="mb-4 fw-semibold">Apakah Anda yakin ingin menghapus menu ini?</h5>

      <!-- Tombol Aksi -->
      <div class="d-flex justify-content-center gap-3">
        <button type="button" class="btn px-4 py-2 rounded-3 fw-semibold"
                style="background:#D32F2F; color:#FFF; box-shadow:0 4px 10px rgba(0,0,0,0.2); transition:all 0.2s ease;"
                data-bs-dismiss="modal" id="btnCancelDelete">Batal</button>
        <button type="button" class="btn px-4 py-2 rounded-3 fw-semibold"
                style="background:#8B5E3C; color:#FFF; box-shadow:0 4px 10px rgba(0,0,0,0.2); transition:all 0.2s ease;"
                id="btnConfirmDelete">Hapus</button>
      </div>

    </div>
  </div>
</div>

<!-- Form Hapus (disembunyikan untuk submit) -->
<form id="deleteForm" method="POST" style="display:none;">
  @csrf
  @method('DELETE')
</form>
