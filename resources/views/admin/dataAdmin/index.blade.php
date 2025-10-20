@extends('admin.layout.app')

@section('title', 'Data Admin')

@section('content')
<div class="content-section">
    <h2>Data Admin</h2>

    <!-- Tombol Tambah Admin -->
    <a href="{{ route('admin.dataAdmin.create') }}" class="btn btn-primary">Tambah Admin</a>

    <!-- Pesan sukses -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Tabel Data Admin -->
    <table class="admin-table" border="1" cellpadding="10" cellspacing="0" style="width:100%; margin-top:15px;">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Jabatan</th>
                <th>Aksi</th>
                <th>Kelola Password</th> <!-- Tambahan kolom -->
            </tr>
        </thead>
        <tbody>
            @foreach($admins as $index => $admin)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $admin->nama }}</td>
                <td>{{ $admin->email }}</td>
                <td>{{ $admin->jabatan }}</td>
                <td>
                    <!-- Tombol Edit -->
                    <a href="{{ route('admin.dataAdmin.edit', $admin) }}" class="btn btn-edit" title="Edit Admin">
                        ✏️ Edit
                    </a>

                    <!-- Tombol Hapus -->
                    <form action="{{ route('admin.dataAdmin.destroy', $admin) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete" onclick="return confirm('Yakin ingin hapus?')" title="Hapus Admin">
                            🗑️ Hapus
                        </button>
                    </form>
                </td>
                <td>
                    <!-- Tombol Kelola Password -->
                  <a href="{{ route('admin.dataAdmin.password', $admin) }}" class="btn btn-password">🔒Password</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
