@extends('admin.layout.app')

@section('content')
<div id="beranda" class="content-section active">
  <h1>Selamat Datang di Dashboard</h1>

  <div class="stats-container" style="display:flex; gap:20px; flex-wrap:wrap;">
    <!-- Jumlah Admin -->
    <div class="stat-box" style="flex:1; min-width:150px; background:#795548; color:white; padding:20px; border-radius:10px; text-align:center; box-shadow:0 3px 8px rgba(0,0,0,0.2);">
      <h2 id="count-admin">{{ \App\Models\Admin::count() }}</h2>
      <p>Admin</p>
    </div>

    <!-- Jumlah Admin Online (optional, jika pakai last_login) -->
    {{-- 
    <div class="stat-box" style="flex:1; min-width:150px; background:#8d6e63; color:white; padding:20px; border-radius:10px; text-align:center; box-shadow:0 3px 8px rgba(0,0,0,0.2);">
      <h2 id="count-admin-online">{{ \App\Models\Admin::where('last_login', '>=', now()->subMinutes(15))->count() }}</h2>
      <p>Admin Online</p>
    </div> 
    --}}

    <!-- Jumlah Menu -->
    <div class="stat-box" style="flex:1; min-width:150px; background:#6d4c41; color:white; padding:20px; border-radius:10px; text-align:center; box-shadow:0 3px 8px rgba(0,0,0,0.2);">
      <h2 id="count-menu">{{ \App\Models\Menu::count() }}</h2>
      <p>Menu</p>
    </div>

    <!-- Jumlah Reservasi -->
    <div class="stat-box" style="flex:1; min-width:150px; background:#5d4037; color:white; padding:20px; border-radius:10px; text-align:center; box-shadow:0 3px 8px rgba(0,0,0,0.2);">
      <h2 id="count-reservasi">{{ \App\Models\Reservasi::count() }}</h2>
      <p>Reservasi</p>
    </div>
  </div>
</div>
@endsection
