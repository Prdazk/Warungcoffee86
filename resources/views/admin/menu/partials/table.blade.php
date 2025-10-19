<table>
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
    @forelse($menus as $menu)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $menu->name }}</td>
        <td>Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
        <td>{{ $menu->kategori }}</td>
        <td>{{ $menu->status }}</td>
        <td>
          @if($menu->gambar)
            <img src="{{ asset('images/' . $menu->gambar) }}" alt="{{ $menu->name }}" width="60">
          @else
            <span>Tidak ada</span>
          @endif
        </td>
        <td>
          <a href="{{ route('admin.menu.edit', $menu->id) }}" class="btn-aksi btn-edit">
            <i class="fas fa-edit"></i> Edit
          </a>
          <form action="{{ route('admin.menu.hapus', $menu->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button class="btn-aksi btn-hapus"><i class="fas fa-trash"></i> Hapus</button>
          </form>
          <button class="btn-aksi btn-lihat"
            onclick="showMenu('{{ $menu->name }}', '{{ $menu->harga }}', '{{ $menu->kategori }}', '{{ $menu->status }}', '{{ $menu->gambar ? asset('images/'.$menu->gambar) : '' }}')">
            <i class="fas fa-eye"></i> Lihat
          </button>
        </td>
      </tr>
    @empty
      <tr>
        <td colspan="7" style="text-align:center;">Belum ada data menu.</td>
      </tr>
    @endforelse
  </tbody>
</table>
