@extends('admin.layout.app')

@section('content')
<div id="beranda" class="content-section active">
  
  <div class="stats-container" style="display:flex; gap:20px; flex-wrap:wrap;">

    <!-- Jumlah Admin -->
    <div class="stat-box" style="flex:1; min-width:170px; background:#b68f81; color:white; padding:20px 18px; border-radius:12px; display:flex; align-items:center; box-shadow:0 4px 10px rgba(0,0,0,0.25);">
      <div style="font-size:30px; margin-right:12px;">👤</div>
      <div style="text-align:left;">
        <h2 id="count-admin" style="margin:0; font-size:24px;">{{ \App\Models\Admin::count() }}</h2>
        <p style="margin:0; font-size:16px;">Admin</p>
      </div>
    </div>

    <!-- Jumlah Menu -->
    <div class="stat-box" style="flex:1; min-width:170px; background:#b68f81; color:white; padding:20px 18px; border-radius:12px; display:flex; align-items:center; box-shadow:0 4px 10px rgba(0,0,0,0.25);">
      <div style="font-size:30px; margin-right:12px;">📋</div>
      <div style="text-align:left;">
        <h2 id="count-menu" style="margin:0; font-size:24px;">{{ \App\Models\Menu::count() }}</h2>
        <p style="margin:0; font-size:16px;">Menu</p>
      </div>
    </div>

    <!-- Jumlah Reservasi -->
    <div class="stat-box" style="flex:1; min-width:170px; background:#b68f81; color:white; padding:20px 18px; border-radius:12px; display:flex; align-items:center; box-shadow:0 4px 10px rgba(0,0,0,0.25);">
      <div style="font-size:30px; margin-right:12px;">👤</div>
      <div style="text-align:left;">
        <h2 id="count-reservasi" style="margin:0; font-size:24px;">{{ \App\Models\Reservasi::count() }}</h2>
        <p style="margin:0; font-size:16px;">Reservasi</p>
      </div>
    </div>

  </div>
</div>
@endsection
