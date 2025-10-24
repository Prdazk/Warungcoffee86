@extends('admin.layout.app')

@section('title', 'Data Admin')

@section('content')
<div class="content-section container py-2">

    <!-- Tombol Tambah Admin -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahAdminModal">
        + Tambah Admin
    </button>

    <!-- Tabel Data Admin -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Jabatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($admins as $index => $admin)
                <tr class="text-center">
                    <td>{{ $admins->firstItem() + $index }}</td>
                    <td>{{ $admin->nama }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>{{ $admin->jabatan }}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-warning me-1" data-bs-toggle="modal" data-bs-target="#editAdminModal{{ $admin->id }}">✏️ Edit</button>
                        <button type="button" class="btn btn-sm btn-danger me-1" data-bs-toggle="modal" data-bs-target="#deleteAdminModal{{ $admin->id }}">🗑️ Hapus</button>
                        <button type="button" class="btn btn-sm btn-secondary ms-1" data-bs-toggle="modal" data-bs-target="#passwordAdminModal{{ $admin->id }}">🔒 Password</button>
                    </td>
                </tr>

                <!-- Modal Edit Admin -->
                <div class="modal fade" id="editAdminModal{{ $admin->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content shadow-lg rounded-4" style="background-color:#4B3621; color:#FFF;">
                            <div class="modal-header border-0">
                                <h5 class="modal-title">Edit Admin</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('admin.dataAdmin.update', $admin->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
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
                                            <label class="form-label">Nama</label>
                                            <input type="text" name="nama" class="form-control shadow-sm" value="{{ old('nama', $admin->nama) }}" required style="background-color:#815b3b; color:#FFF; border:none;">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control shadow-sm" value="{{ old('email', $admin->email) }}" required style="background-color:#815b3b; color:#FFF; border:none;">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Jabatan</label>
                                            <input type="text" name="jabatan" class="form-control shadow-sm" value="{{ old('jabatan', $admin->jabatan) }}" required style="background-color:#815b3b; color:#FFF; border:none;">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Role</label>
                                            <select name="role" class="form-select shadow-sm" required style="background-color:#815b3b; color:#FFF; border:none;">
                                                <option value="">-- Pilih Role --</option>
                                                <option value="admin" {{ old('role', $admin->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                                <option value="superadmin" {{ old('role', $admin->role) == 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Update Admin</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal Hapus Admin -->
                <div class="modal fade" id="deleteAdminModal{{ $admin->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content shadow-lg rounded-4">
                            <div class="modal-header" style="background-color:#c47429; color:#fff;">
                                <h5 class="modal-title">Konfirmasi Hapus</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body text-center">
                                Apakah Anda yakin ingin menghapus admin <strong>{{ $admin->nama }}</strong>?
                            </div>
                            <div class="modal-footer">
                                <form action="{{ route('admin.dataAdmin.destroy', $admin) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Iya, Hapus</button>
                                </form>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                            </div>
                        </div>
                    </div>
                </div>

                                        <!-- Modal Password Admin -->
                <div class="modal fade" id="passwordAdminModal{{ $admin->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content shadow-lg rounded-4" style="background-color:#4B3621; color:#FFF;">

                            <div class="modal-header border-0">
                                <h5 class="modal-title">Ubah Password: {{ $admin->nama }}</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>

                            <form action="{{ route('admin.dataAdmin.updatePassword', $admin) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="modal-body" style="display:flex; flex-direction:column; gap:1rem;">

                                    <!-- Password Lama -->
                                    <div style="position: relative; width: 100%;">
                                        <label>Password Lama</label>
                                        <input type="password" name="current_password" class="form-control shadow-sm" required
                                            style="background-color:#201a15; color:#FFF; border:none; padding-right:2.5rem; width:100%;">
                                        <span class="toggle-password"
                                            style="position:absolute; top:50%; right:10px; transform:translateY(-50%); cursor:pointer; font-size:1.2rem;">🐵</span>
                                        @if($errors->has('current_password'))
                                            <div class="text-danger mt-1">{{ $errors->first('current_password') }}</div>
                                        @endif
                                    </div>

                                    <!-- Password Baru -->
                                    <div style="position: relative; width: 100%;">
                                        <label>Password Baru</label>
                                        <input type="password" name="password" class="form-control shadow-sm" required
                                            style="background-color:#201a15; color:#FFF; border:none; padding-right:2.5rem; width:100%;">
                                        <span class="toggle-password"
                                            style="position:absolute; top:50%; right:10px; transform:translateY(-50%); cursor:pointer; font-size:1.2rem;">🐵</span>
                                    </div>

                                    <!-- Konfirmasi Password -->
                                    <div style="position: relative; width: 100%;">
                                        <label>Konfirmasi Password</label>
                                        <input type="password" name="password_confirmation" class="form-control shadow-sm" required
                                            style="background-color:#201a15; color:#FFF; border:none; padding-right:2.5rem; width:100%;">
                                        <span class="toggle-password"
                                            style="position:absolute; top:50%; right:10px; transform:translateY(-50%); cursor:pointer; font-size:1.2rem;">🐵</span>
                                    </div>

                                </div>

                                <div class="modal-footer border-0">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan Password</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <!-- Tombol Pagination Custom -->
    <div style="margin-top:10px; display:flex; justify-content:center; gap:10px;">
        <button id="prevBtn" style="padding:6px 12px; border-radius:6px; border:none; background:#795548; color:white; cursor:pointer;" {{ $admins->onFirstPage() ? 'disabled' : '' }}>kembali</button>
        <button id="nextBtn" style="padding:6px 12px; border-radius:6px; border:none; background:#795548; color:white; cursor:pointer;" {{ $admins->hasMorePages() ? '' : 'disabled' }}>lanjut</button>
    </div>
</div>

<!-- Modal Tambah Admin -->
<div class="modal fade" id="tambahAdminModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg rounded-4" style="background-color:#4B3621; color:#FFF;">
            <div class="modal-header border-0">
                <h5 class="modal-title">Tambah Admin Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.dataAdmin.store') }}" method="POST">
                @csrf
                <div class="modal-body">
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
                            <label class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control shadow-sm" value="{{ old('nama') }}" required style="background-color:#815b3b; color:#FFF; border:none;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control shadow-sm" value="{{ old('email') }}" required style="background-color:#815b3b; color:#FFF; border:none;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jabatan</label>
                            <input type="text" name="jabatan" class="form-control shadow-sm" value="{{ old('jabatan') }}" required style="background-color:#815b3b; color:#FFF; border:none;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-select shadow-sm" required style="background-color:#815b3b; color:#FFF; border:none;">
                                <option value="">-- Pilih Role --</option>
                                <option value="admin" {{ old('role')=='admin' ? 'selected' : '' }}>Admin</option>
                                <option value="superadmin" {{ old('role')=='superadmin' ? 'selected' : '' }}>Superadmin</option>
                            </select>
                        </div>

                         <!-- Password -->
                        <div class="col-md-6" style="position: relative;">
                            <label class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control shadow-sm" required 
                                style="background-color:#815b3b; color:#FFF; border:none; padding-right: 2.5rem;">
                            <span class="toggle-password" style="position:absolute; top:40%; right:10px; cursor:pointer; font-size: 1.2rem;">🐵</span>
                        </div>

                        <!-- Konfirmasi Password -->
                        <div class="col-md-6" style="position: relative;">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control shadow-sm" required 
                                style="background-color:#815b3b; color:#FFF; border:none; padding-right: 2.5rem;">
                            <span class="toggle-password" style="position:absolute; top:40%; right:10px; cursor:pointer; font-size: 1.2rem;">🐵</span>
                        </div>

                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Admin</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Sukses -->
@if(session('success'))
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg rounded-4 text-center" style="background: #28a745; color:#fff; transform: scale(0.8); opacity:0; transition: all 0.3s ease;">
      <div class="modal-body py-4">
        <h3><i class="bi bi-check-circle-fill"></i> Sukses!</h3>
        <p>{{ session('success') }}</p>
      </div>
    </div>
  </div>
</div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function () {

    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');

    prevBtn?.addEventListener('click', () => {
        const prevUrl = "{{ $admins->previousPageUrl() }}";
        if(prevUrl) window.location.href = prevUrl;
    });

    nextBtn?.addEventListener('click', () => {
        const nextUrl = "{{ $admins->nextPageUrl() }}";
        if(nextUrl) window.location.href = nextUrl;
    });

    const modalEl = document.getElementById('successModal');
    if(modalEl){
        const modalContent = modalEl.querySelector('.modal-content');
        const bsModal = new bootstrap.Modal(modalEl);

        // Set posisi awal animasi
        modalContent.style.transform = 'scale(0.8)';
        modalContent.style.opacity = '0';

        // Tampilkan modal
        bsModal.show();
        requestAnimationFrame(() => {
            modalContent.style.transform = 'scale(1)';
            modalContent.style.opacity = '1';
        });

        // Hilang otomatis setelah 3 detik
        setTimeout(() => {
            modalContent.style.transform = 'scale(0.8)';
            modalContent.style.opacity = '0';
            setTimeout(() => bsModal.hide(), 300);
        }, 3000);
    }

    function togglePassword(input) {
        if (!input) return;
        // Tampilkan password selama 1 detik
        input.type = "text";
        setTimeout(() => {
            input.type = "password"; // Kembalikan ke password otomatis
        }, 1000);
    }

    const toggleSpans = document.querySelectorAll('.toggle-password');
    toggleSpans.forEach(span => {
        span.addEventListener('click', function() {
            const input = this.parentElement.querySelector('input');
            if(input) togglePassword(input);
        });
    });

    @if($errors->has('current_password') || $errors->has('password') || $errors->has('password_confirmation'))
        var passwordModal = new bootstrap.Modal(document.getElementById('passwordAdminModal{{ $admin->id }}'));
        passwordModal.show();
    @endif

});
</script>
@endsection
