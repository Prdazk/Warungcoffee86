@extends('admin.layout.app')

@section('title', 'Kelola Admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Admin</h1>

    <!-- Pesan sukses -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Tombol tambah admin baru -->
    <a href="{{ route('admin.dataAdmin.create') }}" class="btn btn-primary mb-3">Tambah Admin Baru</a>

    <!-- Tabel daftar admin -->
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($admins as $index => $admin)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $admin->name }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>{{ ucfirst($admin->role) }}</td>
                    <td>
                        <a href="{{ route('admin.dataAdmin.edit', $admin->id) }}" class="btn btn-sm btn-warning">Edit</a>

                        <form action="{{ route('admin.dataAdmin.destroy', $admin->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus admin ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            @if($admins->isEmpty())
                <tr>
                    <td colspan="5" class="text-center">Belum ada admin terdaftar.</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection
