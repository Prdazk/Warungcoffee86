<div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" style="margin-top:80px; max-width:400px;">
    <div class="modal-content shadow-lg rounded-4 p-4 text-center" style="background:#4B3621; color:#FFF;">
      <h5 class="mb-3">Apakah Anda yakin ingin menghapus menu ini?</h5>
      <div class="d-flex justify-content-center gap-3">
        <button type="button" class="btn" id="btnCancelDelete" 
                style="background:#D32F2F; color:#fff; padding:8px 18px; border-radius:8px; font-weight:bold;">
          Batal
        </button>
        <button type="button" class="btn" id="btnConfirmDelete" 
                style="background:#388E3C; color:#fff; padding:8px 18px; border-radius:8px; font-weight:bold;">
          Hapus
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Form Hapus (tetap disimpan untuk submit) -->
<form id="deleteForm" method="POST" style="display:none;">
  @csrf
  @method('DELETE')
</form>
