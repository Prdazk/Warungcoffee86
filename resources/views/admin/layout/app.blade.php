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
            <div class="user-dropdown" style="display:flex; flex-direction:column; gap:8px;">
                <!-- Tombol Notifikasi -->
                <button type="button" class="notification-btn"
                    style="background:none; border:none; cursor:pointer; display:flex; align-items:center; gap:6px;">
                    <span style="font-size:18px;">🔔</span>
                    <span>Notifikasi</span>
                </button>

                <!-- Tombol Logout -->
                <a href="{{ route('admin.logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   style="text-decoration:none; color:inherit; display:flex; align-items:center; gap:6px;">
                    <span style="font-size:18px;">⬅️</span>
                    <span>Logout</span>
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

        document.addEventListener('click', function(e) {
            if (!userMenu.contains(e.target)) {
                userMenu.classList.remove('active');
            }
        });
    </script>

    <!-- Yield scripts dari halaman (JS modal, dsb) -->
    @yield('scripts')
</body>
</html>
