<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title></title>
<link href="https://fonts.googleapis.com/css2?family=Lora:wght@500&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }

  body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: #f7f3ee;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 24px;
  }

  .card {
    background: white;
    border-radius: 20px;
    padding: 48px 44px;
    width: 100%;
    max-width: 400px;
    box-shadow: 0 4px 40px rgba(0,0,0,0.07);
  }

  .logo {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 36px;
  }

  .logo-icon {
    width: 38px; height: 38px;
    background: #7aab8a;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
  }

  .logo-icon svg { width: 20px; height: 20px; }

  .logo h1 {
    font-family: 'Lora', serif;
    font-size: 18px;
    color: #2e2118;
  }

  h2 {
    font-family: 'Lora', serif;
    font-size: 22px;
    color: #2e2118;
    margin-bottom: 6px;
  }

  .sub {
    font-size: 13.5px;
    color: #9e8e80;
    margin-bottom: 32px;
  }

  .row-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
  }

  label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #5a4a3a;
    margin-bottom: 7px;
  }

  input {
    width: 100%;
    padding: 12px 14px;
    border: 1.5px solid #e8dfd5;
    border-radius: 10px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 14px;
    color: #2e2118;
    background: #faf8f5;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
    margin-bottom: 16px;
  }

  input:focus {
    border-color: #7aab8a;
    box-shadow: 0 0 0 3px rgba(122,171,138,0.15);
    background: white;
  }

  input::placeholder { color: #c8bfb5; }

  .btn {
    width: 100%;
    padding: 13px;
    background: #7aab8a;
    color: white;
    border: none;
    border-radius: 10px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s, transform 0.15s;
    margin-top: 4px;
  }

  .btn:hover { background: #5a8f6e; transform: translateY(-1px); }
  .btn:active { transform: translateY(0); }

  .bottom {
    text-align: center;
    margin-top: 22px;
    font-size: 13px;
    color: #9e8e80;
  }

  .bottom a { color: #5a8f6e; font-weight: 600; text-decoration: none; }
  .bottom a:hover { text-decoration: underline; }

  .error {
    font-size: 12px;
    color: #c0392b;
    margin-top: -10px;
    margin-bottom: 14px;
    display: block;
  }
</style>
</head>
<body>

<div class="card">

  <div class="logo">
    <div class="logo-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M4 19.5A2.5 2.5 0 016.5 17H20"/>
        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/>
      </svg>
    </div>
    <h1></h1>
  </div>

  <h2>Buat akun baru ✨</h2>
  <p class="sub">Daftar gratis dan mulai meminjam buku.</p>

  <form method="POST" action="{{ route('register') }}">
    @csrf

    <!-- Nama -->
    <div class="row-2">
      <div>
        <label for="first_name">Nama Depan</label>
        <input id="first_name" type="text" name="first_name" value="{{ old('first_name') }}" placeholder="Budi">
        @error('first_name') <span class="error">{{ $message }}</span> @enderror
      </div>
      <div>
        <label for="last_name">Nama Belakang</label>
        <input id="last_name" type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Santoso">
        @error('last_name') <span class="error">{{ $message }}</span> @enderror
      </div>
    </div>

    <!-- Email -->
    <label for="email">Email</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" autocomplete="username">
    @error('email') <span class="error">{{ $message }}</span> @enderror

    <!-- Password -->
    <label for="password">Kata Sandi</label>
    <input id="password" type="password" name="password" placeholder="Min. 8 karakter" autocomplete="new-password">
    @error('password') <span class="error">{{ $message }}</span> @enderror

    <!-- Konfirmasi -->
    <label for="password_confirmation">Konfirmasi Kata Sandi</label>
    <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Ulangi kata sandi" autocomplete="new-password">
    @error('password_confirmation') <span class="error">{{ $message }}</span> @enderror

    <button type="submit" class="btn">Buat Akun</button>
  </form>

  <div class="bottom">
    Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
  </div>

</div>

</body>
</html>