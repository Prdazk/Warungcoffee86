@extends('admin.layout.app')

@section('title', 'Tambah Admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Tambah Admin Baru</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.dataAdmin.store') }}" method="POST">
        @csrf
        <div class="form-row">
            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Jabatan</label>
                <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan') }}" required>
            </div>
            <div class="form-group">
                <label>Role</label>
                <select name="role" class="form-select" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="admin" {{ old('role')=='admin' ? 'selected' : '' }}>Admin</option>
                    <option value="superadmin" {{ old('role')=='superadmin' ? 'selected' : '' }}>Superadmin</option>
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-success mt-3">Simpan Admin</button>
        <a href="{{ route('admin.dataAdmin.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </form>
</div>
@endsection
