<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — AnimeStreamer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { background: #070713; }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50%       { transform: translateY(-12px); }
        }
        .float { animation: float 4s ease-in-out infinite; }
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 30px 6px rgba(168,85,247,.25); }
            50%       { box-shadow: 0 0 60px 16px rgba(217,70,239,.45); }
        }
        .glow { animation: pulse-glow 3.5s ease-in-out infinite; }
    </style>
</head>
<body class="min-h-screen bg-[#070713] text-white flex items-center justify-center px-4">

    {{-- Background orbs --}}
    <div class="pointer-events-none fixed inset-0 overflow-hidden">
        <div class="absolute -top-40 -left-40 h-[520px] w-[520px] rounded-full bg-violet-600/15 blur-[120px]"></div>
        <div class="absolute -bottom-40 -right-40 h-[480px] w-[480px] rounded-full bg-fuchsia-600/15 blur-[120px]"></div>
        <div class="absolute top-1/2 left-1/2 h-[300px] w-[300px] -translate-x-1/2 -translate-y-1/2 rounded-full bg-violet-500/8 blur-[100px]"></div>
    </div>

    <div class="relative z-10 w-full max-w-md">

        {{-- Logo --}}
        <div class="mb-8 flex flex-col items-center gap-3 float">
            <div class="glow flex h-16 w-16 items-center justify-center rounded-3xl bg-gradient-to-br from-violet-500 to-fuchsia-500">
                <i data-lucide="film" class="h-8 w-8 text-white"></i>
            </div>
            <div class="text-center">
                <h1 class="text-2xl font-black text-white">AnimeStreamer</h1>
                <p class="mt-1 text-sm text-slate-400">Admin Dashboard Login</p>
            </div>
        </div>

        {{-- Card --}}
        <div class="rounded-3xl border border-white/10 bg-white/[0.04] p-8 shadow-2xl backdrop-blur-xl">

            <h2 class="text-xl font-black text-white">Welcome back</h2>
            <p class="mt-1 text-sm text-slate-400">Sign in to manage your platform</p>

            {{-- Errors --}}
            @if ($errors->any())
                <div class="mt-4 rounded-2xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-400">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Session success --}}
            @if (session('success'))
                <div class="mt-4 rounded-2xl border border-green-500/30 bg-green-500/10 px-4 py-3 text-sm text-green-400">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}" class="mt-6 space-y-5">
                @csrf

                {{-- Email --}}
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-slate-300">Email Address</label>
                    <div class="relative">
                        <i data-lucide="mail" class="absolute left-3.5 top-1/2 h-4.5 w-4.5 -translate-y-1/2 text-slate-500 pointer-events-none" style="height:18px;width:18px;position:absolute;left:14px;top:50%;transform:translateY(-50%)"></i>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="admin@example.com"
                            autocomplete="email"
                            required
                            class="w-full rounded-2xl border border-white/10 bg-white/[0.06] py-3 pl-11 pr-4 text-white outline-none ring-0 placeholder:text-slate-500 focus:border-violet-500/60 focus:bg-white/[0.08] transition"
                        />
                    </div>
                </div>

                {{-- Password --}}
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-slate-300">Password</label>
                    <div class="relative">
                        <i data-lucide="lock" style="height:18px;width:18px;position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#64748b"></i>
                        <input
                            id="passwordInput"
                            type="password"
                            name="password"
                            placeholder="••••••••"
                            autocomplete="current-password"
                            required
                            class="w-full rounded-2xl border border-white/10 bg-white/[0.06] py-3 pl-11 pr-12 text-white outline-none ring-0 placeholder:text-slate-500 focus:border-violet-500/60 focus:bg-white/[0.08] transition"
                        />
                        <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-300">
                            <i data-lucide="eye" id="eyeIcon" style="height:18px;width:18px"></i>
                        </button>
                    </div>
                </div>

                {{-- Remember --}}
                <div class="flex items-center gap-2">
                    <input
                        type="checkbox"
                        name="remember"
                        id="remember"
                        class="h-4 w-4 rounded border-white/20 bg-white/10 accent-violet-500"
                    />
                    <label for="remember" class="text-sm text-slate-400 cursor-pointer">Remember me</label>
                </div>

                {{-- Submit --}}
                <button
                    type="submit"
                    class="w-full rounded-2xl bg-gradient-to-r from-violet-500 to-fuchsia-500 py-3.5 text-base font-bold text-white shadow-lg shadow-fuchsia-500/25 hover:opacity-90 transition flex items-center justify-center gap-2"
                >
                    <i data-lucide="log-in" style="height:18px;width:18px"></i>
                    Sign In
                </button>
            </form>
        </div>

        {{-- Back to site --}}
        <div class="mt-5 text-center">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-300 transition">
                <i data-lucide="arrow-left" style="height:14px;width:14px"></i>
                Back to site
            </a>
        </div>
    </div>

    <script>
        lucide.createIcons();

        function togglePassword() {
            const input = document.getElementById('passwordInput');
            const icon  = document.getElementById('eyeIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.setAttribute('data-lucide', 'eye-off');
            } else {
                input.type = 'password';
                icon.setAttribute('data-lucide', 'eye');
            }
            lucide.createIcons();
        }
    </script>
</body>
</html>
