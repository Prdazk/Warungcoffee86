<!DOCTYPE html>
<html lang="id">
<head>
  @include('admin.layout.head')
</head>
<body>
  @include('admin.layout.sidebar')

  <div class="content">
    @yield('content')
  </div>

  @include('admin.layout.footer')
</body>
</html>
