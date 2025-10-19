<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Warung Coffee 86</title>
  {{-- CSS Global --}}
  <link rel="stylesheet" href="{{ asset('css/user/dashboard.css') }}">
  <link rel="stylesheet" href="{{ asset('css/user/menu.css') }}">
  <link rel="stylesheet" href="{{ asset('css/user/servasi.css') }}">
  <link rel="stylesheet" href="{{ asset('css/user/tentang.css') }}">
  <link rel="stylesheet" href="{{ asset('css/user/lokasi.css') }}">
  <link rel="stylesheet" href="{{ asset('css/user/about.css') }}">
</head>
<body>
  <div class="page-wrapper">
    @yield('content')
  </div>
</body>
</html>
