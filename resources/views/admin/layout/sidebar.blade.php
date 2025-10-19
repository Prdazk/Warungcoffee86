<div class="sidebar">
  <h2>Dashboard Admin</h2>
  <ul class="menu">
    <li><a href="{{ route('admin.beranda') }}"><i class="fas fa-home"></i> Beranda</a></li>
    <li><a href="{{ route('admin.menu.index') }}"><i class="fas fa-utensils"></i> Menu</a></li>
   <li><a href="{{ route('admin.reservasi.index') }}"><i class="fas fa-calendar-check"></i> Reservasi</a></li>
    <li>
      <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fas fa-sign-out-alt"></i> Logout
      </a>
      <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display:none;">
        @csrf
      </form>
    </li>
  </ul>
</div>
