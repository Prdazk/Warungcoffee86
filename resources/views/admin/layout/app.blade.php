<!DOCTYPE html>
<html lang="id">
<head>
  @include('admin.layout.head')
</head>
<body>
  @include('admin.layout.sidebar')

<!-- User Menu di kanan atas -->
<div style="position: fixed; top: 10px; right: 20px; z-index: 1000;">
    <div class="user-menu" id="userMenu">
        <span class="user-name">{{ Auth::user()->name ?? 'Prada TI' }}</span>
        <img src="{{ asset('images/avatar.png') }}" alt="User Avatar" class="user-avatar">

        <!-- Dropdown -->
        <div class="user-dropdown">
            <a href="{{ route('admin.logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
               Logout
            </a>
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display:none;">
                @csrf
            </form>
        </div>
    </div>
</div>


  <!-- Konten utama -->
  <div class="content">
    @yield('content')
  </div>

  @include('admin.layout.footer')

      <script>
        const userMenu = document.getElementById('userMenu');

        userMenu.addEventListener('click', function(e) {
            this.classList.toggle('active');
        });

        // Klik di luar untuk menutup dropdown
        document.addEventListener('click', function(e) {
            if (!userMenu.contains(e.target)) {
                userMenu.classList.remove('active');
            }
        });
    </script>


</body>
</html>
