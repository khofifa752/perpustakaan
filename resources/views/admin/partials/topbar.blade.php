<header class="bg-white shadow-sm border-b border-gray-200">
    <div class="flex items-center justify-between px-6 py-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Dashboard</h2>
            <p class="text-sm text-gray-500 mt-1">Selamat datang kembali, {{ auth()->user()->name }}!</p>
        </div>

        {{-- PROFILE TRIGGER --}}
        <div class="flex items-center space-x-3 cursor-pointer hover:bg-gray-50 rounded-xl px-3 py-2 transition"
             onclick="document.getElementById('profileModal').classList.remove('hidden')">
            @if(auth()->user()->avatar)
                <img src="{{ asset('storage/'.auth()->user()->avatar) }}"
                     alt="{{ auth()->user()->name }}"
                     class="w-10 h-10 rounded-full object-cover" id="topbarAvatar">
            @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=3b82f6&color=fff"
                     alt="{{ auth()->user()->name }}"
                     class="w-10 h-10 rounded-full" id="topbarAvatar">
            @endif
            <div>
                <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-500">{{ ucfirst(auth()->user()->role) }}</p>
            </div>
            <i class="fas fa-chevron-down text-xs text-gray-400 ml-1"></i>
        </div>
    </div>
</header>

{{-- PROFILE MODAL --}}
<div id="profileModal"
     class="hidden fixed inset-0 z-50 flex items-center justify-center"
     style="background:rgba(0,0,0,0.35);"
     onclick="if(event.target===this) this.classList.add('hidden')">

    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md mx-4 overflow-hidden">

        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800">Edit Profil</h3>
            <button onclick="document.getElementById('profileModal').classList.add('hidden')"
                    class="text-gray-400 hover:text-gray-600 transition">
                <i class="fas fa-times"></i>
            </button>
        </div>

        @if(session('profile_success'))
            <div class="mx-6 mt-4 bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 text-sm">
                ✅ {{ session('profile_success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="mx-6 mt-4 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-sm">
                ⚠️ {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="px-6 py-5">
            @csrf

            <div class="flex flex-col items-center mb-5">
                <div class="relative">
                    @if(auth()->user()->avatar)
                        <img src="{{ asset('storage/'.auth()->user()->avatar) }}"
                             class="w-20 h-20 rounded-full object-cover border-4 border-gray-100"
                             id="modalAvatarPreview">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=3b82f6&color=fff"
                             class="w-20 h-20 rounded-full border-4 border-gray-100"
                             id="modalAvatarPreview">
                    @endif
                    <label for="modalAvatarInput"
                           class="absolute bottom-0 right-0 w-7 h-7 bg-gray-800 text-white rounded-full flex items-center justify-center cursor-pointer border-2 border-white hover:bg-gray-600 transition">
                        <i class="fas fa-camera text-xs"></i>
                    </label>
                </div>
                <input type="file" name="avatar" id="modalAvatarInput" accept="image/*" class="hidden">
                <p class="text-xs text-gray-400 mt-2">Klik ikon kamera untuk ganti foto</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                <input type="text" name="name"
                       value="{{ old('name', auth()->user()->name) }}"
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-gray-400 bg-gray-50 focus:bg-white transition"
                       required>
            </div>

            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email"
                       value="{{ old('email', auth()->user()->email) }}"
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-gray-400 bg-gray-50 focus:bg-white transition"
                       required>
            </div>

            <div class="flex gap-3">
                <button type="button"
                        onclick="document.getElementById('profileModal').classList.add('hidden')"
                        class="flex-1 px-4 py-2.5 border border-gray-200 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 px-4 py-2.5 bg-gray-800 text-white rounded-xl text-sm font-medium hover:bg-gray-600 transition">
                    💾 Simpan
                </button>
            </div>
        </form>

    </div>
</div>

<script>
    document.getElementById('modalAvatarInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function(ev) {
            document.getElementById('modalAvatarPreview').src = ev.target.result;
        };
        reader.readAsDataURL(file);
    });

    @if($errors->any() || session('profile_success'))
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('profileModal').classList.remove('hidden');
        });
    @endif
</script>