@extends('admin.layout.app')
@section('title','Kelola Menu')
@section('content')

@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif

<!-- Tombol Tambah Menu -->
<div class="d-flex justify-content-end mb-3">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
        + Tambah Menu
    </button>
</div>

<!-- Tabel Menu -->
<div class="table-responsive">
    <table class="table table-striped table-bordered align-middle text-center">
        <thead class="table-dark">
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
          <!-- Tombol Edit -->
              <button type="button" class="btn btn-warning btn-sm"
                  onclick="showEditModal({{ $menu->id }},'{{ addslashes($menu->nama) }}','{{ $menu->harga }}','{{ addslashes($menu->kategori) }}','{{ addslashes($menu->status) }}')"
                  style="font-size:0.85rem; padding:0.35rem 0.6rem; border-radius:0.4rem; box-shadow: 0 1px 3px rgba(0,0,0,0.3);">
                  ✏️ Edit
              </button>

              <!-- Tombol Hapus -->
              <button type="button" class="btn btn-danger btn-sm"
                  onclick="confirmDelete('{{ route('admin.menu.destroy', $menu->id) }}')"
                  style="font-size:0.85rem; padding:0.35rem 0.6rem; border-radius:0.4rem; box-shadow: 0 1px 3px rgba(0,0,0,0.3);">
                  🗑️ Hapus
              </button>


                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-muted">Belum ada data menu.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="d-flex justify-content-center mt-3 gap-2">
    <a href="{{ $menus->previousPageUrl() ?? '#' }}" 
       class="btn" 
       style="background-color:#8B5E3C; color:#FFF; border:none; border-radius:5px; box-shadow:0 2px 5px rgba(0,0,0,0.2);">
       Kembali
    </a>
    <a href="{{ $menus->nextPageUrl() ?? '#' }}" 
       class="btn" 
       style="background-color:#8B5E3C; color:#FFF; border:none; border-radius:5px; box-shadow:0 2px 5px rgba(0,0,0,0.2);">
       Lanjut
    </a>
</div>

<!-- Modal Tambah Menu -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow-lg rounded-4" style="background:#4B3621; color:#FFF;">
      <div class="modal-header border-0">
        <h5 class="modal-title">Tambah Menu Baru</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Menu</label>
                    <input type="text" name="nama" class="form-control" required style="background:#815b3b; color:#FFF; border:none;">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Harga</label>
                    <input type="number" name="harga" class="form-control" required style="background:#815b3b; color:#FFF; border:none;">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kategori</label>
                    <select name="kategori" class="form-select" required style="background:#815b3b; color:#FFF; border:none;">
                        <option value="">-- Pilih --</option>
                        <option value="Makanan">Makanan</option>
                        <option value="Minuman">Minuman</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required style="background:#815b3b; color:#FFF; border:none;">
                        <option value="Tersedia">Tersedia</option>
                        <option value="Habis">Habis</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Gambar</label>
                    <input type="file" name="gambar" class="form-control" style="background:#815b3b; color:#FFF; border:none;">
                </div>
            </div>
        </div>
        <div class="modal-footer border-0">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Edit Menu -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow-lg rounded-4" style="background:#4B3621; color:#FFF;">
      <div class="modal-header border-0">
        <h5 class="modal-title">Edit Menu</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form id="formEditMenu" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Menu</label>
                    <input type="text" name="nama" id="editNama" class="form-control" required style="background:#815b3b; color:#FFF; border:none;">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Harga</label>
                    <input type="number" name="harga" id="editHarga" class="form-control" required style="background:#815b3b; color:#FFF; border:none;">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kategori</label>
                    <select name="kategori" id="editKategori" class="form-select" required style="background:#815b3b; color:#FFF; border:none;">
                        <option value="Makanan">Makanan</option>
                        <option value="Minuman">Minuman</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" id="editStatus" class="form-select" required style="background:#815b3b; color:#FFF; border:none;">
                        <option value="Tersedia">Tersedia</option>
                        <option value="Habis">Habis</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Gambar</label>
                    <input type="file" name="gambar" class="form-control" style="background:#815b3b; color:#FFF; border:none;">
                </div>
            </div>
        </div>
        <div class="modal-footer border-0">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modalLihat" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg rounded-4" style="background:#4B3621; color:#FFF;">
      <div class="modal-header border-0">
        <h5 class="modal-title" id="modalNama">Menu</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body d-flex gap-3">
        <img id="modalGambar" src="{{ asset('images/placeholder.png') }}" class="rounded" style="max-width:200px;">
        <div>
          <p><strong>Harga:</strong> Rp <span id="modalHarga">0</span></p>
          <p><strong>Kategori:</strong> <span id="modalKategori">-</span></p>
          <p><strong>Status:</strong> <span id="modalStatus">-</span></p>
        </div>
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal Hapus Menu -->
<div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" style="margin-top:80px; max-width:400px;">
    <div class="modal-content shadow-lg rounded-4 p-4 text-center" style="background:#4B3621; color:#FFF;">
      <h5 class="mb-3">apakah anda Yakin ingin menghapus menu ini?</h5>
      <div class="d-flex justify-content-center gap-3">
        <button type="button" class="btn" id="btnCancelDelete" 
                style="background:#D32F2F; color:#fff; padding:8px 18px; border-radius:8px; font-weight:bold;">
          Batal
        </button>
        <button type="button" class="btn" id="btnConfirmDelete" 
                style="background:#388E3C; color:#fff; padding:8px 18px; border-radius:8px; font-weight:bold;">
          Hapus
        </button>
      </div>
    </div>
  </div>
