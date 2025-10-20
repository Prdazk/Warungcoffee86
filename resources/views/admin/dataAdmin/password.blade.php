@extends('admin.layout.app')

@section('title', 'Ubah Password Admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Ubah Password: {{ $admin->nama }}</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.dataAdmin.updatePassword', $admin) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Password Baru</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Simpan Password</button>
        <a href="{{ route('admin.dataAdmin.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </form>
</div>
@endsection
