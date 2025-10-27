<div class="sidebar">
    <h2>Dashboard Admin</h2>
    <ul class="menu">
        <li class="menu-item">
            <a href="{{ route('admin.beranda') }}">
                <i class="fas fa-home"></i> Beranda
            </a>
        </li>

        <li class="menu-item">
            <a href="{{ route('admin.menu.index') }}">
                <i class="fas fa-utensils"></i> Menu
            </a>
        </li>

        <li class="menu-item">
            <a href="{{ route('admin.reservasi.index') }}">
                <i class="fas fa-calendar-check"></i> Reservasi
            </a>
        </li>

        @auth('admin')
            @if(Auth::guard('admin')->user()->role === 'superadmin')
                <li class="menu-item">
                    <a href="{{ route('admin.dataAdmin.index') }}">
                        <i class="fas fa-users-cog"></i> Kelola  Admin
                    </a>
                </li>
            @endif
        @endauth
    </ul>
</div>