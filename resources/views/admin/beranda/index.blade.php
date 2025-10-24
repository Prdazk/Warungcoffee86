@extends('admin.layout.app')

@section('content')
<div id="beranda" class="content-section active">
  <div class="stats-container">

    <!-- Jumlah Admin -->
    <div class="stat-box bg-admin">
      <div class="stat-icon">👤</div>
      <div class="stat-text">
        <h2>{{ \App\Models\AdminData::count() }}</h2>
        <p>Admin</p>
      </div>
    </div>

    <!-- Jumlah Menu -->
    <div class="stat-box bg-menu">
      <div class="stat-icon">📋</div>
      <div class="stat-text">
        <h2>{{ \App\Models\Menu::count() }}</h2>
        <p>Menu</p>
      </div>
    </div>

    <!-- Jumlah Reservasi -->
    <div class="stat-box bg-reservasi">
      <div class="stat-icon">🗓️</div>
      <div class="stat-text">
        <h2>{{ \App\Models\Reservasi::count() }}</h2>
        <p>Reservasi</p>
      </div>
    </div>

  </div>
</div>
@endsection
