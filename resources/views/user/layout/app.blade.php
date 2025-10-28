<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Warung Coffee</title>

  {{-- CSS Global --}}
  <link rel="stylesheet" href="{{ asset('css/user/dashboard.css') }}">
  <link rel="stylesheet" href="{{ asset('css/user/menu.css') }}">
  <link rel="stylesheet" href="{{ asset('css/user/vasi.css') }}">
  <link rel="stylesheet" href="{{ asset('css/user/tentang.css') }}">
  <link rel="stylesheet" href="{{ asset('css/user/lokasi.css') }}">
  <link rel="stylesheet" href="{{ asset('css/user/about.css') }}">
  <link rel="stylesheet" href="{{ asset('css/user/popupmenu.css') }}">
</head>
<body>
  <div class="page-wrapper">
    @include('user.partials.header')

    {{-- semua section --}}
    @include('user.sections.hero')
    @include('user.sections.menu')
    @include('user.sections.reservasi')
    @include('user.sections.lokasi')
    @include('user.sections.about')
  </div>

<script src="{{ asset('js/user/user-app.js') }}"></script>

</body>
</html>
