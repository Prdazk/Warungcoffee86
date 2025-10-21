@extends('admin.layout.app')
@section('title','Kelola Menu')
@section('content')

<!-- Tombol Tambah Menu -->
<a href="{{ route('admin.menu.create') }}" class="btn-box btn-tambah mb-3">
    <i class="fas fa-plus"></i> Tambah menu
</a>

<table id="menuTable" class="table table-bordered" style="width:100%; border-collapse:collapse;">
    <thead>
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
        @forelse($menus as $index => $menu)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $menu->nama }}</td>
            <td>Rp {{ number_format($menu->harga,0,',','.') }}</td>
            <td>{{ $menu->kategori }}</td>
            <td>{{ $menu->status }}</td>
            <td>
                @if($menu->gambar)
                    <img src="{{ asset('images/'.$menu->gambar) }}" width="60" alt="{{ $menu->nama }}">
                @else
                    <span>Tidak ada</span>
                @endif
            </td>
            <td style="display:flex; gap:6px;">
                <a href="{{ route('admin.menu.edit',$menu->id) }}" class="btn-box btn-edit">
                    <i class="fas fa-edit"></i> Edit
                </a>

                <form action="{{ route('admin.menu.destroy', $menu->id) }}" method="POST" style="margin:0;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-box btn-hapus" onclick="return confirm('Yakin hapus menu ini?')">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </form>

                <button type="button" class="btn-box btn-lihat" 
                    onclick="showMenu(
                        @json($menu->nama),
                        @json($menu->harga),
                        @json($menu->kategori),
                        @json($menu->status),
                        @json($menu->gambar ? asset('images/'.$menu->gambar) : '')
                    )">
                    <i class="fas fa-eye"></i> Lihat
                </button>
            </td>
        </tr>
        @empty
        <tr><td colspan="7" style="text-align:center;">Belum ada data menu.</td></tr>
        @endforelse
    </tbody>
</table>

<!-- Tombol Next & Kembali -->
<div style="margin-top:10px; display:flex; justify-content:center; gap:10px;">
    <button id="prevBtn" style="padding:6px 12px; border-radius:6px; border:none; background:#795548; color:white; cursor:pointer;">Kembali</button>
    <button id="nextBtn" style="padding:6px 12px; border-radius:6px; border:none; background:#795548; color:white; cursor:pointer;">Next</button>
</div>

<!-- Modal Lihat Menu -->
<div id="modalLihat" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div class="modal-body d-flex">
            <div class="modal-left me-3">
                <img id="modalGambar" src="" alt="Gambar Menu" style="max-width:200px;">
            </div>
            <div class="modal-right">
                <h2 id="modalNama"></h2>
                <p><strong>Harga:</strong> Rp <span id="modalHarga"></span></p>
                <p><strong>Kategori:</strong> <span id="modalKategori"></span></p>
                <p><strong>Status:</strong> <span id="modalStatus"></span></p>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const rows = document.querySelectorAll('#menuTable tbody tr');
    const rowsPerPage = 5;
    let currentPage = 1;
    const totalPages = Math.ceil(rows.length / rowsPerPage);

    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');

    function showPage(page){
        const start = (page-1)*rowsPerPage;
        const end = start + rowsPerPage;

        rows.forEach((row,index)=>{
            row.style.display = (index >= start && index < end) ? '' : 'none';
        });

        prevBtn.disabled = (page === 1);
        nextBtn.disabled = (page === totalPages);

        prevBtn.style.opacity = prevBtn.disabled ? 0.5 : 1;
        nextBtn.style.opacity = nextBtn.disabled ? 0.5 : 1;
    }

    showPage(currentPage);

    nextBtn.addEventListener('click', () => {
        if(currentPage < totalPages){
            currentPage++;
            showPage(currentPage);
        }
    });

    prevBtn.addEventListener('click', () => {
        if(currentPage > 1){
            currentPage--;
            showPage(currentPage);
        }
    });

    // Fungsi global untuk tombol Lihat
    window.showMenu = function(nama, harga, kategori, status, gambar){
        document.getElementById('modalNama').textContent = nama;
        document.getElementById('modalHarga').textContent = harga;
        document.getElementById('modalKategori').textContent = kategori;
        document.getElementById('modalStatus').textContent = status;
        document.getElementById('modalGambar').src = gambar || '';
        document.getElementById('modalLihat').style.display = 'block';
    }

    document.querySelector('.close').onclick = function(){
        document.getElementById('modalLihat').style.display = 'none';
    }

    window.onclick = function(event){
        if(event.target == document.getElementById('modalLihat')){
            document.getElementById('modalLihat').style.display = 'none';
        }
    }
});
</script>
@endpush


