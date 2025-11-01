<!-- Modal Tambah Admin -->
<div class="modal fade" id="tambahAdminModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" style="margin-top:-20px;">
        <div class="modal-content"
             style="background:#1b1b1b; color:#fff; border-radius:14px; border:1px solid #3a3a3a; box-shadow:0 0 20px rgba(0,0,0,0.6); padding-bottom:10px;">

            <!-- Header -->
            <div class="modal-header border-0">
                <h5 class="modal-title text-center text-uppercase fw-bold"
                    style="color:#c18b4a; width:100%; letter-spacing:1px;">
                    Tambah Admin Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- Form -->
            <form action="{{ route('admin.dataAdmin.store') }}" method="POST">
                @csrf
                <div class="modal-body pt-1">

                    <!-- Error -->
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
                        <!-- Nama -->
                        <div class="col-md-6">
                            <label class="form-label" style="color:#c18b4a;">Nama</label>
                            <input type="text" name="nama" placeholder="Masukkan nama"
                                   value="{{ old('nama') }}" required
                                   class="form-control form-control-dark"
                                   style="background:rgba(30,30,30,0.95); border-radius:10px; border:1px solid #444; color:#eee;">
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label class="form-label" style="color:#c18b4a;">Email</label>
                            <input type="email" name="email" placeholder="Masukkan email"
                                   value="{{ old('email') }}" required
                                   class="form-control form-control-dark"
                                   style="background:rgba(30,30,30,0.95); border-radius:10px; border:1px solid #444; color:#eee;">
                        </div>

                        <!-- Jabatan -->
                        <div class="col-md-6">
                            <label class="form-label" style="color:#c18b4a;">Jabatan</label>
                            <select name="jabatan" class="form-select form-select-dark" required
                                    style="background:rgba(30,30,30,0.95); border-radius:10px; border:1px solid #444; color:#eee;">
                                <option value="" disabled selected style="color:#aaa;">-- Pilih Jabatan --</option>
                                <option value="admin" {{ old('jabatan')=='admin' ? 'selected' : '' }}>Admin</option>
                                <option value="superadmin" {{ old('jabatan')=='superadmin' ? 'selected' : '' }}>Superadmin</option>
                            </select>
                        </div>

                        <!-- No HP -->
                        <div class="col-md-6">
                            <label class="form-label" style="color:#c18b4a;">No HP</label>
                            <input type="text" name="no_hp" placeholder="Masukkan No HP"
                                   value="{{ old('no_hp') }}"
                                   class="form-control form-control-dark"
                                   style="background:rgba(30,30,30,0.95); border-radius:10px; border:1px solid #444; color:#eee;">
                        </div>

                        <!-- Password -->
                        <div class="col-md-6 position-relative">
                            <label class="form-label" style="color:#c18b4a;">Password</label>
                            <input type="password" name="password" placeholder="Masukkan password"
                                   required
                                   class="form-control form-control-dark"
                                   style="background:rgba(30,30,30,0.95); border-radius:10px; border:1px solid #444; color:#eee; padding-right:2.5rem;">
                            <span class="toggle-password"
                                  style="position:absolute; top:50%; right:10px; transform:translateY(-50%); cursor:pointer; font-size:1.2rem;">🙈</span>
                        </div>

                        <!-- Konfirmasi Password -->
                        <div class="col-md-6 position-relative">
                            <label class="form-label" style="color:#c18b4a;">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" placeholder="Konfirmasi password"
                                   required
                                   class="form-control form-control-dark"
                                   style="background:rgba(30,30,30,0.95); border-radius:10px; border:1px solid #444; color:#eee; padding-right:2.5rem;">
                            <span class="toggle-password"
                                  style="position:absolute; top:50%; right:10px; transform:translateY(-50%); cursor:pointer; font-size:1.2rem;">🙈</span>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer border-0 justify-content-center gap-3 pb-3">
                    <button type="button" class="btn" data-bs-dismiss="modal"
                            style="background:#5b5b5b; border-radius:8px; padding:8px 30px; font-weight:600; color:#fff; border:none;">
                        Batal
                    </button>
                    <button type="submit" class="btn"
                            style="background:#c18b4a; border-radius:8px; padding:8px 30px; font-weight:600; color:#fff; border:none;">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
