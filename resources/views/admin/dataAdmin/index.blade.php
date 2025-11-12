@extends('admin.layout.app')

@section('title', 'Data Admin')

@section('content')
<div class="container py-2">

    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahAdminModal">
        + Tambah Admin
    </button>

    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Jabatan</th>
                    <th>No HP</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($admins as $index => $admin)
                <tr>
                    <td>{{ $admins->firstItem() + $index }}</td>
                    <td>{{ $admin->nama }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>
                        @if(strtolower($admin->role) == 'superadmin')
                            <span class="badge bg-danger">Superadmin</span>
                        @elseif(strtolower($admin->role) == 'admin')
                            <span class="badge bg-primary">Admin</span>
                        @else
                            <span class="badge bg-secondary">{{ ucfirst($admin->role) }}</span>
                        @endif
                    </td>
                    <td>{{ $admin->no_hp ?? '-' }}</td>
                    <td>
                        @if($admin->status == 1)
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <button class="btn btn-warning btn-sm me-1" data-bs-toggle="modal" data-bs-target="#editAdminModal{{ $admin->id }}">✏️</button>
                        <button class="btn btn-danger btn-sm me-1" data-bs-toggle="modal" data-bs-target="#deleteAdminModal{{ $admin->id }}">🗑️</button>
                        <button class="btn btn-secondary btn-sm ms-1" data-bs-toggle="modal" data-bs-target="#passwordAdminModal{{ $admin->id }}">🔒</button>
                    </td>
                </tr>
                
                @include('admin.dataAdmin.edit', ['admin' => $admin])
                @include('admin.dataAdmin.password', ['admin' => $admin])
                @include('admin.dataAdmin.delete', ['admin' => $admin])

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

@include('admin.dataAdmin.tambah')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
window.Laravel = {
    session: {
        success: "{{ session('success') ?? '' }}",
        error: "{{ session('error') ?? '' }}"
    }
};
</script>
<script src="{{ asset('js/admin/dataAdmin.js') }}"></script>

@endsection