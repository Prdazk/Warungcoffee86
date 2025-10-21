@extends('admin.layout.app')

@section('title', 'Edit Admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Admin</h1>

    <!-- Pesan error validasi -->
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.dataAdmin.update', $admin->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Baris 1: Nama & Email -->
        <div class="form-row">
            <div class="form-group">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" value="{{ old('nama', $admin->name) }}" placeholder="Prada" required>
            </div>
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $admin->email) }}" placeholder="dnasj@gmail.com" required>
            </div>
        </div>

        <!-- Baris 2: Jabatan & Role -->
        <div class="form-row">
            <div class="form-group">
                <label for="jabatan" class="form-label">Jabatan</label>
                <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan', $admin->jabatan) }}" placeholder="Admin" required>
            </div>
            <div class="form-group">
                <label for="role" class="form-label">Role</label>
                <select name="role" class="form-select" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="admin" {{ old('role', $admin->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="superadmin" {{ old('role', $admin->role) == 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                </select>
            </div>
        </div>

        <!-- Tombol -->
        <div class="form-buttons">
            <button type="submit" class="btn btn-success">Update Admin</button>
            <a href="{{ route('admin.dataAdmin.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>
@endsection
