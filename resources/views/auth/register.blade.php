<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PerpusKita — Daftar</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400;1,700&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body {
  font-family: 'Inter', sans-serif;
  min-height: 100vh;
  display: flex;
  overflow: hidden;
}

/* ── LEFT PANEL ── */
.left {
  flex: 1;
  background: #1A1A1A;
  position: relative;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  padding: 48px 56px;
  overflow: hidden;
}

.orb {
  position: absolute;
  border-radius: 50%;
  filter: blur(80px);
  animation: drift 8s ease-in-out infinite;
  pointer-events: none;
}
.orb-1 { width:360px; height:360px; background:#C4F2DE; opacity:.3;  top:-80px; right:-40px; animation-delay:0s; }
.orb-2 { width:300px; height:300px; background:#F2C4CE; opacity:.28; bottom:-60px; left:-40px; animation-delay:3s; }
.orb-3 { width:220px; height:220px; background:#C4D9F2; opacity:.22; top:45%; left:35%; animation-delay:6s; }

@keyframes drift {
  0%,100% { transform: translate(0,0) scale(1); }
  33%      { transform: translate(18px,-18px) scale(1.04); }
  66%      { transform: translate(-12px,12px) scale(.97); }
}

.left-top { position: relative; z-index: 1; }

.left-logo {
  display: flex; align-items: center; gap: 10px;
  margin-bottom: 56px;
}
.logo-box {
  width: 36px; height: 36px;
  background: white; border-radius: 9px;
  display: flex; align-items: center; justify-content: center;
}
.logo-box svg { width: 18px; height: 18px; stroke: #1A1A1A; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
.logo-name { font-family:'Playfair Display',serif; font-size:17px; color:white; font-weight:400; }

.left-heading {
  font-family: 'Playfair Display', serif;
  font-size: clamp(32px, 3vw, 48px);
  font-weight: 400; line-height: 1.15;
  color: white; margin-bottom: 20px;
}
.left-heading em { font-style: italic; color: #C4F2DE; }

.left-desc {
  font-size: 14px; font-weight: 300; line-height: 1.8;
  color: rgba(255,255,255,.5); max-width: 300px;
}

/* steps */
.steps {
  position: relative; z-index: 1;
  display: flex; flex-direction: column; gap: 16px;
}
.step {
  display: flex; align-items: flex-start; gap: 14px;
}
.step-num {
  width: 28px; height: 28px; flex-shrink: 0;
  border: 1.5px solid rgba(255,255,255,.2);
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-size: 11px; font-weight: 500; color: rgba(255,255,255,.5);
  margin-top: 1px;
}
.step-text { font-size: 13px; font-weight: 300; color: rgba(255,255,255,.55); line-height: 1.5; }
.step-text strong { color: rgba(255,255,255,.85); font-weight: 500; display: block; }

/* ── RIGHT PANEL ── */
.right {
  width: 500px; flex-shrink: 0;
  background: #FAFAFA;
  display: flex; align-items: center; justify-content: center;
  padding: 48px 56px;
  position: relative;
  overflow-y: auto;
}

.right::before {
  content: '';
  position: absolute; inset: 0;
  background-image: radial-gradient(circle, rgba(0,0,0,.06) 1px, transparent 1px);
  background-size: 24px 24px;
  pointer-events: none; opacity: .5;
}

.form-wrap {
  position: relative; z-index: 1;
  width: 100%;
  animation: slideUp .6s ease forwards;
}

@keyframes slideUp {
  from { opacity:0; transform:translateY(24px); }
  to   { opacity:1; transform:translateY(0); }
}

.form-eyebrow {
  font-size: 10.5px; letter-spacing: 3px; text-transform: uppercase;
  font-weight: 500; color: #9A9A9A; margin-bottom: 14px;
  display: flex; align-items: center; gap: 8px;
}
.form-eyebrow::before { content:''; width:20px; height:1px; background:#9A9A9A; }

.form-title {
  font-family: 'Playfair Display', serif;
  font-size: 28px; font-weight: 400;
  color: #1A1A1A; line-height: 1.15; margin-bottom: 28px;
}
.form-title em { font-style: italic; }

.row-2 {
  display: grid; grid-template-columns: 1fr 1fr; gap: 12px;
  margin-bottom: 0;
}

.field { margin-bottom: 16px; }

label {
  display: block;
  font-size: 11.5px; font-weight: 500;
  color: #1A1A1A; margin-bottom: 7px;
  letter-spacing: .5px; text-transform: uppercase;
}

input[type=email],
input[type=password],
input[type=text] {
  width: 100%;
  padding: 12px 16px;
  border: 1.5px solid #E8E8E8;
  border-radius: 12px;
  font-size: 14px;
  font-family: 'Inter', sans-serif;
  font-weight: 300; color: #1A1A1A;
  background: white; outline: none;
  transition: border-color .2s, box-shadow .2s;
  box-shadow: 0 2px 8px rgba(0,0,0,.04);
}
input:focus {
  border-color: #1A1A1A;
  box-shadow: 0 0 0 3px rgba(0,0,0,.06);
}
input::placeholder { color: #C8C8C8; font-weight: 300; }

.error { font-size: 12px; color: #E05A5A; margin-top: 5px; display: block; }

.btn {
  width: 100%; padding: 14px;
  background: #1A1A1A; color: white;
  border: none; border-radius: 50px;
  font-size: 14px; font-weight: 500;
  font-family: 'Inter', sans-serif;
  cursor: pointer;
  display: flex; align-items: center; justify-content: center; gap: 8px;
  transition: background .2s, transform .15s, box-shadow .2s;
  letter-spacing: .3px;
  box-shadow: 0 4px 20px rgba(0,0,0,.18);
  margin-top: 6px;
}
.btn:hover { background: #333; transform: translateY(-2px); box-shadow: 0 8px 28px rgba(0,0,0,.22); }
.btn .arr { font-size: 16px; transition: transform .2s; }
.btn:hover .arr { transform: translateX(4px); }

.divider {
  display: flex; align-items: center; gap: 12px;
  margin: 20px 0;
  font-size: 12px; color: #C8C8C8;
}
.divider::before, .divider::after { content:''; flex:1; height:1px; background:#EBEBEB; }

.bottom {
  text-align: center;
  font-size: 13px; color: #9A9A9A; font-weight: 300;
}
.bottom a {
  color: #1A1A1A; font-weight: 500; text-decoration: none;
  border-bottom: 1.5px solid #E8E8E8; padding-bottom: 1px;
  transition: border-color .2s;
}
.bottom a:hover { border-color: #1A1A1A; }

@media (max-width: 860px) {
  body { flex-direction: column; overflow: auto; }
  .left { min-height: 260px; padding: 36px 28px; }
  .steps { display: none; }
  .right { width: 100%; padding: 36px 24px; }
}
</style>
</head>
<body>

<!-- LEFT -->
<div class="left">
  <div class="orb orb-1"></div>
  <div class="orb orb-2"></div>
  <div class="orb orb-3"></div>

  <div class="left-top">
    <div class="left-logo">
      <div class="logo-box">
        <svg viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg>
      </div>
      <span class="logo-name">PerpusKita</span>
    </div>

    <h2 class="left-heading">
      Mulai perjalanan<br>
      membacamu <em>hari ini</em>
    </h2>
    <p class="left-desc">Daftar gratis dan akses ribuan buku pilihan dari perpustakaan kami.</p>
  </div>

  <div class="steps">
    <div class="step">
      <div class="step-num">1</div>
      <div class="step-text"><strong>Buat akun</strong>Daftar dalam hitungan detik</div>
    </div>
    <div class="step">
      <div class="step-num">2</div>
      <div class="step-text"><strong>Cari buku</strong>Temukan dari ribuan koleksi</div>
    </div>
    <div class="step">
      <div class="step-num">3</div>
      <div class="step-text"><strong>Pinjam & nikmati</strong>Baca kapan saja, di mana saja</div>
    </div>
  </div>
</div>

<!-- RIGHT -->
<div class="right">
  <div class="form-wrap">
    <div class="form-eyebrow">Buat akun baru</div>
    <h1 class="form-title">Daftar <em>sekarang</em> ✨</h1>

    <form method="POST" action="{{ route('register') }}">
      @csrf

      <div class="field">
  <label for="name">Nama Lengkap</label>
  <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Budi Santoso">
  @error('name') <span class="error">{{ $message }}</span> @enderror
</div>

      <div class="field">
        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" autocomplete="username">
        @error('email') <span class="error">{{ $message }}</span> @enderror
      </div>

      <div class="field">
        <label for="password">Kata Sandi</label>
        <input id="password" type="password" name="password" placeholder="Min. 8 karakter" autocomplete="new-password">
        @error('password') <span class="error">{{ $message }}</span> @enderror
      </div>

      <div class="field">
        <label for="password_confirmation">Konfirmasi Kata Sandi</label>
        <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Ulangi kata sandi" autocomplete="new-password">
        @error('password_confirmation') <span class="error">{{ $message }}</span> @enderror
      </div>

      <button type="submit" class="btn">Buat Akun <span class="arr">→</span></button>
    </form>

    <div class="divider">atau</div>

    <div class="bottom">
      Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
    </div>
  </div>
</div>

</body>
</html>