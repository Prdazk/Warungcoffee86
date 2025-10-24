@extends('admin.layout.app')
@section('title','Kelola Menu')
@section('content')

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

<!-- Tombol Tambah Menu -->
<div class="d-flex justify-content-end mb-3">
    <button class="btn btn-tambah" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="fas fa-plus"></i> Tambah Menu
    </button>
</div>

<!-- Tabel Menu -->
<div class="card shadow-sm rounded-4 p-3">
    <table class="table table-hover align-middle text-center">
        <thead class="table-header">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($menus as $menu)
            <tr>
                <td>{{ $loop->iteration + ($menus->currentPage()-1) * $menus->perPage() }}</td>
                <td>{{ $menu->nama }}</td>
                <td>Rp {{ number_format($menu->harga,0,',','.') }}</td>
                <td>{{ $menu->kategori }}</td>
                <td>
                    <span class="badge {{ $menu->status == 'Tersedia' ? 'bg-success' : 'bg-danger' }}">
                        {{ $menu->status }}
                    </span>
                </td>
                <td>
                    @if($menu->gambar && file_exists(public_path('images/'.$menu->gambar)))
                        <img src="{{ asset('images/'.$menu->gambar) }}" width="60" class="rounded shadow-sm" alt="{{ $menu->nama }}">
                    @else
                        <span class="text-muted">Tidak ada</span>
                    @endif
                </td>
                <td class="d-flex justify-content-center gap-2">
                    <!-- Tombol Edit Modal -->
                    <button type="button" class="btn btn-edit"
                        onclick="showEditModal(
                            {{ $menu->id }},
                            '{{ addslashes($menu->nama) }}',
                            '{{ $menu->harga }}',
                            '{{ addslashes($menu->kategori) }}',
                            '{{ addslashes($menu->status) }}'
                        )">
                        <i class="fas fa-edit"></i>
                    </button>

                  <!-- Tombol Hapus -->
                    <button type="button" class="btn btn-hapus" 
                        onclick="confirmDelete('{{ route('admin.menu.destroy', $menu->id) }}')">
                        <i class="fas fa-trash"></i>
                    </button>


                    <!-- Tombol Lihat Menu -->
                    <button type="button" class="btn btn-lihat"
                        onclick="showMenu(
                            '{{ addslashes($menu->nama) }}',
                            '{{ $menu->harga }}',
                            '{{ addslashes($menu->kategori) }}',
                            '{{ addslashes($menu->status) }}',
                            '{{ $menu->gambar && file_exists(public_path("images/".$menu->gambar)) ? asset("images/".$menu->gambar) : asset("images/placeholder.png") }}'
                        )">
                        <i class="fas fa-eye"></i>
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-muted text-center">Belum ada data menu.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="d-flex justify-content-center mt-3">
    <ul class="pagination">
        <li class="page-item">
            <a href="{{ $menus->previousPageUrl() ?? '#' }}" class="btn btn-tambah btn-sm">Kembali</a>
        </li>
        <li class="page-item">
            <a href="{{ $menus->nextPageUrl() ?? '#' }}" class="btn btn-tambah btn-sm">Lanjut</a>
        </li>
    </ul>
</div>

