@extends('admin.layout.app')

@section('content')
@php
$stats = [
    ['icon' => '👔', 'count' => \App\Models\AdminData::where('role','superadmin')->count(), 'label' => 'Data Superadmin', 'bg' => '#b1823d', 'color' => '#4e342e'],
    ['icon' => '👤', 'count' => \App\Models\AdminData::count(), 'label' => 'Data Jumlah Admin', 'bg' => '#d6bf3a', 'color' => '#fff'],
    ['icon' => '📋', 'count' => \App\Models\Menu::count(), 'label' => 'Data Menu', 'bg' => '#81c784', 'color' => '#fff'],
    ['icon' => '🗓️', 'count' => \App\Models\Reservasi::count(), 'label' => 'Data Reservasi', 'bg' => '#4fc3f7', 'color' => '#fff'],
];
@endphp

<div id="beranda" class="content-section active">
    <div class="stats-container" style="display:flex; flex-wrap:wrap; gap:16px; justify-content:center;">
        @foreach($stats as $stat)
        <div class="stat-box" style="flex:1 1 200px; background:{{ $stat['bg'] }}; color:{{ $stat['color'] }}; border-radius:12px; padding:16px; display:flex; align-items:center; gap:12px; box-shadow:0 6px 18px rgba(0,0,0,0.2); transition:transform 0.3s ease;">
            <div class="stat-icon" style="font-size:32px;">{{ $stat['icon'] }}</div>
            <div class="stat-text">
                <h2 style="margin:0; font-size:22px;">{{ $stat['count'] }}</h2>
                <p style="margin:0; font-size:14px;">{{ $stat['label'] }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script src="{{ asset('js/admin/beranda-index.js') }}"></script>
@endsection