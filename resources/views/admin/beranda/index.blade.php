@extends('admin.layout.app')

@section('content')
<div id="beranda" class="content-section active">
  <div class="stats-container" style="display:flex; flex-wrap:wrap; gap:16px; justify-content:center;">


    
    <!-- Jumlah Superadmin -->
    <div class="stat-box" style="flex:1 1 200px; background:#b1823d; color:#4e342e; border-radius:12px; padding:16px; display:flex; align-items:center; gap:12px; box-shadow:0 6px 18px rgba(0,0,0,0.2); transition: transform 0.3s ease;">
     <div class="stat-icon" style="font-size:32px;">👔</div>
      <div class="stat-text">
        <h2 style="margin:0; font-size:22px;">{{ \App\Models\AdminData::where('role', 'superadmin')->count() }}</h2>
        <p style="margin:0; font-size:14px;">Data Superadmin</p>
      </div>
    </div>

    <!-- Jumlah Admin -->
    <div class="stat-box" style="flex:1 1 200px; background:#d6bf3a; color:#fff; border-radius:12px; padding:16px; display:flex; align-items:center; gap:12px; box-shadow:0 6px 18px rgba(0,0,0,0.2); transition: transform 0.3s ease;">
      <div class="stat-icon" style="font-size:32px;">👤</div>
      <div class="stat-text">
        <h2 style="margin:0; font-size:22px;">{{ \App\Models\AdminData::count() }}</h2>
        <p style="margin:0; font-size:14px;">Data Jumlah Admin</p>
      </div>
    </div>

    <!-- Jumlah Menu -->
    <div class="stat-box" style="flex:1 1 200px; background:#81c784; color:#fff; border-radius:12px; padding:16px; display:flex; align-items:center; gap:12px; box-shadow:0 6px 18px rgba(0,0,0,0.2); transition: transform 0.3s ease;">
      <div class="stat-icon" style="font-size:32px;">📋</div>
      <div class="stat-text">
        <h2 style="margin:0; font-size:22px;">{{ \App\Models\Menu::count() }}</h2>
        <p style="margin:0; font-size:14px;">Data Menu</p>
      </div>
    </div>

    <!-- Jumlah Reservasi -->
    <div class="stat-box" style="flex:1 1 200px; background:#4fc3f7; color:#fff; border-radius:12px; padding:16px; display:flex; align-items:center; gap:12px; box-shadow:0 6px 18px rgba(0,0,0,0.2); transition: transform 0.3s ease;">
      <div class="stat-icon" style="font-size:32px;">🗓️</div>
      <div class="stat-text">
        <h2 style="margin:0; font-size:22px;">{{ \App\Models\Reservasi::count() }}</h2>
        <p style="margin:0; font-size:14px;">Data Reservasi</p>
      </div>
    </div>

  </div>
</div>

<script>
  // Animasi hover: zoom ringan
  document.querySelectorAll('.stat-box').forEach(box => {
    box.addEventListener('mouseover', () => box.style.transform = 'scale(1.05)');
    box.addEventListener('mouseout', () => box.style.transform = 'scale(1)');
  });
</script>
@endsection
