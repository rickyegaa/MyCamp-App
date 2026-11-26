<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — MyCamp Outdoor Gear Rental</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#f7f3ee] text-[#1f1a16] flex items-center justify-center px-4 py-8 antialiased" style="font-family: 'Plus Jakarta Sans', sans-serif;">

    <div class="w-full max-w-[460px] bg-white border border-[#e6dfd5] rounded-2xl px-6 py-9 sm:px-10 sm:py-11 shadow-[0_12px_32px_rgba(74,53,25,0.05)]">
        <div class="text-center mb-7">
            <img src="{{ asset('images/logo-mycamp.png') }}" alt="Logo MyCamp"
                class="h-16 w-auto mx-auto mb-3 object-contain">

            <p class="text-[11px] font-bold tracking-[0.14em] uppercase text-[#8c7a6b] mb-2">
                TEMAN PETUALANGANMU
            </p>
            <h1 class="text-2xl sm:text-[26px] font-bold tracking-tight text-[#1f1a16]">
                Selamat datang kembali.
            </h1>
            <p class="text-sm text-[#78716c] mt-1">
                Pilih akunmu untuk melanjutkan.
            </p>
        </div>

        <div class="grid grid-cols-2 gap-1.5 bg-[#f2ece4] p-1.5 rounded-xl mb-4" role="tablist">
            <button type="button" id="tabKasir"
                class="flex items-center justify-center gap-2 py-2.5 px-3 rounded-lg text-sm font-semibold bg-white text-[#1f1a16] shadow-sm transition cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                </svg>
                <span>Login Kasir</span>
            </button>
            <button type="button" id="tabAdmin"
                class="flex items-center justify-center gap-2 py-2.5 px-3 rounded-lg text-sm font-semibold text-[#78716c] hover:text-[#1f1a16] transition cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/>
                </svg>
                <span>Login Admin</span>
            </button>
        </div>

        <p id="roleDescription" class="text-[13px] text-[#6e655f] leading-relaxed mb-6">
            Catat biodata penyewa, kelola jaminan identitas, dan proses transaksi sewa.
        </p>

        <form action="{{ route('login.proses') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="login_role" id="login_role" value="kasir">
            <div>
                <label for="email" class="block text-sm font-semibold text-[#1f1a16] mb-1.5">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                    placeholder="Email" required autofocus
                    class="w-full rounded-xl border border-[#e6dfd5] bg-white px-4 py-3 text-sm text-[#1f1a16] placeholder-[#a8a29e] focus:border-[#4a3519] focus:ring-2 focus:ring-[#4a3519]/15 focus:outline-none transition @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-[#1f1a16] mb-1.5">Password</label>
                <div class="relative">
                    <input type="password" name="password" id="password"
                        placeholder="Password" required
                        class="w-full rounded-xl border border-[#e6dfd5] bg-white px-4 py-3 pr-11 text-sm text-[#1f1a16] placeholder-[#a8a29e] focus:border-[#4a3519] focus:ring-2 focus:ring-[#4a3519]/15 focus:outline-none transition @error('password') border-red-500 @enderror">
                    <button type="button" id="togglePassword" aria-label="Lihat kata sandi"
                        class="absolute inset-y-0 right-3.5 flex items-center text-[#8c857e] hover:text-[#1f1a16] cursor-pointer">
                        <svg id="eyeOpen" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>
                        <svg id="eyeClosed" class="w-5 h-5 hidden" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88"/>
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center pt-1 pb-2">
                <input type="checkbox" name="remember" id="remember"
                    class="w-4 h-4 rounded border-[#d6cdc2] text-[#4a3519] focus:ring-[#4a3519]">
                <label for="remember" class="ml-2 text-sm text-[#6e655f] select-none cursor-pointer">
                    Ingat saya
                </label>
            </div>

            <button type="submit"
                class="w-full bg-[#4a3519] hover:bg-[#362611] active:scale-[0.99] text-white font-semibold text-sm py-3.5 px-5 rounded-xl flex items-center justify-center gap-2 transition cursor-pointer">
                <span id="submitText">Masuk Kasir</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                </svg>
            </button>
        </form>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const pwd = document.getElementById('password');
            const eyeOpen = document.getElementById('eyeOpen');
            const eyeClosed = document.getElementById('eyeClosed');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                pwd.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        });

        const tabKasir = document.getElementById('tabKasir');
        const tabAdmin = document.getElementById('tabAdmin');
        const roleDesc = document.getElementById('roleDescription');
        const emailInput = document.getElementById('email');
        const submitText = document.getElementById('submitText');
        const loginRoleInput = document.getElementById('login_role');

        const activeClasses = ['bg-white', 'text-[#1f1a16]', 'shadow-sm'];
        const inactiveClasses = ['text-[#78716c]', 'hover:text-[#1f1a16]'];

        tabKasir.addEventListener('click', function () {
            tabKasir.classList.add(...activeClasses);
            tabKasir.classList.remove(...inactiveClasses);
            tabAdmin.classList.remove(...activeClasses);
            tabAdmin.classList.add(...inactiveClasses);
            roleDesc.textContent = 'Catat biodata penyewa, kelola jaminan identitas, dan proses transaksi sewa.';
            emailInput.placeholder = 'Email';
            submitText.textContent = 'Masuk Kasir';
            loginRoleInput.value = 'kasir';
        });

        tabAdmin.addEventListener('click', function () {
            tabAdmin.classList.add(...activeClasses);
            tabAdmin.classList.remove(...inactiveClasses);
            tabKasir.classList.remove(...activeClasses);
            tabKasir.classList.add(...inactiveClasses);
            roleDesc.textContent = 'Kelola data penyewa, stok perlengkapan camping, dan pengaturan akun petugas.';
            emailInput.placeholder = 'Email';
            submitText.textContent = 'Masuk Admin';
            loginRoleInput.value = 'admin';
        });

        if (loginRoleInput.value === 'admin') {
            tabAdmin.click();
        }
    </script>
</body>
</html>