<style>
.page-item { margin: 0 5px; }
.page-item .btn { border-radius: 6px; padding: 8px 16px; border: 1px solid #795548; background-color: #795548; color: #fff; font-weight: 500; text-decoration: none; transition: background-color 0.2s, transform 0.1s; }
.page-item .btn:hover { background-color: #a47148; transform: scale(1.05); }
.page-item .btn:active { transform: scale(0.95); }

.btn { border: none; padding: 8px 12px; border-radius: 6px; color: white; cursor: pointer; display: flex; align-items: center; gap: 4px; text-decoration: none; }
.btn-tambah { background:#795548; }
.btn-edit { background:#4CAF50; }
.btn-hapus { background:#E53935; }
.btn-lihat { background:#2196F3; }
.btn-success { background:#4CAF50; }
.btn:hover { opacity:0.9; transform: scale(1.02); transition: all 0.2s; }
</style>

<!-- Modal Tambah Menu -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content rounded-4 shadow-lg" style="background:#a47148; color:white;">
      <div class="modal-header border-0" style="background:#7b4e2e;">
        <h5 class="modal-title" id="modalTambahLabel">Tambah Menu Baru</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-bold text-light">Nama Menu</label>
              <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold text-light">Harga</label>
              <input type="number" name="harga" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold text-light">Kategori</label>
              <select name="kategori" class="form-select" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="Makanan">Makanan</option>
                <option value="Minuman">Minuman</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold text-light">Status</label>
              <select name="status" class="form-select" required>
                <option value="Tersedia">Tersedia</option>
                <option value="Habis">Habis</option>
              </select>
            </div>
            <div class="col-12">
              <label class="form-label fw-bold text-light">Gambar</label>
              <input type="file" name="gambar" class="form-control">
            </div>
          </div>
          <div class="d-flex justify-content-between mt-3">
            <button type="button" class="btn btn-tambah text-white" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-success">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Edit Menu -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content rounded-4 shadow-lg" style="background:#8d6e63; color:white;">
      <div class="modal-header border-0" style="background:#6d4c41;">
        <h5 class="modal-title" id="modalEditLabel">Edit Menu</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="formEditMenu" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-bold text-light">Nama Menu</label>
              <input type="text" name="nama" id="editNama" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold text-light">Harga</label>
              <input type="number" name="harga" id="editHarga" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold text-light">Kategori</label>
              <select name="kategori" id="editKategori" class="form-select" required>
                <option value="Makanan">Makanan</option>
                <option value="Minuman">Minuman</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold text-light">Status</label>
              <select name="status" id="editStatus" class="form-select" required>
                <option value="Tersedia">Tersedia</option>
                <option value="Habis">Habis</option>
              </select>
            </div>
            <div class="col-12">
              <label class="form-label fw-bold text-light">Gambar</label>
              <input type="file" name="gambar" class="form-control">
            </div>
          </div>
          <div class="d-flex justify-content-between mt-3">
            <button type="button" class="btn btn-tambah text-white" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-success">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Lihat Menu -->
<div class="modal fade" id="modalLihat" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-3 rounded-4">
      <div class="modal-header">
        <h5 class="modal-title" id="modalNama"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body d-flex gap-3">
        <img id="modalGambar" src="{{ asset('images/placeholder.png') }}" class="rounded" style="max-width:200px;">
        <div>
          <p><strong>Harga:</strong> Rp <span id="modalHarga">0</span></p>
          <p><strong>Kategori:</strong> <span id="modalKategori">-</span></p>
          <p><strong>Status:</strong> <span id="modalStatus">-</span></p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center p-4 rounded-4 shadow-lg" style="border:none;">
      <h5 class="mb-3 text-dark fw-bold">Yakin ingin menghapus menu ini?</h5>
      <p class="text-secondary mb-4">Tindakan ini tidak dapat dibatalkan.</p>
      <div class="d-flex justify-content-center gap-3">
        <button type="button" class="btn btn-secondary px-4" id="btnCancelDelete">Batal</button>
        <button type="button" id="btnConfirmDelete" class="btn btn-danger px-4">Ya, Hapus</button>
      </div>
    </div>
  </div>
</div>

<form id="deleteForm" method="POST" style="display:none;">
  @csrf
  @method('DELETE')
</form>

<script>
let deleteUrl = null;
let modalHapus = null;

document.addEventListener('DOMContentLoaded', function () {
  const modalEl = document.getElementById('modalHapus');
  modalHapus = new bootstrap.Modal(modalEl, { backdrop: 'static', keyboard: false });

  document.getElementById('btnConfirmDelete').addEventListener('click', function () {
    if (!deleteUrl) return;
    const form = document.getElementById('deleteForm');
    form.action = deleteUrl;
    modalHapus.hide(); // tutup modal dulu
    setTimeout(() => form.submit(), 200); // beri jeda biar animasi selesai
  });

  document.getElementById('btnCancelDelete').addEventListener('click', function () {
    modalHapus.hide();
  });
});

function confirmDelete(url) {
  deleteUrl = url;
  if (!modalHapus) {
    modalHapus = new bootstrap.Modal(document.getElementById('modalHapus'), { backdrop: 'static', keyboard: false });
  }
  modalHapus.show();
}
</script>

<style>
#modalHapus .modal-content {
  animation: fadeInScale 0.25s ease-in-out;
  background: #fefcfb;
}
@keyframes fadeInScale {
  from { opacity:0; transform:scale(0.9); }
  to { opacity:1; transform:scale(1); }
}
#modalHapus .btn-danger {
  background-color: #d84315;
  border: none;
}
#modalHapus .btn-danger:hover {
  background-color: #bf360c;
  transform: scale(1.05);
}
#modalHapus .btn-secondary {
  background-color: #8d6e63;
  border: none;
}
</style>

@push('scripts')
<script>
function showMenu(nama, harga, kategori, status, gambar) {
    document.getElementById('modalNama').textContent = nama || '-';
    document.getElementById('modalHarga').textContent = harga ? Number(harga).toLocaleString('id-ID') : '-';
    document.getElementById('modalKategori').textContent = kategori || '-';
    document.getElementById('modalStatus').textContent = status || '-';
    document.getElementById('modalGambar').src = gambar || '{{ asset("images/placeholder.png") }}';
    const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalLihat'));
    modal.show();
}

function showEditModal(id, nama, harga, kategori, status) {
    document.getElementById('formEditMenu').action = `/admin/menu/${id}`;
    document.getElementById('editNama').value = nama;
    document.getElementById('editHarga').value = harga;
    document.getElementById('editKategori').value = kategori;
    document.getElementById('editStatus').value = status;
    const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalEdit'));
    modal.show();
}
</script>
@endpush

@endsection