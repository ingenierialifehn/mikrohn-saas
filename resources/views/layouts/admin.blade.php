<!DOCTYPE html>
<html lang="es" class="h-full bg-[#090D16]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel Administrativo') | MikroHN SaaS</title>

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
        .glass-panel {
            background: rgba(17, 24, 39, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(31, 41, 55, 0.7);
        }
        .glow-cyan {
            box-shadow: 0 0 30px -5px rgba(6, 182, 212, 0.3);
        }
        .glow-indigo {
            box-shadow: 0 0 35px -8px rgba(99, 102, 241, 0.35);
        }
        .gradient-text {
            background: linear-gradient(135deg, #22d3ee 0%, #818cf8 50%, #c084fc 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
    @stack('styles')
</head>
<body class="h-full bg-[#090D16] text-slate-100 font-sans antialiased overflow-x-hidden flex">

    <!-- Backdrop Móvil para Sidebar -->
    <div id="sidebar-backdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-black/70 z-40 lg:hidden hidden backdrop-blur-sm transition-opacity"></div>

    <!-- Sidebar Principal -->
    <aside id="admin-sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-[#0B101B] border-r border-slate-800/80 flex flex-col transition-transform duration-300 -translate-x-full lg:translate-x-0">
        <!-- Brand Header -->
        <div class="h-20 px-6 flex items-center justify-between border-b border-slate-800/80">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-brand-600 via-indigoBrand-500 to-cyan-400 flex items-center justify-center shadow-lg shadow-brand-500/20 group-hover:scale-105 transition-transform">
                    <i class="fa-solid fa-network-wired text-white text-lg"></i>
                </div>
                <div>
                    <span class="font-outfit font-extrabold text-xl tracking-tight text-white flex items-center gap-1.5">
                        MikroHN <span class="text-[10px] font-bold uppercase px-1.5 py-0.5 bg-brand-500/20 border border-brand-500/40 text-brand-400 rounded-md tracking-wider">ADMIN</span>
                    </span>
                    <span class="text-[10px] block text-slate-400 font-medium -mt-0.5">Control Central SaaS</span>
                </div>
            </a>
            <button onclick="toggleSidebar()" class="lg:hidden text-slate-400 hover:text-white p-1">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Navegación -->
        <div class="flex-1 overflow-y-auto px-4 py-6 space-y-6">
            <!-- Sección Principal -->
            <div>
                <p class="px-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Administración</p>
                <nav class="space-y-1">
                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-brand-500/20 to-indigoBrand-500/10 text-white border-l-4 border-brand-500 shadow-sm shadow-brand-500/10' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                        <i class="fa-solid fa-chart-pie w-5 text-center {{ request()->routeIs('admin.dashboard') ? 'text-brand-400' : 'text-slate-500' }}"></i>
                        <span>Dashboard General</span>
                    </a>

                    <!-- Tenants / ISPs -->
                    <a href="{{ route('admin.tenants.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.tenants.*') ? 'bg-gradient-to-r from-brand-500/20 to-indigoBrand-500/10 text-white border-l-4 border-brand-500 shadow-sm shadow-brand-500/10' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-server w-5 text-center {{ request()->routeIs('admin.tenants.*') ? 'text-brand-400' : 'text-slate-500' }}"></i>
                            <span>ISPs / Tenants</span>
                        </div>
                        <span class="text-xs px-2 py-0.5 rounded-full bg-slate-800 text-slate-400 font-mono">{{ \App\Models\Tenant::count() }}</span>
                    </a>

                    <!-- Suscripciones -->
                    <a href="{{ route('admin.subscriptions.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.subscriptions.*') ? 'bg-gradient-to-r from-brand-500/20 to-indigoBrand-500/10 text-white border-l-4 border-brand-500 shadow-sm shadow-brand-500/10' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-credit-card w-5 text-center {{ request()->routeIs('admin.subscriptions.*') ? 'text-brand-400' : 'text-slate-500' }}"></i>
                            <span>Suscripciones</span>
                        </div>
                        <span class="text-xs px-2 py-0.5 rounded-full bg-emerald-500/15 text-emerald-400 font-mono">{{ \App\Models\Subscription::where('status', 'active')->count() }}</span>
                    </a>

                    <!-- Catálogo de Planes -->
                    <a href="{{ route('admin.plans.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.plans.*') ? 'bg-gradient-to-r from-brand-500/20 to-indigoBrand-500/10 text-white border-l-4 border-brand-500 shadow-sm shadow-brand-500/10' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                        <i class="fa-solid fa-layer-group w-5 text-center {{ request()->routeIs('admin.plans.*') ? 'text-brand-400' : 'text-slate-500' }}"></i>
                        <span>Catálogo de Planes</span>
                    </a>
                </nav>
            </div>

            <!-- Accesos Rápidos -->
            <div>
                <p class="px-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Portal Público</p>
                <nav class="space-y-1">
                    <a href="{{ url('/') }}" target="_blank" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium text-slate-400 hover:text-white hover:bg-slate-800/50 transition-all group">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-arrow-up-right-from-square w-5 text-center text-slate-500 group-hover:text-brand-400 transition-colors"></i>
                            <span>Ver Landing Page</span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-[10px] text-slate-600 group-hover:translate-x-0.5 transition-transform"></i>
                    </a>
                </nav>
            </div>
        </div>

        <!-- Footer del Sidebar: Usuario & Logout -->
        <div class="p-4 border-t border-slate-800/80 bg-slate-950/60">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-500 to-indigoBrand-600 flex items-center justify-center text-white font-bold text-sm shadow-md shadow-brand-500/20">
                    <i class="fa-solid fa-user-shield"></i>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-semibold text-white truncate">{{ Auth::user()->name ?? 'Administrador' }}</p>
                    <p class="text-[11px] text-slate-400 truncate flex items-center gap-1 font-mono">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                        {{ '@' . (Auth::user()->username ?? 'admin') }}
                    </p>
                </div>
            </div>

            <!-- Botón de Logout -->
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-xl bg-slate-800/80 hover:bg-rose-500/20 text-slate-300 hover:text-rose-400 border border-slate-700/60 hover:border-rose-500/30 text-xs font-medium transition-all group cursor-pointer">
                    <i class="fa-solid fa-arrow-right-from-bracket group-hover:-translate-x-0.5 transition-transform"></i>
                    <span>Cerrar Sesión</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Contenido Principal -->
    <div class="lg:pl-64 flex flex-col flex-1 min-h-screen w-full">

        <!-- Topbar Superior -->
        <header class="sticky top-0 z-30 h-16 glass-panel border-b border-slate-800/80 px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <button onclick="toggleSidebar()" class="lg:hidden text-slate-400 hover:text-white p-2 rounded-lg bg-slate-800/60 border border-slate-700/60">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
                <div>
                    <h2 class="text-base sm:text-lg font-outfit font-bold text-white tracking-tight flex items-center gap-2">
                        @yield('header_title', 'Panel Administrativo')
                    </h2>
                </div>
            </div>

            <!-- Estado del Sistema & Acciones Rápidas -->
            <div class="flex items-center gap-3">
                <div class="hidden sm:inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-900 border border-slate-800 text-xs text-slate-300">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="text-[11px] font-medium text-slate-400">Motor SaaS:</span>
                    <span class="text-[11px] font-semibold text-emerald-400">Online 100%</span>
                </div>

                <a href="{{ route('admin.tenants.index') }}" class="hidden md:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-brand-500/10 hover:bg-brand-500/20 border border-brand-500/30 text-xs font-semibold text-brand-300 transition-colors">
                    <i class="fa-solid fa-plus text-[10px]"></i>
                    <span>Nuevo ISP</span>
                </a>
            </div>
        </header>

        <!-- Banner de Impersonación Activa (Si aplica) -->
        @if(session('impersonating_tenant'))
            @php $imp = session('impersonating_tenant'); @endphp
            <div class="bg-gradient-to-r from-amber-950/80 via-slate-900 to-amber-950/80 border-b border-amber-500/30 px-4 sm:px-8 py-2.5 flex items-center justify-between gap-4">
                <div class="flex items-center gap-2.5 text-xs text-amber-200">
                    <i class="fa-solid fa-eye text-amber-400 animate-pulse text-sm"></i>
                    <span><strong>Modo Impersonación Simulado:</strong> Visualizando tenant <strong>{{ $imp['name'] }}</strong> (<code class="text-amber-300">{{ $imp['subdomain'] }}.mikrohn.com</code>)</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-xs text-amber-400 hover:text-amber-200 font-medium underline">
                    Finalizar Simulación
                </button>
            </div>
        @endif

        <!-- Alertas Flash -->
        <div class="px-4 sm:px-6 lg:px-8 pt-6">
            @if(session('success'))
                <div id="flash-success" class="mb-5 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 text-xs flex items-center justify-between gap-3 shadow-lg shadow-emerald-500/5">
                    <div class="flex items-center gap-2.5">
                        <i class="fa-solid fa-circle-check text-emerald-400 text-base"></i>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                    <button onclick="document.getElementById('flash-success').remove()" class="text-emerald-400 hover:text-white p-1">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            @if(session('info'))
                <div id="flash-info" class="mb-5 p-4 rounded-xl bg-brand-500/10 border border-brand-500/30 text-brand-300 text-xs flex items-center justify-between gap-3 shadow-lg shadow-brand-500/5">
                    <div class="flex items-center gap-2.5">
                        <i class="fa-solid fa-circle-info text-brand-400 text-base"></i>
                        <span class="font-medium">{{ session('info') }}</span>
                    </div>
                    <button onclick="document.getElementById('flash-info').remove()" class="text-brand-400 hover:text-white p-1">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            @if(session('error') || $errors->any())
                <div id="flash-error" class="mb-5 p-4 rounded-xl bg-rose-500/10 border border-rose-500/30 text-rose-300 text-xs flex items-center justify-between gap-3 shadow-lg shadow-rose-500/5">
                    <div class="flex items-center gap-2.5">
                        <i class="fa-solid fa-circle-exclamation text-rose-400 text-base"></i>
                        <div>
                            @if(session('error'))
                                <span class="font-medium">{{ session('error') }}</span>
                            @else
                                <span class="font-medium">Por favor verifica los errores en el formulario:</span>
                                <ul class="list-disc list-inside mt-1 space-y-0.5">
                                    @foreach($errors->all() as $err)
                                        <li>{{ $err }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                    <button onclick="document.getElementById('flash-error').remove()" class="text-rose-400 hover:text-white p-1">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif
        </div>

        <!-- Área de Contenido Principal -->
        <main class="flex-1 px-4 sm:px-6 lg:px-8 pb-12">
            @yield('content')
        </main>

        <!-- Footer Administrativo -->
        <footer class="border-t border-slate-800/60 bg-slate-950/40 py-4 px-4 sm:px-6 lg:px-8 text-center sm:flex sm:items-center sm:justify-between text-xs text-slate-500">
            <p>&copy; {{ date('Y') }} MikroHN SaaS - Plataforma Multi-tenant de Automatización MikroTik.</p>
            <p class="mt-2 sm:mt-0 font-mono text-[11px] text-slate-600">v1.2.0 • Laravel {{ app()->version() }} • PHP {{ PHP_VERSION }}</p>
        </footer>
    </div>

    <!-- Scripts -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('admin-sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            const isOpen = !sidebar.classList.contains('-translate-x-full');
            if (isOpen) {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
            } else {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
            }
        }
    </script>
    @stack('scripts')
</body>
</html>
