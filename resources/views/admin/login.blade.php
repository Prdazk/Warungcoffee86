<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin Coffee86</title>
  <link rel="stylesheet" href="{{ asset('css/admin/login.css') }}">
</head>
 <style>
    .password-wrapper { position: relative; display: inline-block; width: 100%; }
    .password-wrapper input { padding-right: 40px; }
    .toggle-password { position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer; font-size: 20px; }
  </style>
<body>

  <div class="login-box">
    <h2>☕ Admin Coffee86</h2>

    <!-- Notifikasi error -->
    @if(session('error'))
      <div class="login-error">{{ session('error') }}</div>
    @endif

    <form action="{{ route('admin.login.submit') }}" method="POST">
      @csrf

      <!-- Input email -->
      <div class="input-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Masukkan email admin" required>
      </div>

      <!-- Input password -->
      <div class="input-group password-group">
        <label for="password">Password</label>
        <div class="password-wrapper">
          <input type="password" id="password" name="password" placeholder="Masukkan password anda" required>
          <span class="toggle-password" id="togglePassword">🙈</span>
        </div>
      </div>

      <button type="submit" class="btn-login">Login</button>
    </form>

    <div class="extra-links">
      <p><a href="#">Lupa password?</a></p>
    </div>
  </div>

  <script>
    const toggle = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    toggle.addEventListener('click', () => {
      if(passwordInput.type === 'password'){
        passwordInput.type = 'text';
        toggle.textContent = '🙉';
      } else {
        passwordInput.type = 'password';
        toggle.textContent = '🙈';
      }

      setTimeout(() => {
        passwordInput.type = 'password';
        toggle.textContent = '🙈';
      }, 1000);
    });
  </script>

</body>
</html>
