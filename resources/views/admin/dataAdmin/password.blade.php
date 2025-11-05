@props(['admin'])

<div class="modal fade" id="passwordAdminModal{{ $admin->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:430px; margin-top:-10px;">
        <div class="modal-content"
             style="background:#1b1b1b; color:#fff; border-radius:14px; border:1px solid #3a3a3a; box-shadow:0 0 20px rgba(0,0,0,0.7);">

            <div class="modal-header border-0">
                <h5 class="modal-title"
                    style="width:100%; text-align:center; font-size:18px; font-weight:700; letter-spacing:1px; color:#c18b4a;">
                    Ubah Password: {{ $admin->nama }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('admin.dataAdmin.updatePassword', $admin) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-body d-flex flex-column gap-3" style="padding-top:0px;">

                    <div class="position-relative w-100">
                        <label class="form-label" style="color:#c18b4a; font-weight:600;">Password Baru</label>
                        <input type="password" name="password" placeholder="Masukkan password baru"
                               required
                               style="background:#262626; border-radius:10px; border:1px solid #444; color:#fff; padding-right:2.3rem;">
                        <span class="toggle-password"
                              style="position:absolute; top:50%; right:12px; transform:translateY(-50%); cursor:pointer; font-size:1.2rem;">🙈</span>
                    </div>

                    <div class="position-relative w-100">
                        <label class="form-label" style="color:#c18b4a; font-weight:600;">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" placeholder="Konfirmasi password baru"
                               required
                               style="background:#262626; border-radius:10px; border:1px solid #444; color:#fff; padding-right:2.3rem;">
                        <span class="toggle-password"
                              style="position:absolute; top:50%; right:12px; transform:translateY(-50%); cursor:pointer; font-size:1.2rem;">🙈</span>
                    </div>

                </div>

                <div class="modal-footer border-0 justify-content-center gap-3 pb-3">
                    <button type="button"
                            class="btn"
                            data-bs-dismiss="modal"
                            style="background:#5b5b5b; border-radius:8px; padding:8px 30px; font-weight:600; color:#fff; border:none;">
                        Batal
                    </button>

                    <button type="submit"
                            class="btn"
                            style="background:#c18b4a; border-radius:8px; padding:8px 30px; font-weight:600; color:#fff; border:none;">
                        Simpan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>