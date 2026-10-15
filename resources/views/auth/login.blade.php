<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Administrativo | MikroHN SaaS</title>
    <meta name="description" content="Portal de inicio de sesión administrativo para la plataforma MikroHN SaaS.">

    <!-- Google Fonts: Inter & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        outfit: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#ecfeff',
                            100: '#cffafe',
                            400: '#22d3ee',
                            500: '#06b6d4',
                            600: '#0891b2',
                            700: '#0e7490',
                        },
                        indigoBrand: {
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                        },
                        darkBg: '#090D16',
                        darkCard: '#111827',
                        darkBorder: '#1F2937',
                    }
                }
            }
        }
    </script>
    <style>
        .glow-cyan {
            box-shadow: 0 0 35px -5px rgba(6, 182, 212, 0.35);
        }
        .glow-indigo {
            box-shadow: 0 0 40px -10px rgba(99, 102, 241, 0.4);
        }
        .gradient-text {
            background: linear-gradient(135deg, #22d3ee 0%, #818cf8 50%, #c084fc 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="h-full bg-[#090D16] text-slate-100 font-sans flex items-center justify-center p-4 relative overflow-x-hidden selection:bg-brand-500 selection:text-white">

    <!-- Elementos luminosos de fondo -->
    <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[400px] bg-brand-500/10 rounded-full blur-[140px] pointer-events-none"></div>
    <div class="absolute bottom-10 right-1/4 w-[400px] h-[300px] bg-indigoBrand-500/10 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10">

        <!-- Logo y Regreso -->
        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-3 group mb-4">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-brand-600 via-indigoBrand-500 to-cyan-400 flex items-center justify-center shadow-lg shadow-brand-500/25 group-hover:scale-105 transition-transform">
                    <i class="fa-solid fa-network-wired text-white text-2xl"></i>
                </div>
                <div class="text-left">
                    <span class="font-outfit font-extrabold text-2xl tracking-tight text-white flex items-center gap-2">
                        MikroHN <span class="text-xs font-semibold uppercase px-2 py-0.5 bg-brand-500/20 border border-brand-500/40 text-brand-400 rounded-full tracking-wider">SaaS</span>
                    </span>
                    <span class="text-xs block text-slate-400 font-medium">Control Administrativo Central</span>
                </div>
            </a>
            <h1 class="text-2xl font-bold font-outfit text-white tracking-tight">Iniciar Sesión</h1>
            <p class="text-sm text-slate-400 mt-1">Ingresa tus credenciales de superadministrador</p>
        </div>

        <!-- Tarjeta del Formulario -->
        <div class="bg-slate-900/80 border border-slate-800/90 rounded-2xl p-6 sm:p-8 backdrop-blur-xl shadow-2xl shadow-black/80 relative">
            <div class="absolute -top-px left-10 right-10 h-px bg-gradient-to-r from-transparent via-brand-500 to-transparent"></div>

            <!-- Notificación de Éxito / Info -->
            @if(session('success'))
                <div class="mb-5 p-3.5 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 text-xs flex items-center gap-2.5">
                    <i class="fa-solid fa-circle-check text-emerald-400 text-base"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Notificación de Errores -->
            @if ($errors->any())
                <div class="mb-5 p-3.5 rounded-xl bg-rose-500/10 border border-rose-500/30 text-rose-300 text-xs">
                    <div class="flex items-center gap-2 font-semibold mb-1">
                        <i class="fa-solid fa-circle-exclamation text-rose-400"></i>
                        <span>No se pudo iniciar sesión</span>
                    </div>
                    <ul class="list-disc list-inside space-y-0.5 text-slate-300">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Campo Usuario (REQUISITO ESTRICTO: USERNAME) -->
                <div>
                    <label for="username" class="block text-xs font-semibold text-slate-300 mb-1.5 flex items-center justify-between">
                        <span>Usuario <span class="text-brand-400">*</span></span>
                        <span class="text-[11px] text-slate-500 font-normal">Identificador único</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                            <i class="fa-solid fa-user text-sm"></i>
                        </div>
                        <input
                            type="text"
                            name="username"
                            id="username"
                            value="{{ old('username') }}"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="admin"
                            class="w-full bg-slate-950/80 border @error('username') border-rose-500/80 focus:border-rose-500 @else border-slate-800 focus:border-brand-500 @enderror rounded-xl pl-10 pr-4 py-3 text-sm text-white placeholder-slate-600 focus:outline-none focus:ring-1 focus:ring-brand-500 transition-all font-mono"
                        >
                    </div>
                    @error('username')
                        <p class="mt-1.5 text-xs text-rose-400 flex items-center gap-1">
                            <i class="fa-solid fa-triangle-exclamation text-[10px]"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Campo Contraseña -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-xs font-semibold text-slate-300">
                            Contraseña <span class="text-brand-400">*</span>
                        </label>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                            <i class="fa-solid fa-lock text-sm"></i>
                        </div>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            required
                            autocomplete="current-password"
                            placeholder="••••••••"
                            class="w-full bg-slate-950/80 border @error('password') border-rose-500/80 focus:border-rose-500 @else border-slate-800 focus:border-brand-500 @enderror rounded-xl pl-10 pr-10 py-3 text-sm text-white placeholder-slate-600 focus:outline-none focus:ring-1 focus:ring-brand-500 transition-all"
                        >
                        <button
                            type="button"
                            onclick="togglePassword()"
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-500 hover:text-slate-300 transition-colors"
                            tabindex="-1"
                        >
                            <i id="eye-icon" class="fa-solid fa-eye text-sm"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1.5 text-xs text-rose-400 flex items-center gap-1">
                            <i class="fa-solid fa-triangle-exclamation text-[10px]"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Recordar Sesión -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input
                            type="checkbox"
                            name="remember"
                            id="remember"
                            {{ old('remember') ? 'checked' : '' }}
                            class="w-4 h-4 rounded bg-slate-950 border-slate-700 text-brand-500 focus:ring-brand-500 focus:ring-offset-0 focus:ring-1 cursor-pointer"
                        >
                        <span class="text-xs text-slate-400 hover:text-slate-300">Recordar mi sesión</span>
                    </label>

                    <span class="text-[11px] text-slate-500">
                        <i class="fa-solid fa-shield-halved text-brand-400 mr-1"></i> SSL Protegido
                    </span>
                </div>

                <!-- Botón de Inicio de Sesión -->
                <button
                    type="submit"
                    class="w-full py-3.5 px-6 rounded-xl bg-gradient-to-r from-brand-500 via-cyan-500 to-indigoBrand-600 hover:from-brand-400 hover:via-cyan-400 hover:to-indigoBrand-500 font-semibold text-white text-sm shadow-xl shadow-brand-500/25 hover:shadow-cyan-400/40 hover:scale-[1.01] active:scale-[0.99] transition-all flex items-center justify-center gap-2 group cursor-pointer"
                >
                    <span>Ingresar al Panel SaaS</span>
                    <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                </button>
            </form>

            <!-- Credenciales por Defecto (Acceso Rápido) -->
            <div class="mt-6 pt-5 border-t border-slate-800/80">
                <div class="p-3 rounded-xl bg-slate-950/60 border border-slate-800 text-xs text-slate-400 flex items-center justify-between">
                    <div>
                        <p class="font-medium text-slate-300 flex items-center gap-1.5">
                            <i class="fa-solid fa-key text-brand-400"></i> Credenciales Iniciales:
                        </p>
                        <p class="text-[11px] text-slate-400 mt-0.5">
                            Usuario: <code class="text-brand-300 bg-slate-900 px-1.5 py-0.5 rounded font-mono">admin</code> |
                            Contraseña: <code class="text-brand-300 bg-slate-900 px-1.5 py-0.5 rounded font-mono">admin1234</code>
                        </p>
                    </div>
                    <button
                        type="button"
                        onclick="fillDemoCredentials()"
                        class="text-[11px] px-2.5 py-1.5 rounded-lg bg-brand-500/20 hover:bg-brand-500/30 text-brand-300 font-medium transition-colors cursor-pointer"
                        title="Auto-rellenar formulario"
                    >
                        Auto-llenar
                    </button>
                </div>
            </div>
        </div>

        <!-- Enlace para volver a la landing -->
        <div class="text-center mt-6">
            <a href="{{ url('/') }}" class="text-xs text-slate-400 hover:text-brand-400 transition-colors inline-flex items-center gap-1.5">
                <i class="fa-solid fa-arrow-left text-[10px]"></i>
                <span>Volver a la página principal de MikroHN</span>
            </a>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }

        function fillDemoCredentials() {
            document.getElementById('username').value = 'admin';
            document.getElementById('password').value = 'admin1234';
        }
    </script>
</body>
</html>
