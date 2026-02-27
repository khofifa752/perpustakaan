<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PerpusKita — Masuk</title>
<link href="https://fonts.googleapis.com/css2?family=Lora:wght@500;600&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }

  body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: #eef6f0;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .card {
    background: white;
    width: 420px;
    border-radius: 20px;
    padding: 48px 40px;
    box-shadow: 0 8px 40px rgba(0,0,0,0.08);
  }

  /* Logo */
  .logo {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 32px;
  }

  .logo-box {
    width: 40px;
    height: 40px;
    background: #5a9e72;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .logo-box svg { width: 22px; height: 22px; stroke: white; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

  .logo h1 {
    font-family: 'Lora', serif;
    font-size: 20px;
    color: #1a2e1d;
  }

  /* Heading */
  h2 {
    font-family: 'Lora', serif;
    font-size: 24px;
    color: #1a2e1d;
    margin-bottom: 6px;
  }

  .sub {
    font-size: 14px;
    color: #8a9e8e;
    margin-bottom: 32px;
  }

  /* Input */
  .field { margin-bottom: 18px; }

  label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #3a4e3d;
    margin-bottom: 7px;
  }

  input {
    width: 100%;
    padding: 12px 16px;
    border: 1.5px solid #d8e8da;
    border-radius: 10px;
    font-size: 14px;
    font-family: inherit;
    color: #1a2e1d;
    background: #f6fbf7;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
  }

  input:focus {
    border-color: #5a9e72;
    box-shadow: 0 0 0 3px rgba(90,158,114,0.15);
    background: white;
  }

  input::placeholder { color: #b8ccba; }

  /* Error */
  .error {
    font-size: 12px;
    color: #c0392b;
    margin-top: 5px;
    display: block;
  }

  /* Extras row */
  .extras {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 4px 0 24px;
  }

  .remember {
    display: flex;
    align-items: center;
    gap: 7px;
    font-size: 13px;
    color: #8a9e8e;
    cursor: pointer;
  }

  .remember input[type=checkbox] {
    width: auto;
    padding: 0;
    border: none;
    box-shadow: none;
    background: none;
    accent-color: #5a9e72;
  }

  .forgot {
    font-size: 13px;
    font-weight: 600;
    color: #5a9e72;
    text-decoration: none;
  }

  .forgot:hover { text-decoration: underline; }

  /* Button */
  .btn {
    width: 100%;
    padding: 13px;
    background: #5a9e72;
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    font-family: inherit;
    cursor: pointer;
    transition: background 0.2s, transform 0.15s;
  }

  .btn:hover { background: #3d7a54; transform: translateY(-1px); }
  .btn:active { transform: translateY(0); }

  /* Bottom link */
  .bottom {
    text-align: center;
    margin-top: 20px;
    font-size: 13px;
    color: #8a9e8e;
  }

  .bottom a {
    color: #5a9e72;
    font-weight: 600;
    text-decoration: none;
  }

  .bottom a:hover { text-decoration: underline; }
</style>
</head>
<body>

<div class="card">

  <div class="logo">
    <div class="logo-box">
      <svg viewBox="0 0 24 24">
        <path d="M4 19.5A2.5 2.5 0 016.5 17H20"/>
        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/>
      </svg>
    </div>
    <h1>PerpusKita</h1>
  </div>

  <h2>Selamat datang 👋</h2>
  <p class="sub">Masuk untuk mulai meminjam buku.</p>

  <form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="field">
      <label for="email">Email</label>
      <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" autocomplete="username">
      @error('email') <span class="error">{{ $message }}</span> @enderror
    </div>

    <div class="field">
      <label for="password">Kata Sandi</label>
      <input id="password" type="password" name="password" placeholder="••••••••" autocomplete="current-password">
      @error('password') <span class="error">{{ $message }}</span> @enderror
    </div>

    <div class="extras">
      <label class="remember">
        <input type="checkbox" name="remember"> Ingat saya
      </label>
      @if (Route::has('password.request'))
        <a href="{{ route('password.request') }}" class="forgot">Lupa sandi?</a>
      @endif
    </div>

    <button type="submit" class="btn">Masuk</button>
  </form>

  <div class="bottom">
    Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
  </div>

</div>

</body>
</html>