<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Coffee86</title>
  <link rel="stylesheet" href="{{ asset('css/admin/login.css') }}">
</head>
<body>

  <div class="login-box">
    <h2>☕ Selamat datang</h2>

    <!-- Notifikasi error -->
    @if(session('error'))
      <div class="login-error">{{ session('error') }}</div>
    @endif

    <form action="{{ route('admin.login') }}" method="POST">
      @csrf
      <div class="input-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" placeholder="Masukkan username anda" required>
      </div>
      <div class="input-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Masukkan password anda" required>
      </div>
      <button type="submit" class="btn-login">Login</button>
    </form>

    <div class="extra-links">
      <p><a href="#">Lupa password?</a></p>
    </div>
  </div>

</body>
</html>