</div>

<form id="deleteForm" method="POST" style="display:none;">
  @csrf
  @method('DELETE')
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // ===== Alert Sukses / Hapus 3 detik (Tengah Atas) =====
    const alerts = document.querySelectorAll('.alert-success, .alert-danger');
    alerts.forEach(alertEl => {
        // Set posisi tengah atas
        alertEl.style.position = 'fixed';
        alertEl.style.top = '20px';
        alertEl.style.left = '50%';
        alertEl.style.transform = 'translateX(-50%)';
        alertEl.style.zIndex = '1050';
        alertEl.style.transition = 'all 0.5s ease';
        alertEl.style.opacity = '1';

        setTimeout(() => {
            alertEl.style.opacity = '0';
            alertEl.style.transform = 'translateX(-50%) translateY(-20px)';
            setTimeout(() => alertEl.remove(), 500);
        }, 3000); // 3 detik
    });

    // =========================
    // Modal Lihat Menu
    // =========================
    const modalLihatEl = document.getElementById('modalLihat');

    function showMenuModal(button) {
        document.getElementById('modalNama').textContent = button.dataset.nama;
        document.getElementById('modalHarga').textContent = Number(button.dataset.harga).toLocaleString('id-ID');
        document.getElementById('modalKategori').textContent = button.dataset.kategori;
        document.getElementById('modalStatus').textContent = button.dataset.status;
        document.getElementById('modalGambar').src = button.dataset.gambar;

        const modal = new bootstrap.Modal(modalLihatEl);
        modal.show();
    }

    document.querySelectorAll('.view-menu').forEach(btn => {
        btn.addEventListener('click', function() {
            showMenuModal(this);
        });
    });

    // =========================
    // Modal Hapus Manual
    // =========================
    let deleteUrl = null;
    const modalHapus = new bootstrap.Modal(document.getElementById('modalHapus'));
    const btnConfirmDelete = document.getElementById('btnConfirmDelete');
    const btnCancelDelete = document.getElementById('btnCancelDelete');
    const deleteForm = document.getElementById('deleteForm');

    btnConfirmDelete.addEventListener('click', function() {
        if (!deleteUrl) return;
        deleteForm.action = deleteUrl;
        modalHapus.hide();
        setTimeout(() => deleteForm.submit(), 200);
    });

    btnCancelDelete.addEventListener('click', () => modalHapus.hide());

    window.confirmDelete = function(url) {
        deleteUrl = url;
        modalHapus.show();
    }

    // =========================
    // Modal Edit
    // =========================
    window.showEditModal = function(id, nama, harga, kategori, status) {
        document.getElementById('formEditMenu').action = `/admin/menu/${id}`;
        document.getElementById('editNama').value = nama;
        document.getElementById('editHarga').value = harga;
        document.getElementById('editKategori').value = kategori;
        document.getElementById('editStatus').value = status;
        new bootstrap.Modal(document.getElementById('modalEdit')).show();
    }
});
</script>

@endsection
