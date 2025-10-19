<div class="sidebar">
  <h2>Dashboard Admin</h2>
  <ul class="menu">
    <li><a href="{{ route('admin.beranda') }}"><i class="fas fa-home"></i> Beranda</a></li>
    <li><a href="{{ route('admin.menu.index') }}"><i class="fas fa-utensils"></i> Menu</a></li>
    <li><a href="{{ route('admin.reservasi.index') }}"><i class="fas fa-calendar-check"></i> Reservasi</a></li>

    <!-- Tombol Data Admin (hanya untuk superadmin) -->
    @if(Auth::user() && Auth::user()->role === 'superadmin')
      <li><a href="{{ route('admin.dataAdmin.index') }}"><i class="fas fa-users-cog"></i> Data Admin</a></li>
    @endif
  </ul>
</div>
