@extends('layouts.main')

@section('main-content')

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400;1,700&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
  --white:  #FFFFFF;
  --bg:     #FAFAFA;
  --pink:   #F2C4CE;
  --blue:   #C4D9F2;
  --green:  #C4F2DE;
  --ink:    #1A1A1A;
  --sub:    #9A9A9A;
  --line:   #EBEBEB;
}

.root {
  font-family: 'Inter', sans-serif;
  background: var(--white);
  color: var(--ink);
  min-height: 100vh;
}

/* ══ HERO ══ */
.hero {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 120px 5vw 100px;
  text-align: center;
  position: relative;
  overflow: hidden;
  gap: 0;
}

.blob {
  position: absolute;
  border-radius: 50%;
  filter: blur(80px);
  pointer-events: none;
  opacity: .5;
}
.blob-1 { width:400px; height:400px; background:var(--pink);  top:-100px; left:-80px; }
.blob-2 { width:340px; height:340px; background:var(--blue);  top:40px;   right:-80px; }
.blob-3 { width:300px; height:300px; background:var(--green); bottom:-40px; left:35%; }

/* eyebrow */
.eyebrow {
  font-size: 10.5px; letter-spacing: 3px; text-transform: uppercase;
  font-weight: 500; color: var(--sub);
  margin-bottom: 22px; position: relative; z-index: 1;
  opacity: 0; animation: up .5s .08s forwards;
}

/* heading */
.heading {
  font-family: 'Playfair Display', serif;
  font-size: clamp(50px, 7vw, 98px);
  font-weight: 400;
  line-height: 1.06;
  letter-spacing: -2px;
  color: var(--ink);
  margin-bottom: 32px;
  position: relative; z-index: 1;
  opacity: 0; animation: up .65s .2s forwards;
}
.heading em { font-style: italic; }
.heading .hl {
  position: relative; display: inline-block;
}
.heading .hl::after {
  content: '';
  position: absolute; left: 0; bottom: 6px;
  width: 100%; height: 11px;
  background: var(--pink);
  z-index: -1; border-radius: 2px;
}

