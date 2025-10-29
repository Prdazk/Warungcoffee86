@extends('admin.layout.app')

@section('title', 'Data Admin')

@section('content')
<div class="container py-2">

    <!-- Tombol Tambah Admin -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahAdminModal">
        + Tambah Admin
    </button>

    <!-- Tabel Data Admin -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Jabatan</th>
                    <th>No HP</th>
                    <th>Status</th> <!-- sebelumnya Role -->
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($admins as $index => $admin)
                <tr>
                    <td>{{ $admins->firstItem() + $index }}</td>
                    <td>{{ $admin->nama }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>{{ $admin->jabatan }}</td>
                    <td>{{ $admin->no_hp ?? '-' }}</td>
                    <td>
                        @if($admin->role == 'superadmin')
                            <span class="badge bg-success">Superadmin</span>
                        @else
                            <span class="badge bg-primary">Admin</span>
                        @endif
                    </td>
                    <td>
                        <button class="btn btn-warning btn-sm me-1" data-bs-toggle="modal" data-bs-target="#editAdminModal{{ $admin->id }}">✏️</button>
                        <button class="btn btn-danger btn-sm me-1" data-bs-toggle="modal" data-bs-target="#deleteAdminModal{{ $admin->id }}">🗑️</button>
                        <button class="btn btn-secondary btn-sm ms-1" data-bs-toggle="modal" data-bs-target="#passwordAdminModal{{ $admin->id }}">🔒</button>
                    </td>
                </tr>
                
         <!-- Modal Edit Admin -->
<div class="modal fade" id="editAdminModal{{ $admin->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" style="margin-top:-10px;">
        <div class="modal-content"
             style="background:#1b1b1b; color:#fff; border-radius:14px; border:1px solid #3a3a3a; box-shadow:0 0 20px rgba(0,0,0,0.7); padding-bottom:10px;">

            <!-- Header -->
            <div class="modal-header border-0">
                <h5 class="modal-title"
                    style="width:100%; text-align:center; font-size:20px; font-weight:700; letter-spacing:1px; color:#c18b4a; text-transform:uppercase;">
                    Edit Admin
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- Form -->
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

                        <!-- Nama -->
                        <div class="col-md-6">
                            <label class="form-label" style="color:#c18b4a;">Nama</label>
                            <input type="text" name="nama" class="form-control shadow-sm"
                                   value="{{ old('nama', $admin->nama) }}" required
                                   style="background:#262626; border-radius:10px; border:1px solid #444; color:#fff;">
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label class="form-label" style="color:#c18b4a;">Email</label>
                            <input type="email" name="email" class="form-control shadow-sm"
                                   value="{{ old('email', $admin->email) }}" required
                                   style="background:#262626; border-radius:10px; border:1px solid #444; color:#fff;">
                        </div>

                      <!-- Jabatan -->
                        <div class="col-md-6">
                            <label class="form-label" style="color:#c18b4a;">Jabatan</label>
                            <select name="jabatan" class="form-select shadow-sm" required
                                    style="background:#262626; border-radius:10px; border:1px solid #444; color:#fff;">
                                <option value="" style="color:#888;">-- Pilih Jabatan --</option>
                                <option value="admin" style="color:#fff;" {{ old('jabatan', $admin->jabatan) == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="superadmin" style="color:#fff;" {{ old('jabatan', $admin->jabatan) == 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                            </select>
                        </div>


                        <!-- No HP -->
                        <div class="col-md-6">
                            <label class="form-label" style="color:#c18b4a;">No HP</label>
                            <input type="text" name="no_hp" class="form-control shadow-sm"
                                   value="{{ old('no_hp', $admin->no_hp) }}"
                                   style="background:#262626; border-radius:10px; border:1px solid #444; color:#fff;">
                        </div>

                        <!-- Role -->
                            <div class="col-md-6">
                                <label class="form-label" style="color:#c18b4a;">Status</label>
                                <select name="role" class="form-select shadow-sm" required
                                        style="background:#262626; border-radius:10px; border:1px solid #444; color:#fff;">
                                    <option value="admin" style="color:#fff;" {{ old('role', $admin->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="superadmin" style="color:#fff;" {{ old('role', $admin->role) == 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                                </select>
                            </div>


                    </div>
                </div>

                <!-- Footer Tombol Tengah -->
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


                    
   <!-- ===== Modal Hapus Admin ===== -->
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


<!-- Modal Password Admin -->
<div class="modal fade" id="passwordAdminModal{{ $admin->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:430px; margin-top:-10px;">
        <div class="modal-content"
             style="background:#1b1b1b; color:#fff; border-radius:14px; border:1px solid #3a3a3a; box-shadow:0 0 20px rgba(0,0,0,0.7);">

            <!-- Header -->
            <div class="modal-header border-0">
                <h5 class="modal-title"
                    style="width:100%; text-align:center; font-size:18px; font-weight:700; letter-spacing:1px; color:#c18b4a;">
                    Ubah Password: {{ $admin->nama }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- Form -->
            <form action="{{ route('admin.dataAdmin.updatePassword', $admin) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-body d-flex flex-column gap-3" style="padding-top:0px;">

                    <!-- Password Lama -->
                    <div class="position-relative w-100">
                        <label class="form-label" style="color:#c18b4a; font-weight:600;">Password Lama</label>
                        <input type="password" name="current_password" placeholder="Masukkan password lama"
                               required
                               style="background:#262626; border-radius:10px; border:1px solid #444; color:#fff; padding-right:2.3rem;">
                        <span class="toggle-password"
                              style="position:absolute; top:50%; right:12px; transform:translateY(-50%); cursor:pointer; font-size:1.2rem;">🙈</span>
                    </div>

                    <!-- Password Baru -->
                    <div class="position-relative w-100">
                        <label class="form-label" style="color:#c18b4a; font-weight:600;">Password Baru</label>
                        <input type="password" name="password" placeholder="Masukkan password baru"
                               required
                               style="background:#262626; border-radius:10px; border:1px solid #444; color:#fff; padding-right:2.3rem;">
                        <span class="toggle-password"
                              style="position:absolute; top:50%; right:12px; transform:translateY(-50%); cursor:pointer; font-size:1.2rem;">🙈</span>
                    </div>

                    <!-- Konfirmasi -->
                    <div class="position-relative w-100">
                        <label class="form-label" style="color:#c18b4a; font-weight:600;">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" placeholder="Konfirmasi password anda"
                               required
                               style="background:#262626; border-radius:10px; border:1px solid #444; color:#fff; padding-right:2.3rem;">
                        <span class="toggle-password"
                              style="position:absolute; top:50%; right:12px; transform:translateY(-50%); cursor:pointer; font-size:1.2rem;">🙈</span>
                    </div>

                </div>

                <!-- Buttons -->
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


                @endforeach
            </tbody>
        </table>
    </div>
    
  <div style="margin-top:10px; display:flex; justify-content:center; gap:10px;">
    <a href="{{ $admins->previousPageUrl() ?? '#' }}"
       class="btn"
       style="padding:6px 12px; border-radius:6px; border:none; background:#795548; color:white; {{ $admins->onFirstPage() ? 'pointer-events:none; opacity:0.6;' : '' }}">
       Kembali
    </a>
    <a href="{{ $admins->nextPageUrl() ?? '#' }}"
       class="btn"
       style="padding:6px 12px; border-radius:6px; border:none; background:#795548; color:white; {{ $admins->hasMorePages() ? '' : 'pointer-events:none; opacity:0.6;' }}">
       Lanjut
    </a>
</div>


<!-- Modal Tambah Admin -->
<div class="modal fade" id="tambahAdminModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" style="margin-top:-20px;">
        <div class="modal-content"
             style="background:#1b1b1b; color:#fff; border-radius:14px; border:1px solid #3a3a3a; box-shadow:0 0 20px rgba(0,0,0,0.6); padding-bottom:10px;">

            <!-- Header -->
            <div class="modal-header border-0">
                <h5 class="modal-title"
                    style="width:100%; text-align:center; font-size:20px; font-weight:700; letter-spacing:1px; color:#c18b4a; text-transform:uppercase;">
                    Tambah Admin Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- Form -->
            <form action="{{ route('admin.dataAdmin.store') }}" method="POST">
                @csrf

                <div class="modal-body" style="padding-top:5px;">

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
                                   value="{{ old('nama') }}"
                                   required
                                   style="background:rgba(30,30,30,0.9); border-radius:10px; border:1px solid #444; color:#fff;">
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label class="form-label" style="color:#c18b4a;">Email</label>
                            <input type="email" name="email" placeholder="Masukkan email"
                                   value="{{ old('email') }}"
                                   required
                                   style="background:rgba(30,30,30,0.9); border-radius:10px; border:1px solid #444; color:#fff;">
                        </div>

                        <!-- Jabatan -->
                        <div class="col-md-6">
                            <label class="form-label" style="color:#c18b4a;">Jabatan</label>
                            <input type="text" name="jabatan" placeholder="Masukkan jabatan"
                                   value="{{ old('jabatan') }}"
                                   required
                                   style="background:rgba(30,30,30,0.9); border-radius:10px; border:1px solid #444; color:#fff;">
                        </div>

                        <!-- No HP -->
                        <div class="col-md-6">
                            <label class="form-label" style="color:#c18b4a;">No HP</label>
                            <input type="text" name="no_hp" placeholder="Masukkan No HP"
                                   value="{{ old('no_hp') }}"
                                   style="background:rgba(30,30,30,0.9); border-radius:10px; border:1px solid #444; color:#fff;">
                        </div>

                       <!-- Status -->
                        <div class="col-md-6">
                            <label class="form-label" style="color:#c18b4a;">Status</label>
                            <select name="role" class="form-select shadow-sm" required
                                    style="background:rgba(30,30,30,0.9); border-radius:10px; border:1px solid #444; color:#fff;">
                                <option value="" style="color:#888;">-- Pilih Status --</option>
                                <option value="admin" style="color:#fff;" {{ old('role')=='admin' ? 'selected' : '' }}>Admin</option>
                                <option value="superadmin" style="color:#fff;" {{ old('role')=='superadmin' ? 'selected' : '' }}>Superadmin</option>
                            </select>
                        </div>


                        <!-- Password -->
                        <div class="col-md-6 position-relative">
                            <label class="form-label" style="color:#c18b4a;">Password</label>
                            <input type="password" name="password" placeholder="Masukkan password"
                                   required
                                   style="background:rgba(30,30,30,0.9); border-radius:10px; border:1px solid #444; color:#fff; padding-right:2.5rem;">
                            <span class="toggle-password"
                                  style="position:absolute; top:50%; right:10px; transform:translateY(-50%); cursor:pointer; font-size:1.2rem;">🙈</span>
                        </div>

                        <!-- Konfirmasi Password -->
                        <div class="col-md-6 position-relative">
                            <label class="form-label" style="color:#c18b4a;">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" placeholder="Konfirmasi password"
                                   required
                                   style="background:rgba(30,30,30,0.9); border-radius:10px; border:1px solid #444; color:#fff; padding-right:2.5rem;">
                            <span class="toggle-password"
                                  style="position:absolute; top:50%; right:10px; transform:translateY(-50%); cursor:pointer; font-size:1.2rem;">🙈</span>
                        </div>

                    </div>
                </div>

                <!-- Footer -->
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


<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

  // =======================
  // 👁️ Toggle Password View
  // =======================
  const toggleSpans = document.querySelectorAll('.toggle-password');
  toggleSpans.forEach(span => {
    span.addEventListener('click', function () {
      const input = this.previousElementSibling;
      if (!input) return;

      if (input.type === "password") {
        input.type = "text";
        this.textContent = "👀";
        setTimeout(() => {
          input.type = "password";
          this.textContent = "🙈";
        }, 1000);
      }
    });
  });

  // =======================
  // ✨ Modal Sukses (Animasi Masuk + Otomatis Hilang)
  // =======================
  const modalEl = document.getElementById('successModal');
  if (modalEl) {
    const modalContent = modalEl.querySelector('.modal-content');
    const bsModal = new bootstrap.Modal(modalEl);

    modalContent.style.transform = 'scale(0.8)';
    modalContent.style.opacity = '0';
    bsModal.show();

    requestAnimationFrame(() => {
      modalContent.style.transform = 'scale(1)';
      modalContent.style.opacity = '1';
      modalContent.style.transition = 'all 0.3s ease';
    });

    setTimeout(() => {
      modalContent.style.transform = 'scale(0.8)';
      modalContent.style.opacity = '0';
      setTimeout(() => bsModal.hide(), 300);
    }, 3000);
  }

  // =======================
  // 🔄 Pagination (Next & Prev)
  // =======================
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');

prevBtn?.addEventListener('click', () => {
    const prevUrl = prevBtn.dataset.url;
    if (prevUrl) window.location.href = prevUrl;
});

nextBtn?.addEventListener('click', () => {
    const nextUrl = nextBtn.dataset.url;
    if (nextUrl) window.location.href = nextUrl;
});


  // =======================
  // ⚠️ Konfirmasi Hapus Admin
  // =======================
  document.querySelectorAll('.btn-hapus').forEach(btn => {
    btn.addEventListener('click', function (e) {
      e.preventDefault();
      const form = this.closest('form');

      Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: "Data admin ini akan hilang permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          form.submit();
        }
      });
    });
  });

  // =======================
  // ✅ Notifikasi Setelah Tambah / Edit / Update
  // (gunakan session()->has('success') di Blade)
  // =======================
  @if(session('success'))
    Swal.fire({
      icon: 'success',
      title: 'Berhasil!',
      text: "{{ session('success') }}",
      timer: 1500,
      showConfirmButton: false
    });
  @endif

  @if(session('error'))
    Swal.fire({
      icon: 'error',
      title: 'Gagal!',
      text: "{{ session('error') }}",
    });
  @endif

  // =======================
  // 🚫 Tampilkan Modal Ganti Password jika Ada Error Validasi
  // =======================
  @if($errors->has('current_password') || $errors->has('password') || $errors->has('password_confirmation'))
    const errorModal = new bootstrap.Modal(document.getElementById('passwordAdminModal{{ $admin->id }}'));
    errorModal.show();
    Swal.fire({
      icon: 'error',
      title: 'Kesalahan!',
      text: 'Periksa kembali input password Anda.',
    });
  @endif

});
</script>
@endsection
