// Script toggle password visibility
document.addEventListener('DOMContentLoaded', () => {
  const toggle = document.getElementById('togglePassword');
  const passwordInput = document.getElementById('password');

  if (toggle && passwordInput) {
    toggle.addEventListener('click', () => {
      const isHidden = passwordInput.type === 'password';
      passwordInput.type = isHidden ? 'text' : 'password';
      toggle.textContent = isHidden ? '🙉' : '🙈';

      // Otomatis kembali ke mode tersembunyi setelah 1 detik
      setTimeout(() => {
        passwordInput.type = 'password';
        toggle.textContent = '🙈';
      }, 1000);
    });
  }
});
