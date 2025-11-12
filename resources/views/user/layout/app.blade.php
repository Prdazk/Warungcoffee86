<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Warung Coffee</title>

  <link rel="stylesheet" href="{{ asset('css/user/dashboard.css') }}">
  <link rel="stylesheet" href="{{ asset('css/user/menu.css') }}">
  <link rel="stylesheet" href="{{ asset('css/user/vasi.css') }}">
  <link rel="stylesheet" href="{{ asset('css/user/tentang.css') }}">
  <link rel="stylesheet" href="{{ asset('css/user/user-lokasi.css') }}">
  <link rel="stylesheet" href="{{ asset('css/user/about.css') }}">
  <link rel="stylesheet" href="{{ asset('css/user/popupmenu.css') }}">
  <link rel="stylesheet" href="{{ asset('css/user/iniloo.css') }}">
  <link rel="stylesheet" href="{{ asset('css/user/user-about.css') }}">


</head>
<body>

  <div class="page-wrapper">
    @include('user.partials.header')

    @include('user.sections.hero')
    @include('user.sections.menu')
    @include('user.sections.reservasi')
    @include('user.sections.lokasi')
    @include('user.sections.about')
  </div>

<script src="{{ asset('js/user/user-app.js') }}"></script>
<script src="{{ asset('js/user/user-menu.js') }}"></script>
<script src="{{ asset('js/user/user-lokasi.js') }}"></script>
<script src="{{ asset('js/user/user-about.js') }}"></script>

</body>
</html>
