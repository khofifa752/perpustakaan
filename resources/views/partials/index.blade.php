@extends('layouts.main')

@section('main-content')

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title></title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --cream: #F7F3ED;
    --dark: #1A1410;
    --brown: #6B4C2A;
    --orange: #E8782A;
    --navy: #1E2B4A;
    --text-muted: #8A7968;
    --card-bg: #FFFFFF;
  }

  html { scroll-behavior: smooth; }

  body {
    font-family: 'DM Sans', sans-serif;
    background: var(--cream);
    color: var(--dark);
    overflow-x: hidden;
  }

  /* ── HERO ── */
  .hero {
    min-height: 100vh;
    display: grid;
    grid-template-columns: 1fr 1fr;
    align-items: center;
    padding: 100px 80px 80px;
    gap: 60px;
    position: relative;
  }

  .hero::before {
    content: '';
    position: absolute;
    top: 0; right: 0;
    width: 45%;
    height: 100%;
    background: linear-gradient(135deg, #ffffff 0%, #faf9fd 100%);
    z-index: 0;
    clip-path: polygon(8% 0, 100% 0, 100% 100%, 0% 100%);
  }

  .hero-text { position: relative; z-index: 1; }

  .hero-eyebrow {
    font-size: 12px;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: var(--orange);
    font-weight: 500;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .hero-eyebrow::before {
    content: '';
    width: 30px; height: 1px;
    background: var(--orange);
  }

  .hero-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(42px, 5vw, 72px);
    line-height: 1.1;
    color: var(--dark);
    margin-bottom: 16px;
  }

  .hero-title em {
    font-style: italic;
    color: var(--brown);
  }

  .hero-desc {
    font-size: 15px;
    line-height: 1.8;
    color: var(--text-muted);
    max-width: 420px;
    margin-bottom: 40px;
  }

  .hero-cta {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: var(--orange);
    color: white;
    font-family: 'DM Sans', sans-serif;
    font-size: 14px;
    font-weight: 500;
    padding: 14px 28px;
    border-radius: 50px;
    text-decoration: none;
    transition: transform 0.2s, box-shadow 0.2s;
    cursor: pointer;
    border: none;
  }
  .hero-cta:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(232,120,42,0.35);
  }
  .hero-cta-secondary {
    background: transparent;
    color: var(--dark);
    border: 1.5px solid rgba(26,20,16,0.2);
    margin-left: 14px;
  }
  .hero-cta-secondary:hover {
    box-shadow: 0 8px 24px rgba(0,0,0,0.1);
  }

  .hero-visual { position: relative; z-index: 1; }

  /* Book carousel */
  .book-carousel {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0;
    height: 400px;
    perspective: 1200px;
    position: relative;
  }

  .book-card {
    width: 160px;
    height: 240px;
    border-radius: 12px;
    overflow: hidden;
    position: relative;
    flex-shrink: 0;
    transition: transform 0.4s ease, box-shadow 0.4s ease;
    cursor: pointer;
  }

  .book-card:nth-child(1) { transform: translateX(60px) rotateY(-20deg) scale(0.82); z-index: 1; }
