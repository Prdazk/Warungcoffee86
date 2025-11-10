@props(['admin'])

<div class="modal fade" id="deleteAdminModal{{ $admin->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width:420px; margin-top:-40px;">
    <div class="modal-content" style="
      background:#1b1b1b;
      color:#fff;
      border-radius:14px;
      border:1px solid #3a3a3a;
      box-shadow:0 0 20px rgba(0,0,0,0.6);
      padding:25px 20px 20px;
      text-align:center;
    ">

      <!-- Judul -->
      <h5 style="
        font-weight:700;
        color:#c18b4a;
        letter-spacing:1px;
        text-transform:uppercase;
        margin-bottom:18px;
      ">
        Hapus Admin
      </h5>

      <!-- Pesan -->
      <p style="
        font-size:14px;
        color:#e9e9e9;
        opacity:1;
        margin-bottom:25px;
      ">
        Apakah Anda yakin ingin menghapus admin ini?
      </p>

      <!-- Tombol Aksi -->
      <div class="d-flex justify-content-center gap-3">
        <button type="button"
                class="btn"
                style="
                  background:#5b5b5b;
                  border-radius:8px;
                  padding:8px 30px;
                  font-weight:600;
                  color:#fff;
                  transition:.3s;
                  border:none;
                  font-size:14px;"
                data-bs-dismiss="modal">Batal</button>

        <form action="{{ route('admin.dataAdmin.destroy', $admin->id) }}" method="POST">
          @csrf
          @method('DELETE')
          <button type="submit"
                  class="btn"
                  style="
                    background:#c18b4a;
                    border-radius:8px;
                    padding:8px 30px;
                    font-weight:600;
                    color:#fff;
                    transition:.3s;
                    border:none;
                    font-size:14px;">
            Hapus
          </button>
        </form>
      </div>

    </div>
  </div>
</div>