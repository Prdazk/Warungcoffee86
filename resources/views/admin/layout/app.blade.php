<!DOCTYPE html>
<html lang="id">
<head>
    @include('admin.layout.head')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    @include('admin.layout.sidebar')

                <div style="position: fixed; top: 10px; right: 20px; z-index: 1000;">
                <div class="user-menu" id="userMenu">
                    <span class="user-name">
                        {{ Auth::guard('admin')->check() ? Auth::guard('admin')->user()->nama : '' }}
                    </span>

                    <img src="{{ asset('images/avatar.png') }}" alt="User Avatar" class="user-avatar">

                  <div class="user-dropdown">
                    <button type="button" class="notification-btn" 
                            onclick="window.location.href='{{ route('admin.reservasi.index') }}'">
                        <span class="notification-icon">
                            🔔
                            @if(!empty($jumlahBaru) && $jumlahBaru > 0)
                                <span class="notification-badge">{{ $jumlahBaru }}</span>
                            @endif
                        </span>
                        Notifikasi
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

    <div class="content">
        @yield('content')
    </div>

    @include('admin.layout.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>