<!DOCTYPE html>
<html lang="id">
<head>
    @include('admin.layout.head')
    <style>
        /* User Menu Container */
        .user-menu {
            position: relative;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            user-select: none;
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
        }

        /* Dropdown Menu */
        .user-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 10px;
            width: 220px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            display: flex;
            flex-direction: column;
            gap: 8px;
            z-index: 1000;
        }

        .user-dropdown button,
        .user-dropdown a {
            display: flex;
            align-items: center;
            gap: 6px;
            background: none;
            border: none;
            cursor: pointer;
            text-decoration: none;
            color: #333;
            font-weight: 500;
            padding: 6px 8px;
            border-radius: 4px;
            transition: background 0.2s;
        }

        .user-dropdown button:hover,
        .user-dropdown a:hover {
            background: #f0f0f0;
        }

        /* Notifikasi */
        .notification-btn {
            position: relative;
            cursor: default; /* Non-interaktif */
        }

        .notification-btn span:first-child {
            color: gold; /* Logo notifikasi kuning */
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: red;
            color: white;
            border-radius: 50%;
            font-size: 12px;
            padding: 2px 6px;
        }
    </style>
</head>
<body>
    @include('admin.layout.sidebar')

    <div style="position: fixed; top: 10px; right: 20px; z-index: 1000;">
        <div class="user-menu" id="userMenu">
            <span class="user-name">{{ Auth::user()->name ?? 'Prada TI' }}</span>
            <img src="{{ asset('images/avatar.png') }}" alt="User Avatar" class="user-avatar">

            <!-- Dropdown -->
            <div class="user-dropdown">
                <!-- Notifikasi (tidak bisa diklik) -->
                <button type="button" class="notification-btn" onclick="return false;">
                    <span>🔔 Notifikasi</span>
                    @if($jumlahBaru > 0)
                        <span class="notification-badge">{{ $jumlahBaru }}</span>
                    @endif
                </button>

                <!-- Logout -->
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

    <script>
        const userMenu = document.getElementById('userMenu');

        // Toggle user dropdown untuk logout saja
        userMenu.addEventListener('click', function(e) {
            this.classList.toggle('active');
        });

        // Hapus event dropdown notifikasi karena sudah non-interaktif
    </script>

    @yield('scripts')
</body>
</html>