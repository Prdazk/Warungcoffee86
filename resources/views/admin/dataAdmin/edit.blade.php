@props(['admin'])

<div class="modal fade" id="editAdminModal{{ $admin->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" style="margin-top:-10px;">
        <div class="modal-content"
             style="background:#1b1b1b; color:#fff; border-radius:14px; border:1px solid #3a3a3a; box-shadow:0 0 20px rgba(0,0,0,0.7); padding-bottom:10px;">

            <div class="modal-header border-0">
                <h5 class="modal-title"
                    style="width:100%; text-align:center; font-size:20px; font-weight:700; letter-spacing:1px; color:#c18b4a; text-transform:uppercase;">
                    Edit Admin
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('admin.dataAdmin.update', $admin->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-body" style="padding-top:5px;">

                    @if($errors->any())
                        <div class="alert alert-danger bg-danger-subtle text-danger border-0">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label" style="color:#c18b4a;">Nama</label>
                            <input type="text" name="nama" class="form-control shadow-sm"
                                   value="{{ old('nama', $admin->nama) }}" required
                                   style="background:#262626; border-radius:10px; border:1px solid #444; color:#fff;">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" style="color:#c18b4a;">Email</label>
                            <input type="email" name="email" class="form-control shadow-sm"
                                   value="{{ old('email', $admin->email) }}" required
                                   style="background:#262626; border-radius:10px; border:1px solid #444; color:#fff;">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" style="color:#c18b4a;">Jabatan</label>
                            <select name="jabatan" class="form-select shadow-sm" required
                                    style="background:#262626; border-radius:10px; border:1px solid #444; color:#fff;">
                                <option value="" style="color:#888;">-- Pilih Jabatan --</option>
                                <option value="admin" style="color:#fff;" {{ old('jabatan', $admin->jabatan) == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="superadmin" style="color:#fff;" {{ old('jabatan', $admin->jabatan) == 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" style="color:#c18b4a;">No HP</label>
                            <input type="text" name="no_hp" class="form-control shadow-sm"
                                   value="{{ old('no_hp', $admin->no_hp) }}"
                                   style="background:#262626; border-radius:10px; border:1px solid #444; color:#fff;">
                        </div>

                        <input type="hidden" name="role" value="{{ old('jabatan', $admin->jabatan) }}">

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
                        Update
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>