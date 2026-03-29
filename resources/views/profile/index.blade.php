@extends('layouts.main')

@section('style')
<style>
body { font-family: 'DM Sans', sans-serif; background: #f5f0e8; }
.profile-wrap { max-width: 680px; margin: 0 auto; padding: 2rem 1.5rem 5rem; }

.profile-header {
  background: #fff;
  border-radius: 20px;
  padding: 2rem;
  box-shadow: 0 2px 12px rgba(44,36,22,.07);
  display: flex;
  align-items: center;
  gap: 1.5rem;
  margin-bottom: 1.25rem;
}

.avatar-wrap { position: relative; flex-shrink: 0; }

.avatar-img {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  object-fit: cover;
  border: 3px solid #f0ebe0;
}

.avatar-placeholder {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  background: #f0ebe0;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 2rem;
  border: 3px solid #e8e1d4;
}

.avatar-edit-btn {
  position: absolute;
  bottom: 0;
  right: 0;
  width: 26px;
  height: 26px;
  border-radius: 50%;
  background: #2c2416;
  color: #fff;
  border: 2px solid #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 11px;
  cursor: pointer;
}

.profile-name { font-size: 1.2rem; font-weight: 700; color: #2c2416; margin-bottom: 2px; }
.profile-email { font-size: .85rem; color: #8a7a65; margin-bottom: .5rem; }
.profile-role { display: inline-block; background: #f0ebe0; color: #5a4a35; font-size: .72rem; font-weight: 600; padding: 3px 10px; border-radius: 999px; }

.stats-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: .75rem; margin-bottom: 1.25rem; }

.stat-card { background: #fff; border-radius: 14px; padding: 1rem; text-align: center; box-shadow: 0 2px 12px rgba(44,36,22,.06); }
.stat-num { font-size: 1.6rem; font-weight: 700; color: #2c2416; line-height: 1; margin-bottom: 4px; }
.stat-label { font-size: .72rem; color: #8a7a65; font-weight: 500; }

.form-card { background: #fff; border-radius: 20px; padding: 1.5rem; box-shadow: 0 2px 12px rgba(44,36,22,.06); }
.card-label { font-size: .68rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: #b0a090; margin-bottom: 1rem; padding-bottom: .5rem; border-bottom: 1px solid #f0ebe0; }

.form-group { margin-bottom: 1rem; }
.form-label { font-size: .82rem; font-weight: 600; color: #5a4a35; margin-bottom: 5px; display: block; }
.form-input { width: 100%; padding: 10px 14px; border: 1.5px solid #e8e1d4; border-radius: 10px; font-size: .875rem; color: #2c2416; background: #faf8f5; font-family: inherit; outline: none; transition: .2s; }
.form-input:focus { border-color: #8a7a65; background: #fff; }

.btn-save { display: inline-flex; align-items: center; gap: 8px; background: #2c2416; color: #f5f0e8; border: none; padding: 11px 28px; border-radius: 999px; font-size: .88rem; font-weight: 600; cursor: pointer; transition: .2s; }
.btn-save:hover { background: #8a6d45; }

.alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; border-radius: 12px; padding: 10px 14px; font-size: .85rem; margin-bottom: 1rem; }
.alert-error { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; border-radius: 12px; padding: 10px 14px; font-size: .85rem; margin-bottom: 1rem; }

.logout-btn { display: flex; align-items: center; gap: 8px; background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; padding: 10px 20px; border-radius: 999px; font-size: .85rem; font-weight: 600; cursor: pointer; transition: .2s; width: fit-content; margin-top: 1rem; }
.logout-btn:hover { background: #fee2e2; }

#avatarInput { display: none; }
</style>
@endsection

@section('main-content')
<div class="profile-wrap">

  {{-- ALERT --}}
  @if(session('success'))
    <div class="alert-success">✅ {{ session('success') }}</div>
  @endif
  @if($errors->any())
    <div class="alert-error">⚠️ {{ $errors->first() }}</div>
  @endif

  {{-- HEADER --}}
  <div class="profile-header">
    <div class="avatar-wrap">
      @if($user->avatar)
        <img src="{{ asset('storage/'.$user->avatar) }}" class="avatar-img" id="avatarPreview">
      @else
        <div class="avatar-placeholder" id="avatarPreview">👤</div>
      @endif
      <label for="avatarInput" class="avatar-edit-btn" title="Ganti foto">✏️</label>
    </div>
    <div>
      <div class="profile-name">{{ $user->name }}</div>
      <div class="profile-email">{{ $user->email }}</div>
      <span class="profile-role">{{ ucfirst($user->role) }}</span>
    </div>
  </div>

  {{-- STATISTIK --}}
  <div class="stats-row">
    <div class="stat-card">
      <div class="stat-num">{{ $totalPinjam }}</div>
      <div class="stat-label">Total Pinjam</div>
    </div>
    <div class="stat-card">
      <div class="stat-num">{{ $sedangDipinjam }}</div>
      <div class="stat-label">Sedang Dipinjam</div>
    </div>
    <div class="stat-card">
      <div class="stat-num">{{ $totalKoleksi }}</div>
      <div class="stat-label">Koleksi Tersimpan</div>
    </div>
  </div>

  {{-- FORM EDIT --}}
  <div class="form-card">
    <div class="card-label">Edit Profil</div>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <input type="file" name="avatar" id="avatarInput" accept="image/*">

      <div class="form-group">
        <label class="form-label">Nama</label>
        <input type="text" name="name" class="form-input" value="{{ old('name', $user->name) }}" required>
      </div>

      <div class="form-group">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" required>
      </div>

      <button type="submit" class="btn-save">💾 Simpan Perubahan</button>
    </form>

    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button type="submit" class="logout-btn">🚪 Logout</button>
    </form>
  </div>

</div>
@endsection

@section('script')
<script>
  document.getElementById('avatarInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(ev) {
      const wrap = document.querySelector('.avatar-wrap');
      let preview = document.getElementById('avatarPreview');
      if (preview.tagName === 'DIV') {
        const img = document.createElement('img');
        img.src = ev.target.result;
        img.className = 'avatar-img';
        img.id = 'avatarPreview';
        preview.replaceWith(img);
      } else {
        preview.src = ev.target.result;
      }
    };
    reader.readAsDataURL(file);
    // auto submit form saat avatar dipilih
    e.target.closest('form').submit();
  });
</script>
@endsection