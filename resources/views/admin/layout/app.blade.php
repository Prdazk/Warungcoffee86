<!DOCTYPE html>
<html lang="id">
<head>
    @include('admin.layout.head')

    <!-- ===== Bootstrap 5 CSS ===== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    @include('admin.layout.sidebar')

    <!-- ===== USER MENU ===== -->
    <div style="position: fixed; top: 10px; right: 20px; z-index: 1000;">
        <div class="user-menu" id="userMenu">
            <span class="user-name">{{ Auth::user()->name ?? 'Prada TI' }}</span>
            <img src="{{ asset('images/avatar.png') }}" alt="User Avatar" class="user-avatar">

            <div class="user-dropdown">
                <button type="button" class="notification-btn" 
                        onclick="window.location.href='{{ route('admin.reservasi.index') }}'">
                    <span>🔔 Notifikasi</span>
                    @if(!empty($jumlahBaru) && $jumlahBaru > 0)
                        <span class="notification-badge">{{ $jumlahBaru }}</span>
                    @endif
                </button>

                <a href="{{ route('admin.logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                   ⬅️ Logout
                </a>

                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display:none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>

    <!-- ===== KONTEN HALAMAN ===== -->
    <div class="content">
        @yield('content')
    </div>

    @include('admin.layout.footer')

    <!-- ===== Bootstrap 5 JS ===== -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    const userMenu = document.getElementById('userMenu');

    // Toggle dropdown saat klik user menu
    userMenu.addEventListener('click', function(e) {
        e.stopPropagation();
        this.classList.toggle('active');
    });

    // Tutup dropdown jika klik di luar
    document.addEventListener('click', function() {
        userMenu.classList.remove('active');
    });

    // Animasi badge notifikasi
    function triggerAlert() {
        userMenu.classList.add('reservation-alert');
        setTimeout(() => {
            userMenu.classList.remove('reservation-alert');
        }, 1000);
    }

    setInterval(triggerAlert, 5000);
    </script>

    <!-- ===== Stack Scripts dari Child Views ===== -->
    @stack('scripts')

</body>
</html>
