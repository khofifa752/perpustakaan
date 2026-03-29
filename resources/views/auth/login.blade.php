<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PerpusKita — Masuk</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400;1,700&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body {
  font-family: 'Inter', sans-serif;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #FFFFFF;
  position: relative;
  overflow: hidden;
}

.bg { position: fixed; inset: 0; z-index: 0; }

.orb {
  position: absolute; border-radius: 50%;
  filter: blur(90px);
  animation: drift 9s ease-in-out infinite;
  pointer-events: none;
}
.orb-1 { width:500px; height:500px; background:#F2C4CE; opacity:.55; top:-120px; left:-80px; animation-delay:0s; }
.orb-2 { width:420px; height:420px; background:#C4D9F2; opacity:.45; bottom:-100px; right:-60px; animation-delay:3s; }
.orb-3 { width:320px; height:320px; background:#C4F2DE; opacity:.4;  top:40%; right:15%; animation-delay:6s; }

@keyframes drift {
  0%,100% { transform: translate(0,0) scale(1); }
  33%      { transform: translate(24px,-20px) scale(1.06); }
  66%      { transform: translate(-16px,18px) scale(.96); }
}

/* floating books */
.bg-books {
  position: absolute;
  bottom: -20px; right: 8%;
  display: flex; align-items: flex-end; gap: 16px;
  z-index: 1;
}
.bk {
  border-radius: 4px 12px 12px 4px;
  overflow: hidden; position: relative;
  animation: floatBook 6s ease-in-out infinite;
}
.bk::before {
  content:''; position:absolute; left:0; top:0;
  width:10px; height:100%;
  background:rgba(0,0,0,.18); z-index:2;
  border-radius:4px 0 0 4px;
}
.bk::after {
  content:''; position:absolute; inset:0;
  background:linear-gradient(130deg,rgba(255,255,255,.12) 0%,transparent 55%);
  z-index:3; pointer-events:none;
}
.bk-face { padding:18px 14px 14px 18px; display:flex; flex-direction:column; justify-content:space-between; height:100%; }
.bk-g { font-size:8px; letter-spacing:2.5px; text-transform:uppercase; color:rgba(255,255,255,.45); font-weight:600; }
.bk-t { font-family:'Playfair Display',serif; font-size:14px; font-style:italic; line-height:1.28; color:rgba(255,255,255,.9); margin-top:auto; }
.bk-a { font-size:9px; color:rgba(255,255,255,.38); margin-top:4px; }

.b1 { width:130px; height:190px; background:linear-gradient(150deg,#5C4B6B,#2E2438); box-shadow:8px 20px 50px rgba(0,0,0,.18); --r:-5deg; animation-delay:0s; }
.b2 { width:150px; height:218px; background:linear-gradient(150deg,#2B4A35,#162617); box-shadow:10px 24px 60px rgba(0,0,0,.2);  --r:0deg;  animation-delay:1.5s; }
.b3 { width:138px; height:200px; background:linear-gradient(150deg,#6B4B58,#382432); box-shadow:8px 20px 50px rgba(0,0,0,.18); --r:4deg;  animation-delay:3s; }
.b4 { width:122px; height:178px; background:linear-gradient(150deg,#2A3850,#141C28); box-shadow:6px 16px 40px rgba(0,0,0,.15); --r:-3deg; animation-delay:4.5s; }

@keyframes floatBook {
  0%,100% { transform: translateY(0) rotate(var(--r,0deg)); }
  50%      { transform: translateY(-12px) rotate(var(--r,0deg)); }
}

/* logo */
.site-logo {
  position: fixed; top: 40px; left: 48px;
  display: flex; align-items: center; gap: 10px; z-index: 10;
}
.logo-box {
  width: 36px; height: 36px;
  background: #1A1A1A; border-radius: 9px;
  display: flex; align-items: center; justify-content: center;
}
.logo-box svg { width: 18px; height: 18px; stroke: white; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
.logo-name { font-family:'Playfair Display',serif; font-size:17px; color:#1A1A1A; font-weight:400; }

/* ── GLASS CARD ── */
.card {
  position: relative; z-index: 5;
  width: 420px;
  background: rgba(255,255,255,0.55);
  backdrop-filter: blur(32px);
  -webkit-backdrop-filter: blur(32px);
  border: 1px solid rgba(255,255,255,0.75);
  border-radius: 28px;
  padding: 52px 48px;
  box-shadow: 0 8px 40px rgba(0,0,0,.08), inset 0 1px 0 rgba(255,255,255,.9);
  animation: slideUp .7s ease forwards;
}

@keyframes slideUp {
  from { opacity:0; transform:translateY(28px); }
  to   { opacity:1; transform:translateY(0); }
}

.form-eyebrow {
  font-size: 10.5px; letter-spacing: 3px; text-transform: uppercase;
  font-weight: 500; color: #9A9A9A;
  margin-bottom: 14px;
  display: flex; align-items: center; gap: 8px;
}
.form-eyebrow::before { content:''; width:20px; height:1px; background:#9A9A9A; }

.form-title {
  font-family: 'Playfair Display', serif;
  font-size: 30px; font-weight: 400;
  color: #1A1A1A; line-height: 1.15; margin-bottom: 32px;
}
.form-title em { font-style: italic; color: #C0607A; }

.field { margin-bottom: 18px; }

label {
  display: block;
  font-size: 11px; font-weight: 500;
  color: #4A4A4A; margin-bottom: 8px;
  letter-spacing: .5px; text-transform: uppercase;
}

input[type=email],
input[type=password] {
  width: 100%;
  padding: 13px 16px;
  border: 1.5px solid rgba(0,0,0,.1);
  border-radius: 12px;
  font-size: 14px;
  font-family: 'Inter', sans-serif;
  font-weight: 300; color: #1A1A1A;
  background: rgba(255,255,255,.7);
  outline: none;
  transition: border-color .2s, box-shadow .2s, background .2s;
}
input:focus {
  border-color: rgba(0,0,0,.3);
  background: rgba(255,255,255,.95);
  box-shadow: 0 0 0 3px rgba(0,0,0,.05);
}
input::placeholder { color: #C0C0C0; }

.error { font-size: 12px; color: #C0607A; margin-top: 5px; display: block; }

.extras {
  display: flex; justify-content: space-between; align-items: center;
  margin: 4px 0 26px;
}
.remember {
  display: flex; align-items: center; gap: 7px;
  font-size: 13px; color: #9A9A9A; cursor: pointer; font-weight: 300;
}
.remember input[type=checkbox] {
  width: auto; padding: 0; border: none;
  box-shadow: none; background: none;
  accent-color: #1A1A1A;
}
.forgot {
  font-size: 13px; font-weight: 400;
  color: #4A4A4A; text-decoration: none;
  transition: color .2s;
  border-bottom: 1px solid #E0E0E0;
  padding-bottom: 1px;
}
.forgot:hover { color: #1A1A1A; border-color: #1A1A1A; }

.btn {
  width: 100%; padding: 14px;
  background: #1A1A1A; color: white;
  border: none; border-radius: 50px;
  font-size: 14px; font-weight: 500;
  font-family: 'Inter', sans-serif; cursor: pointer;
  display: flex; align-items: center; justify-content: center; gap: 8px;
  transition: opacity .2s, transform .15s, box-shadow .2s;
  letter-spacing: .3px;
  box-shadow: 0 4px 20px rgba(0,0,0,.15);
}
.btn:hover { opacity:.82; transform:translateY(-2px); box-shadow:0 10px 28px rgba(0,0,0,.2); }
.btn .arr { font-size: 16px; transition: transform .2s; }
.btn:hover .arr { transform: translateX(4px); }

.divider {
  display: flex; align-items: center; gap: 12px;
  margin: 22px 0;
  font-size: 12px; color: #C0C0C0;
}
.divider::before, .divider::after { content:''; flex:1; height:1px; background:#E8E8E8; }

.bottom {
  text-align: center;
  font-size: 13px; color: #9A9A9A; font-weight: 300;
}
.bottom a {
  color: #1A1A1A; font-weight: 500; text-decoration: none;
  border-bottom: 1.5px solid #E0E0E0; padding-bottom: 1px;
  transition: border-color .2s;
}
.bottom a:hover { border-color: #1A1A1A; }

@media (max-width: 640px) {
  .card { width: 90vw; padding: 40px 28px; }
  .bg-books { display: none; }
  .site-logo { top: 24px; left: 24px; }
}
</style>
</head>
<body>

<div class="bg">
  <div class="orb orb-1"></div>
  <div class="orb orb-2"></div>
  <div class="orb orb-3"></div>
  <div class="bg-books">
    <div class="bk b1"><div class="bk-face"><span class="bk-g">Sastra</span><div><div class="bk-t">Bumi Manusia</div><div class="bk-a">Pramoedya A.T.</div></div></div></div>
    <div class="bk b2"><div class="bk-face"><span class="bk-g">Fiksi</span><div><div class="bk-t">Laskar Pelangi</div><div class="bk-a">Andrea Hirata</div></div></div></div>
    <div class="bk b3"><div class="bk-face"><span class="bk-g">Sains</span><div><div class="bk-t">Sapiens</div><div class="bk-a">Y.N. Harari</div></div></div></div>
    <div class="bk b4"><div class="bk-face"><span class="bk-g">Filosofi</span><div><div class="bk-t">Dunia Sophie</div><div class="bk-a">J. Gaarder</div></div></div></div>
  </div>
</div>

<div class="site-logo">
  <div class="logo-box">
    <svg viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg>
  </div>
  <span class="logo-name">PerpusKita</span>
</div>

<div class="card">
  <div class="form-eyebrow">Masuk ke akun</div>
  <h1 class="form-title">Selamat <em>datang</em> 👋</h1>

  <form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="field">
      <label for="email">Email</label>
      <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="nama@gmail.com" autocomplete="username">
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
    <button type="submit" class="btn">Masuk <span class="arr">→</span></button>
  </form>

  <div class="divider">atau</div>
  <div class="bottom">
    Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
  </div>
</div>

</body>
</html>