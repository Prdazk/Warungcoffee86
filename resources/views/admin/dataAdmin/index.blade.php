@extends('admin.layout.app')

@section('title', 'Data Admin')

@section('content')
<div class="content-section container py-4">

    <h2 class="mb-4">Data Admin</h2>

    <!-- Tombol Tambah Admin -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahAdminModal">
        + Tambah Admin
    </button>

    <!-- Pesan sukses -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

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
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $admin->nama }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>{{ $admin->jabatan }}</td>
                    <td>
                        <!-- Tombol Edit -->
                        <button type="button" class="btn btn-sm btn-warning me-1" data-bs-toggle="modal" data-bs-target="#editAdminModal{{ $admin->id }}" title="Edit Admin">
                            ✏️ Edit
                        </button>

                        <!-- Tombol Hapus -->
                        <button type="button" class="btn btn-sm btn-danger me-1" data-bs-toggle="modal" data-bs-target="#deleteAdminModal{{ $admin->id }}" title="Hapus Admin">
                            🗑️ Hapus
                        </button>

                        <!-- Tombol Kelola Password -->
                        <button type="button" class="btn btn-sm btn-secondary ms-1" data-bs-toggle="modal" data-bs-target="#passwordAdminModal{{ $admin->id }}" title="Kelola Password">
                            🔒 Password
                        </button>
                    </td>
                </tr>

                <!-- Modal Edit Admin -->
                <div class="modal fade" id="editAdminModal{{ $admin->id }}" tabindex="-1" aria-labelledby="editAdminLabel{{ $admin->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content shadow-lg rounded-4" style="background-color:#4B3621; color:#FFF;">
                            <div class="modal-header border-0">
                                <h5 class="modal-title" id="editAdminLabel{{ $admin->id }}">Edit Admin</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                    <button type="button" class="btn" style="background-color:#D9534F; color:#FFF;" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn" style="background-color:rgb(18, 63, 212); color:#FFF;">Update Admin</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- End Modal Edit -->

                <!-- Modal Hapus Admin -->
                <div class="modal fade" id="deleteAdminModal{{ $admin->id }}" tabindex="-1" aria-labelledby="deleteAdminLabel{{ $admin->id }}" aria-hidden="true">
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
                <!-- End Modal Hapus -->

                <!-- Modal Kelola Password Admin -->
                <div class="modal fade" id="passwordAdminModal{{ $admin->id }}" tabindex="-1" aria-labelledby="passwordAdminLabel{{ $admin->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content shadow-lg rounded-4" style="background-color:#4B3621; color:#FFF;">
                            <div class="modal-header border-0">
                                <h5 class="modal-title" id="passwordAdminLabel{{ $admin->id }}">Ubah Data Password: {{ $admin->nama }}</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('admin.dataAdmin.updatePassword', $admin) }}" method="POST">
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
                                    <div class="mb-3">
                                        <label>Password Baru</label>
                                        <input type="password" name="password" class="form-control shadow-sm" required style="background-color:#815b3b; color:#FFF; border:none;">
                                    </div>
                                    <div class="mb-3">
                                        <label>Konfirmasi Password</label>
                                        <input type="password" name="password_confirmation" class="form-control shadow-sm" required style="background-color:#815b3b; color:#FFF; border:none;">
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
                <!-- End Modal Password -->

                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah Admin -->
<div class="modal fade" id="tambahAdminModal" tabindex="-1" aria-labelledby="tambahAdminLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg rounded-4" style="background-color:#4B3621; color:#FFF;">
            <div class="modal-header border-0">
                <h5 class="modal-title">Tambah Admin Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.dataAdmin.store') }}" method="POST">
                @csrf
                <div class="modal-body">
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

<style>
    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 8px rgba(255,255,255,0.3);
    }
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.3/dist/cosmo/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