.book-card:nth-child(2) { transform: translateX(30px) rotateY(-10deg) scale(0.91); z-index: 2; }
.book-card:nth-child(3) { transform: translateX(0) rotateY(0deg) scale(1); z-index: 5; box-shadow: 0 30px 80px rgba(0,0,0,0.25); }
.book-card:nth-child(4) { transform: translateX(-30px) rotateY(10deg) scale(0.91); z-index: 2; }
.book-card:nth-child(5) { transform: translateX(-60px) rotateY(20deg) scale(0.82); z-index: 1; }

  .book-card:hover { transform: translateY(-8px) scale(1.02) !important; z-index: 10 !important; box-shadow: 0 40px 80px rgba(0,0,0,0.3) !important; }

  .book-placeholder {
    width: 100%; height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 12px;
    font-size: 12px;
    font-weight: 500;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: rgba(255,255,255,0.7);
    border-radius: 12px;
  }

  .book-placeholder .book-icon {
    font-size: 32px;
    opacity: 0.6;
  }

  .bc1 { background: linear-gradient(160deg, #2C3E6B 0%, #1A2544 100%); }
  .bc2 { background: linear-gradient(160deg, #5C3317 0%, #3A1F0D 100%); }
  .bc3 { background: linear-gradient(160deg, #1A3A2A 0%, #0D2018 100%); }
  .bc4 { background: linear-gradient(160deg, #4A1A2A 0%, #2D0F19 100%); }
  .bc5 { background: linear-gradient(160deg, #2A2A4A 0%, #161625 100%); }

  .carousel-label {
    text-align: center;
    margin-top: 32px;
    position: relative; z-index: 2;
  }
  .carousel-label h3 {
    font-family: 'Playfair Display', serif;
    font-size: 18px;
    color: var(--dark);
  }
  .carousel-label p {
    font-size: 13px;
    color: var(--text-muted);
    margin-top: 4px;
  }

  .carousel-controls {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 20px;
  }
  .ctrl-btn {
    width: 38px; height: 38px;
    border-radius: 50%;
    border: 1.5px solid rgba(26,20,16,0.2);
    background: transparent;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    font-size: 16px;
    transition: all 0.2s;
    color: var(--dark);
  }
  .ctrl-btn.active {
    background: var(--orange);
    border-color: var(--orange);
    color: white;
  }
  .ctrl-btn:hover {
    background: var(--orange);
    border-color: var(--orange);
    color: white;
  }

  /* ── ABOUT ── */
  .about-section {
    padding: 100px 80px;
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 80px;
    align-items: center;
    background: var(--cream);
  }

  .section-label {
    font-family: 'Playfair Display', serif;
    font-size: 38px;
    line-height: 1.1;
    color: var(--dark);
  }
  .section-label em {
    font-style: italic;
    color: var(--orange);
    display: block;
  }

  .about-text strong {
    font-family: 'Playfair Display', serif;
    font-size: 18px;
    font-weight: 400;
    line-height: 1.7;
    color: var(--dark);
    display: block;
    margin-bottom: 14px;
  }
</style>
</head>
<body>

<!-- HERO -->
<section class="hero">
  <div class="hero-text">
    <div class="hero-eyebrow">Koleksi Digital</div>
    <h1 class="hero-title">
      Jelajahi dunia<br>
      melalui <em>koleksi buku</em><br>
      kami
    </h1>
    <p class="hero-desc">
      Temukan ribuan judul pilihan dari berbagai genre — sastra, sains, sejarah, 
      hingga fiksi — tersedia dalam satu platform perpustakaan digital.
    </p>
    <div>
      <button class="hero-cta">Jelajahi Koleksi →</button>
      <button class="hero-cta hero-cta-secondary">Tentang Kami</button>
    </div>
  </div>

  <div class="hero-visual">
    <div class="book-carousel">
      <div class="book-card">
        <div class="book-placeholder bc1">
          <span class="book-icon">📚</span>
        </div>
      </div>
      <div class="book-card">
        <div class="book-placeholder bc2">
          <span class="book-icon">📖</span>
        </div>
      </div>
      <div class="book-card">
        <div class="book-placeholder bc3">
          <span class="book-icon">📕</span>
        </div>
      </div>
      <div class="book-card">
        <div class="book-placeholder bc4">
          <span class="book-icon">📗</span>
        </div>
      </div>
      <div class="book-card">
        <div class="book-placeholder bc5">
          <span class="book-icon">📘</span>
        </div>
      </div>
    </div>
    <div class="carousel-label">
      <h3>Koleksi Pilihan</h3>
      <p>Kurator Perpustakaan</p>
    </div>
    <div class="carousel-controls">
      <button class="ctrl-btn">←</button>
      <button class="ctrl-btn active">→</button>
    </div>
  </div>
</section>

<!-- ABOUT -->
<!-- <section class="about-section">
  <div>
    <div class="section-label">
      Tentang<br>
      <em>perpustakaan</em>
    </div>
  </div> -->
  <!-- <div class="about-text">
    <strong>Selamat datang di Pustaka, tempat pengetahuan dan imajinasi bertemu. Kami menghadirkan koleksi beragam — dari klasik abadi hingga karya kontemporer terkini,
       menghubungkan pembaca dan penulis melalui pengalaman membaca yang menginspirasi.</strong> -->

@endsection