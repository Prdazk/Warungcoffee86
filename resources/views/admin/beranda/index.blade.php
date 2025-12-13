@extends('admin.layout.app')

@section('content')
@php
use Carbon\Carbon;

$awalMinggu = Carbon::now()->startOfWeek(); // Senin
$akhirMinggu = Carbon::now()->endOfWeek();  // Minggu

$stats = [
    [
        'icon' => '👔',
        'count' => \App\Models\AdminData::where('role','superadmin')->count(),
        'label' => 'Data Superadmin',
        'bg' => '#b1823d',
        'color' => '#4e342e'
    ],
    [
        'icon' => '👤',
        'count' => \App\Models\AdminData::count(),
        'label' => 'Data Jumlah Admin',
        'bg' => '#d6bf3a',
        'color' => '#fff'
    ],
    [
        'icon' => '📋',
        'count' => \App\Models\Menu::count(),
        'label' => 'Data Menu',
        'bg' => '#81c784',
        'color' => '#fff'
    ],
    [
        'icon' => '🗓️',
        'count' => \App\Models\Reservasi::count(),
        'label' => 'Total Reservasi',
        'bg' => '#4fc3f7',
        'color' => '#fff'
    ],
    [
        'icon' => '📊',
        'count' => \App\Models\Reservasi::whereBetween('tanggal', [
            $awalMinggu->toDateString(),
            $akhirMinggu->toDateString()
        ])->count(),
        'label' => 'Reservasi Minggu Ini',
        'bg' => '#9575cd',
        'color' => '#fff'
    ],
];
@endphp

<div id="beranda" class="content-section active">
    <div class="stats-container"
         style="display:flex; flex-wrap:wrap; gap:14px; justify-content:center;">
        @foreach($stats as $stat)
        <div class="stat-box"
             style="
                width:200px;
                background:{{ $stat['bg'] }};
                color:{{ $stat['color'] }};
                border-radius:10px;
                padding:12px;
                display:flex;
                align-items:center;
                gap:10px;
                box-shadow:0 4px 14px rgba(0,0,0,0.18);
                transition:transform 0.3s ease;
             ">
            <div class="stat-icon" style="font-size:28px;">
                {{ $stat['icon'] }}
            </div>
            <div class="stat-text" style="display:flex; flex-direction:column;">
                <h2 style="margin:0; font-size:20px;">{{ $stat['count'] }}</h2>
                <p style="margin:0; font-size:13px;">{{ $stat['label'] }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>


<script src="{{ asset('js/admin/beranda-index.js') }}"></script>
@endsection