/* search */
.search-wrap {
  width: 100%; max-width: 480px;
  position: relative; z-index: 1;
  margin-bottom: 16px;
  opacity: 0; animation: up .65s .35s forwards;
}
.search-bar {
  display: flex; align-items: center;
  background: var(--white);
  border: 1.5px solid var(--line);
  border-radius: 50px;
  padding: 5px 5px 5px 20px;
  box-shadow: 0 4px 24px rgba(0,0,0,.06);
  transition: border-color .2s, box-shadow .2s;
}
.search-bar:focus-within {
  border-color: #C8C8C8;
  box-shadow: 0 6px 32px rgba(0,0,0,.09);
}
.search-bar input {
  flex: 1; border: none; outline: none; background: none;
  font-family: 'Inter', sans-serif;
  font-size: 13.5px; font-weight: 300; color: var(--ink);
}
.search-bar input::placeholder { color: #C8C8C8; }
.search-btn {
  background: var(--ink); color: var(--white);
  font-family: 'Inter', sans-serif;
  font-size: 12.5px; font-weight: 500;
  padding: 11px 22px; border-radius: 40px; border: none; cursor: pointer;
  transition: opacity .2s;
  white-space: nowrap; flex-shrink: 0;
}
.search-btn:hover { opacity: .75; }

/* tags */
.tags {
  display: flex; align-items: center; gap: 7px; flex-wrap: wrap;
  justify-content: center;
  position: relative; z-index: 1;
  margin-bottom: 64px;
  opacity: 0; animation: up .65s .45s forwards;
}
.tg {
  font-size: 11.5px; font-weight: 400; color: var(--sub);
  background: none; border: 1.5px solid var(--line);
  border-radius: 40px; padding: 5px 14px; cursor: pointer;
  transition: all .18s; font-family: 'Inter', sans-serif;
}
.tg:hover { border-color: var(--ink); color: var(--ink); }

/* ── FAN ── */
.fan-section {
  position: relative; z-index: 1;
  display: flex; flex-direction: column; align-items: center;
  opacity: 0; animation: up .7s .55s forwards;
}
.fan-label {
  font-size: 10px; letter-spacing: 2px; text-transform: uppercase;
  color: #C8C8C8; margin-bottom: 24px;
}
.fan {
  display: flex; align-items: flex-end;
  justify-content: center;
  height: 200px;
}
.bk {
  width: 112px; height: 164px;
  border-radius: 3px 9px 9px 3px;
  overflow: hidden; cursor: pointer; flex-shrink: 0;
  transition: transform .4s cubic-bezier(.22,.8,.22,1), box-shadow .4s;
  position: relative; margin: 0 -5px;
}
.bk::before {
  content: ''; position: absolute; left:0; top:0;
  width: 8px; height: 100%;
  background: rgba(0,0,0,.14); z-index: 2;
  border-radius: 3px 0 0 3px;
}
.bk::after {
  content: ''; position: absolute; inset: 0;
  background: linear-gradient(125deg,rgba(255,255,255,.13) 0%,transparent 50%);
  z-index: 3; pointer-events: none;
}
.bk:nth-child(1) { transform:rotate(-10deg) translateY(18px); z-index:1; box-shadow:3px 8px 22px rgba(0,0,0,.12); }
.bk:nth-child(2) { transform:rotate(-5deg)  translateY(7px);  z-index:2; box-shadow:4px 10px 26px rgba(0,0,0,.13); }
.bk:nth-child(3) { transform:rotate(0deg)   translateY(0);    z-index:5; box-shadow:6px 16px 44px rgba(0,0,0,.17); }
.bk:nth-child(4) { transform:rotate(5deg)   translateY(7px);  z-index:2; box-shadow:4px 10px 26px rgba(0,0,0,.13); }
.bk:nth-child(5) { transform:rotate(10deg)  translateY(18px); z-index:1; box-shadow:3px 8px 22px rgba(0,0,0,.12); }
.bk:hover {
  transform:rotate(0deg) translateY(-14px) scale(1.04) !important;
  z-index:10 !important; box-shadow:8px 24px 56px rgba(0,0,0,.2) !important;
}
.bf { width:100%; height:100%; padding:16px 12px 14px 16px; display:flex; flex-direction:column; justify-content:space-between; }
.bg { font-size:8px; letter-spacing:2px; text-transform:uppercase; color:rgba(255,255,255,.4); font-weight:500; }
.bt { font-family:'Playfair Display',serif; font-size:13.5px; font-style:italic; line-height:1.3; color:rgba(255,255,255,.9); margin-top:auto; }
.ba { font-size:8.5px; color:rgba(255,255,255,.35); margin-top:4px; }
.k1 { background:linear-gradient(150deg,#5C4B6B,#2E2438); }
.k2 { background:linear-gradient(150deg,#4B5C6B,#24303E); }
.k3 { background:linear-gradient(150deg,#4B6B58,#243824); }
.k4 { background:linear-gradient(150deg,#6B4B58,#382432); }
.k5 { background:linear-gradient(150deg,#6B5C4B,#382E24); }

/* ── STATS ── */
.stats-row {
  display: flex; align-items: center;
  margin-top: 56px;
  border: 1.5px solid var(--line);
  border-radius: 16px; overflow: hidden;
  background: var(--white);
  position: relative; z-index: 1;
  opacity: 0; animation: up .6s .7s forwards;
}
.st {
  flex: 1; padding: 20px 28px;
  display: flex; flex-direction: column; align-items: center; gap: 4px;
}
.st + .st { border-left: 1.5px solid var(--line); }
.sn { font-family:'Playfair Display',serif; font-size:26px; font-weight:700; color:var(--ink); line-height:1; }
.sl { font-size:10px; text-transform:uppercase; letter-spacing:2px; color:var(--sub); }

/* ── HOW ── */
.how {
  padding: 80px 5vw 90px;
  background: var(--bg);
  display: flex; flex-direction: column; align-items: center;
}
.how-title {
  font-family: 'Playfair Display', serif;
  font-size: clamp(28px, 3vw, 42px);
  font-weight: 400; letter-spacing: -.5px;
  color: var(--ink); margin-bottom: 52px;
  text-align: center;
}
.how-title em { font-style: italic; }

.steps {
  display: grid; grid-template-columns: repeat(3,1fr);
  gap: 20px; max-width: 820px; width: 100%;
}
.step {
  background: var(--white);
  border: 1.5px solid var(--line);
  border-radius: 18px; padding: 32px 26px;
  transition: transform .2s, box-shadow .2s;
}
.step:hover { transform: translateY(-4px); box-shadow: 0 12px 36px rgba(0,0,0,.06); }
.step-ico {
  width: 42px; height: 42px; border-radius: 12px;
  display: flex; align-items: center; justify-content: center;
  font-size: 18px; margin-bottom: 20px;
}
.ic-p { background: #FDE8EC; }
.ic-b { background: #E4EDFB; }
.ic-g { background: #DFF7EE; }
.step-n {
  font-family: 'Playfair Display', serif;
  font-size: 11px; font-weight: 400; color: var(--sub);
  letter-spacing: 1.5px; text-transform: uppercase;
  margin-bottom: 8px;
}
.step-t {
  font-family: 'Playfair Display', serif;
  font-size: 17px; font-weight: 400; color: var(--ink);
  line-height: 1.3;
}

@keyframes up {
  from { opacity:0; transform:translateY(18px); }
  to   { opacity:1; transform:translateY(0); }
}

@media (max-width:680px) {
  .steps { grid-template-columns:1fr; }
  .heading { font-size:44px; letter-spacing:-1px; }
  .bk { width:88px; height:128px; }
  .fan { height:162px; }
}
</style>

<div class="root">

  <section class="hero">
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>

    <div class="eyebrow">Peminjaman Buku Online</div>

    <h1 class="heading">
      Pinjam buku,<br><em><span class="hl">tanpa repot</span></em>
    </h1>

    <div class="search-wrap">
      <div class="search-bar">
        <input type="text" placeholder="Judul, penulis, atau genre...">
        <button class="search-btn">Cari →</button>
      </div>
    </div>

    <div class="tags">
      <button class="tg">Fiksi</button>
      <button class="tg">Sastra</button>
      <button class="tg">Sains</button>
      <button class="tg">Sejarah</button>
      <button class="tg">Filsafat</button>
    </div>

    <div class="fan-section">
      <div class="fan-label">Tersedia untuk dipinjam</div>
      <div class="fan">
        <div class="bk"><div class="bf k1"><span class="bg">Sastra</span><div><div class="bt">Bumi Manusia</div><div class="ba">Pramoedya A. Toer</div></div></div></div>
        <div class="bk"><div class="bf k2"><span class="bg">Filosofi</span><div><div class="bt">Dunia Sophie</div><div class="ba">Jostein Gaarder</div></div></div></div>
        <div class="bk"><div class="bf k3"><span class="bg">Fiksi</span><div><div class="bt">Laskar Pelangi</div><div class="ba">Andrea Hirata</div></div></div></div>
        <div class="bk"><div class="bf k4"><span class="bg">Sejarah</span><div><div class="bt">Pulau Run</div><div class="ba">Giles Milton</div></div></div></div>
        <div class="bk"><div class="bf k5"><span class="bg">Sains</span><div><div class="bt">Sapiens</div><div class="ba">Yuval N. Harari</div></div></div></div>
      </div>
    </div>

    <div class="stats-row">
      <div class="st"><div class="sn">12K+</div><div class="sl">Koleksi</div></div>
      <div class="st"><div class="sn">48</div><div class="sl">Genre</div></div>
      <div class="st"><div class="sn">6.2K</div><div class="sl">Peminjam</div></div>
    </div>
  </section>

  <section class="how">
    <h2 class="how-title"><em>Tiga langkah</em> mudah</h2>
    <div class="steps">
      <div class="step">
        <div class="step-ico ic-p">🔍</div>
        <div class="step-n">01 — Cari</div>
        <div class="step-t">Temukan buku dari ribuan koleksi</div>
      </div>
      <div class="step">
        <div class="step-ico ic-b">📋</div>
        <div class="step-n">02 — Pinjam</div>
        <div class="step-t">Ajukan peminjaman dalam satu klik</div>
      </div>
      <div class="step">
        <div class="step-ico ic-g">↩️</div>
        <div class="step-n">03 — Kembalikan</div>
        <div class="step-t">Kami ingatkan sebelum jatuh tempo</div>
      </div>
    </div>
  </section>

</div>

@endsection