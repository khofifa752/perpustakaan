<style>
  .custom-navbar{
    background: transparent !important;
    padding: 1rem 0;
    position: fixed;
    top: 0; left: 0;
    width: 100%;
    z-index: 99999; 
    transition: all .3s ease;
  }
  .custom-navbar.scrolled{
    background: rgba(240,242,245,.95) !important;
    backdrop-filter: blur(10px);
    box-shadow: 0 4px 20px rgba(0,0,0,.08);
  }

  
  .nav-wrap{
    display: flex;
    justify-content: flex-end;
    width: 100%;
  }

  .navbar-nav{
    display: flex;               
    flex-direction: row;
    align-items: center;
    background: #fff;
    padding: .5rem;
    border-radius: 50px;
    box-shadow: 0 20px 20px rgba(0,0,0,.1);
    gap: .3rem;
    margin: 0;
    list-style: none;
  }

  .navbar-nav .nav-link,
  .navbar-nav button.nav-link{
    padding: .75rem 1.5rem;
    border-radius: 50px;
    color: #5f6368;
    font-weight: 500;
    font-size: .95rem;
    transition: all .3s ease;
    white-space: nowrap;
    display: flex;
    align-items: center;
    gap: .5rem;
    text-decoration: none;
    border: 0;
    background: transparent;
    cursor: pointer;
  }

  .navbar-nav .nav-link:hover,
  .navbar-nav button.nav-link:hover{
    background: #f1f3f4;
    color: #202124;
  }

  .navbar-nav .nav-link.active{
    background: #3b82f6;
    color: #fff;
    box-shadow: 0 4px 12px rgba(59,130,246,.3);
  }

  body { padding-top: 80px; }

  @media (max-width: 991px){
    .custom-navbar{ background: rgba(240,242,245,.95) !important; }

    .navbar-nav{
      flex-direction: column;
      align-items: stretch;
      border-radius: 20px;
      padding: .8rem;
      gap: .5rem;
    }

    .navbar-nav .nav-link,
    .navbar-nav button.nav-link{
      justify-content: flex-start;
      padding: .6rem 1rem;
    }
  }
</style>

<nav class="custom-navbar" id="mainNavbar">
  <div style="display:flex; align-items:center; gap:12px; padding:0 16px;">
    <a class="navbar-brand" href="/" style="font-weight:700; color:#202124; font-size:1.3rem; text-decoration:none;">
      📚 Perpustakaan
    </a>

    <div class="nav-wrap">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="/">🏠 Beranda</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('books*') ? 'active' : '' }}" href="/books">📚 Koleksi</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('booking*') ? 'active' : '' }}" href="/booking">👥 Riwayat</a>
        </li>

       @auth
  <li class="nav-item">
    <a class="nav-link {{ Request::is('collections*') ? 'active' : '' }}" href="{{ route('collections.index') }}">
      🔖 Koleksi Saya
      @php $koleksiCount = auth()->user()->collections()->count(); @endphp
      @if($koleksiCount > 0)
        <span style="
          background:#e74c3c;
          color:#fff;
          font-size:10px;
          font-weight:700;
          border-radius:999px;
          padding:1px 7px;
          line-height:16px;
        ">{{ $koleksiCount }}</span>
      @endif
    </a>
  </li>
  <li class="nav-item">
    <form method="POST" action="{{ route('logout') }}" style="margin:0;">
      @csrf
      <button type="submit" class="nav-link">🚪 Logout</button>
    </form>
  </li>
@endauth

      </ul>
    </div>
  </div>
</nav>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const navbar = document.getElementById('mainNavbar');
    window.addEventListener('scroll', function () {
      if (window.scrollY > 50) navbar.classList.add('scrolled');
      else navbar.classList.remove('scrolled');
    });
  });
</script>
