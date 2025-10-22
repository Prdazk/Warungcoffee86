<!DOCTYPE html>
<html lang="id">
<head>
    @include('admin.layout.head')

    <!-- ===== Bootstrap 5 CSS ===== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* ===== USER MENU ===== */
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

        .user-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 6px;
            width: 120px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            display: none;
            flex-direction: column;
            gap: 6px;
            z-index: 1000;
        }

        .user-menu.active .user-dropdown {
            display: flex;
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

        /* ===== NOTIFIKASI ===== */
        .notification-btn {
            position: relative;
            cursor: default;
        }

        .notification-btn span:first-child {
            color: gold;
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

        /* ===== ANIMASI ===== */
        @keyframes pulse {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.2); opacity: 0.7; }
            100% { transform: scale(1); opacity: 1; }
        }

        @keyframes shake {
            0% { transform: translateX(0); }
            8% { transform: translateX(-3px); }
            17% { transform: translateX(3px); }
            25% { transform: translateX(-3px); }
            33% { transform: translateX(3px); }
            42% { transform: translateX(-3px); }
            50% { transform: translateX(3px); }
            58% { transform: translateX(-3px); }
            67% { transform: translateX(3px); }
            75% { transform: translateX(-3px); }
            83% { transform: translateX(3px); }
            92% { transform: translateX(-3px); }
            100% { transform: translateX(0); }
        }

        #userMenu.reservation-alert {
            animation: pulse 1s;
            position: relative;
        }

        #userMenu.reservation-alert::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 10px;
            height: 10px;
            background: red;
            border-radius: 50%;
            animation: shake 1s;
        }
    </style>
</head>

<body>
    @include('admin.layout.sidebar')

    <!-- ===== USER MENU ===== -->
    <div style="position: fixed; top: 10px; right: 20px; z-index: 1000;">
        <div class="user-menu" id="userMenu">
            <span class="user-name">{{ Auth::user()->name ?? 'Prada TI' }}</span>
            <img src="{{ asset('images/avatar.png') }}" alt="User Avatar" class="user-avatar">

            <div class="user-dropdown">
                <button type="button" class="notification-btn" onclick="return false;">
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

    // Toggle dropdown logout
    userMenu.addEventListener('click', function(e) {
        this.classList.toggle('active');
    });

    // Animasi notifikasi
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
