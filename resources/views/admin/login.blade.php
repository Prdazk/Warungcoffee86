<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin Coffee86</title>
  <link rel="stylesheet" href="{{ asset('css/admin/login-admin.css') }}">
</head>
<body>

  <div class="login-box">
    <h2>☕ Admin Coffee86</h2>

    <!-- Notifikasi error -->
    @if(session('error'))
      <div class="login-error">{{ session('error') }}</div>
    @endif

    <form action="{{ route('admin.login.submit') }}" method="POST">
      @csrf

      <div class="input-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Masukkan email admin" required>
      </div>
      <div class="input-group password-group">
        <label for="password">Password</label>
        <div class="password-wrapper">
          <input type="password" id="password" name="password" placeholder="Masukkan password anda" required>
          <span class="toggle-password" id="togglePassword">🙈</span>
        </div>
      </div>
      <button type="submit" class="btn-login">Login</button>
    </form>
  </div>
  <script src="{{ asset('js/admin/login-admin.js') }}"></script>
</body>
</html>
