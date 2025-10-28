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
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg rounded-4" style="background-color:#4B3621; color:#FFF;">

            <!-- Header -->
            <div class="modal-header border-0">
                <h5 class="modal-title">Edit Admin</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- Form -->
            <form action="{{ route('admin.dataAdmin.update', $admin->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-body">

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
                            <label class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control shadow-sm" 
                                   value="{{ old('nama', $admin->nama) }}" required
                                   style="background-color:#815b3b; color:#FFF; border:none;">
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control shadow-sm" 
                                   value="{{ old('email', $admin->email) }}" required
                                   style="background-color:#815b3b; color:#FFF; border:none;">
                        </div>

                        <!-- Jabatan -->
                        <div class="col-md-6">
                            <label class="form-label">Jabatan</label>
                            <select name="jabatan" class="form-select shadow-sm" required
                                    style="background-color:#815b3b; color:#FFF; border:none;">
                                <option value="">-- Pilih Jabatan --</option>
                                <option value="admin" {{ old('jabatan', $admin->jabatan) == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="superadmin" {{ old('jabatan', $admin->jabatan) == 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                            </select>
                        </div>

                        <!-- No HP -->
                        <div class="col-md-6">
                            <label class="form-label">No HP</label>
                            <input type="text" name="no_hp" class="form-control shadow-sm"
                                   value="{{ old('no_hp', $admin->no_hp) }}"
                                   style="background-color:#815b3b; color:#FFF; border:none;">
                        </div>

                        <!-- Role / Status -->
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select name="role" class="form-select shadow-sm" required
                                    style="background-color:#815b3b; color:#FFF; border:none;">
                                <option value="admin" {{ old('role', $admin->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="superadmin" {{ old('role', $admin->role) == 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                            </select>
                        </div>

                    </div>
                </div>

                <!-- Footer Tombol Tengah -->
                <div class="modal-footer border-0 justify-content-center gap-3">
                    <button type="button" class="btn btn-secondary px-4 py-2" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning px-4 py-2" style="background-color:#8B5E3C; border:none;">Update</button>
                </div>

            </form>
        </div>
    </div>
</div>

                    
               <!-- Modal Hapus Admin -->
<div class="modal fade" id="deleteAdminModal{{ $admin->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" style="max-width:380px; margin-top:80px;">
        <div class="modal-content shadow-lg rounded-4 border-0">

            <!-- Header -->
            <div class="modal-header" 
                 style="background:#4B3621; color:#ffffff; justify-content:center; text-align:center; border-bottom:none;">
                <h5 class="modal-title w-100" style="font-size:16px; font-weight:500;">
                    Apakah Anda yakin ingin menghapus admin ini?
                </h5>
            </div>

            <!-- Footer Tombol Tengah -->
            <div class="modal-footer justify-content-center gap-3 border-top-0 pt-3 pb-3">

                <!-- Tombol Yakin -->
                <form action="{{ route('admin.dataAdmin.destroy', $admin) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn"
                            style="background:#8B5E3C; color:#fff; padding:8px 20px; font-weight:bold; border-radius:8px; box-shadow:0 4px 10px rgba(0,0,0,0.2); transition:all 0.2s ease;">
                        Yakin
                    </button>
                </form>

                <!-- Tombol Batal -->
                <button type="button" class="btn" data-bs-dismiss="modal"
                        style="background:#D32F2F; color:#fff; padding:8px 20px; font-weight:bold; border-radius:8px; box-shadow:0 4px 10px rgba(0,0,0,0.2); transition:all 0.2s ease;">
                    Batal
                </button>

            </div>

        </div>
    </div>
</div>


               <!-- Modal Password Admin -->
<div class="modal fade" id="passwordAdminModal{{ $admin->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg rounded-4" style="background-color:#4B3621; color:#FFF;">

            <!-- Header -->
            <div class="modal-header border-0">
                <h5 class="modal-title">Ubah Password: {{ $admin->nama }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- Form -->
            <form action="{{ route('admin.dataAdmin.updatePassword', $admin) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-body d-flex flex-column gap-3">

                    <!-- Password Lama -->
                    <div class="position-relative w-100">
                        <label class="form-label">Password Lama</label>
                        <input type="password" name="current_password" class="form-control shadow-sm password-input" required
                               style="background-color:#201a15; color:#FFF; border:none; padding-right:2.5rem;">
                        <span class="toggle-password"
                              style="position:absolute; top:50%; right:10px; transform:translateY(-50%); cursor:pointer; font-size:1.2rem;">🙈</span>
                        @error('current_password')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password Baru -->
                    <div class="position-relative w-100">
                        <label class="form-label">Password Baru</label>
                        <input type="password" name="password" class="form-control shadow-sm password-input" required
                               style="background-color:#201a15; color:#FFF; border:none; padding-right:2.5rem;">
                        <span class="toggle-password"
                              style="position:absolute; top:50%; right:10px; transform:translateY(-50%); cursor:pointer; font-size:1.2rem;">🙈</span>
                        @error('password')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="position-relative w-100">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control shadow-sm password-input" required
                               style="background-color:#201a15; color:#FFF; border:none; padding-right:2.5rem;">
                        <span class="toggle-password"
                              style="position:absolute; top:50%; right:10px; transform:translateY(-50%); cursor:pointer; font-size:1.2rem;">🙈</span>
                    </div>

                </div>

                <!-- Footer Tombol Tengah -->
                <div class="modal-footer border-0 justify-content-center gap-3">
                    <button type="button" class="btn btn-secondary px-4 py-2" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning px-4 py-2" style="background-color:#8B5E3C; border:none;">Simpan</button>
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
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg rounded-4" style="background-color:#4B3621; color:#FFF;">

            <!-- Header -->
            <div class="modal-header border-0">
                <h5 class="modal-title">Tambah Admin Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- Form -->
            <form action="{{ route('admin.dataAdmin.store') }}" method="POST">
                @csrf

                <div class="modal-body">

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
                            <label class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control shadow-sm" value="{{ old('nama') }}" required 
                                   style="background-color:#815b3b; color:#FFF; border:none;">
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control shadow-sm" value="{{ old('email') }}" required 
                                   style="background-color:#815b3b; color:#FFF; border:none;">
                        </div>

                        <!-- Jabatan -->
                        <div class="col-md-6">
                            <label class="form-label">Jabatan</label>
                            <input type="text" name="jabatan" class="form-control shadow-sm" value="{{ old('jabatan') }}" required
                                   style="background-color:#815b3b; color:#FFF; border:none;">
                        </div>

                        <!-- No HP -->
                        <div class="col-md-6">
                            <label class="form-label">No HP</label>
                            <input type="text" name="no_hp" class="form-control shadow-sm" value="{{ old('no_hp') }}" 
                                   style="background-color:#815b3b; color:#FFF; border:none;">
                        </div>

                        <!-- Status -->
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select name="role" class="form-select shadow-sm" required 
                                    style="background-color:#815b3b; color:#FFF; border:none;">
                                <option value="">-- Pilih Status --</option>
                                <option value="admin" {{ old('role')=='admin' ? 'selected' : '' }}>Admin</option>
                                <option value="superadmin" {{ old('role')=='superadmin' ? 'selected' : '' }}>Superadmin</option>
                            </select>
                        </div>

                        <!-- Password -->
                        <div class="col-md-6 position-relative">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control shadow-sm password-input" required
                                   style="background-color:#815b3b; color:#FFF; border:none; padding-right:2.5rem;">
                            <span class="toggle-password" 
                                  style="position:absolute; top:50%; right:10px; transform:translateY(-50%); cursor:pointer; font-size:1.2rem;">🙈</span>
                        </div>

                        <!-- Konfirmasi Password -->
                        <div class="col-md-6 position-relative">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control shadow-sm password-input" required
                                   style="background-color:#815b3b; color:#FFF; border:none; padding-right:2.5rem;">
                            <span class="toggle-password" 
                                  style="position:absolute; top:50%; right:10px; transform:translateY(-50%); cursor:pointer; font-size:1.2rem;">🙈</span>
                        </div>

                    </div>
                </div>

                <!-- Footer Tombol Tengah -->
                <div class="modal-footer border-0 justify-content-center gap-3">
                    <button type="button" class="btn btn-secondary px-4 py-2" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning px-4 py-2" style="background-color:#8B5E3C; border:none;">Simpan</button>
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
