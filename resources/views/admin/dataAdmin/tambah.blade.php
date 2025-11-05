<div class="modal fade" id="tambahAdminModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" style="margin-top:-20px;">
        <div class="modal-content"
             style="background:#1b1b1b; color:#fff; border-radius:14px; border:1px solid #3a3a3a; box-shadow:0 0 20px rgba(0,0,0,0.6); padding-bottom:10px;">

            <div class="modal-header border-0">
                <h5 class="modal-title text-center text-uppercase fw-bold"
                    style="color:#c18b4a; width:100%; letter-spacing:1px;">
                    Tambah Admin Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('admin.dataAdmin.store') }}" method="POST">
                @csrf

                <div class="modal-body pt-1">

                    @if($errors->any())
                        <div class="alert alert-danger bg-danger-subtle text-danger border-0">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <style>
                        .input-dark, .select-dark {
                            background: #2b2b2b !important;
                            border: 1px solid #555 !important;
                            border-radius: 10px;
                            color: #fff !important;
                        }
                        .input-dark::placeholder {
                            color: #bbbbbb !important;
                        }
                    </style>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" style="color:#c18b4a;">Nama</label>
                            <input type="text" name="nama" placeholder="Masukkan nama"
                                   value="{{ old('nama') }}" required
                                   class="form-control input-dark">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" style="color:#c18b4a;">Email</label>
                            <input type="email" name="email" placeholder="Masukkan email"
                                   value="{{ old('email') }}" required
                                   class="form-control input-dark">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" style="color:#c18b4a;">Jabatan</label>
                            <select name="jabatan" class="form-select select-dark" required>
                                <option value="" disabled selected>-- Pilih Jabatan --</option>
                                <option value="admin" {{ old('jabatan')=='admin' ? 'selected' : '' }}>Admin</option>
                                <option value="superadmin" {{ old('jabatan')=='superadmin' ? 'selected' : '' }}>Superadmin</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" style="color:#c18b4a;">No HP</label>
                            <input type="text" name="no_hp" placeholder="Masukkan No HP"
                                   value="{{ old('no_hp') }}" class="form-control input-dark">
                        </div>

                        <div class="col-md-6 position-relative">
                            <label class="form-label" style="color:#c18b4a;">Password</label>
                            <input type="password" name="password" placeholder="Masukkan password"
                                   required class="form-control input-dark" style="padding-right:2.5rem;">
                            <span class="toggle-password"
                                  style="position:absolute; top:50%; right:10px; transform:translateY(-50%); cursor:pointer; font-size:1.2rem;">🙈</span>
                        </div>

                        <div class="col-md-6 position-relative">
                            <label class="form-label" style="color:#c18b4a;">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" placeholder="Konfirmasi password"
                                   required class="form-control input-dark" style="padding-right:2.5rem;">
                            <span class="toggle-password"
                                  style="position:absolute; top:50%; right:10px; transform:translateY(-50%); cursor:pointer; font-size:1.2rem;">🙈</span>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 justify-content-center gap-3 pb-3">
                    <button type="button" class="btn" data-bs-dismiss="modal"
                            style="background:#5b5b5b; border-radius:8px; padding:8px 30px; font-weight:600; color:#fff;">
                        Batal
                    </button>
                    <button type="submit" class="btn"
                            style="background:#c18b4a; border-radius:8px; padding:8px 30px; font-weight:600; color:#fff;">
                        Simpan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>