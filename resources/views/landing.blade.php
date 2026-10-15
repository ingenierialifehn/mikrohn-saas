<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MikroHN SaaS | Plataforma de Automatización MikroTik y Cobranza para WISPs e ISPs</title>
    <meta name="description" content="Gestiona tus routers MikroTik, automatiza cortes por falta de pago, facturación electrónica y portal de clientes para proveedores de internet (WISP/ISP).">
    
    <!-- Google Fonts: Inter & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
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
        .gradient-border {
            background: linear-gradient(135deg, rgba(6, 182, 212, 0.4), rgba(99, 102, 241, 0.2), rgba(255, 255, 255, 0.05));
        }
        .glass-panel {
            background: rgba(17, 24, 39, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }
    </style>
</head>
<body class="bg-darkBg text-slate-100 font-sans antialiased selection:bg-brand-500 selection:text-white">

    <!-- Notificación Flash -->
    @if(session('success'))
        <div id="flash-banner" class="fixed top-4 right-4 z-50 max-w-md bg-emerald-950/90 border border-emerald-500/50 text-emerald-200 px-5 py-4 rounded-xl shadow-2xl flex items-start gap-3 backdrop-blur-md transition-all">
            <i class="fa-solid fa-circle-check text-emerald-400 text-xl mt-0.5"></i>
            <div>
                <p class="font-bold text-white text-sm">¡Operación Exitosa!</p>
                <p class="text-xs text-emerald-200 mt-0.5">{{ session('success') }}</p>
            </div>
            <button onclick="document.getElementById('flash-banner').remove()" class="ml-auto text-emerald-400 hover:text-white">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    @endif

    <!-- Header / Barra de Navegación -->
    <header class="sticky top-0 z-40 w-full glass-panel border-b border-slate-800/80 transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                <div class="w-11 h-11 rounded-xl bg-gradient-to-tr from-brand-600 via-indigoBrand-500 to-cyan-400 flex items-center justify-center shadow-lg shadow-brand-500/20 group-hover:scale-105 transition-transform">
                    <i class="fa-solid fa-network-wired text-white text-xl"></i>
                </div>
                <div>
                    <span class="font-outfit font-extrabold text-2xl tracking-tight text-white flex items-center gap-1.5">
                        MikroHN <span class="text-xs font-semibold uppercase px-2 py-0.5 bg-brand-500/20 border border-brand-500/40 text-brand-400 rounded-full tracking-wider">SaaS</span>
                    </span>
                    <span class="text-[11px] block text-slate-400 -mt-1 font-medium">Gestión Inteligente de ISPs & MikroTik</span>
                </div>
            </a>

            <!-- Menú Central -->
            <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-300">
                <a href="#caracteristicas" class="hover:text-brand-400 transition-colors">Características</a>
                <a href="#automatizacion" class="hover:text-brand-400 transition-colors">Automatización</a>
                <a href="#como-funciona" class="hover:text-brand-400 transition-colors">Cómo Funciona</a>
                <a href="#planes" class="hover:text-brand-400 transition-colors">Planes y Precios</a>
                <a href="#faq" class="hover:text-brand-400 transition-colors">Preguntas Frecuentes</a>
            </nav>

            <!-- Acciones -->
            <div class="flex items-center gap-4">
                <a href="{{ route('login') }}" class="hidden sm:inline-flex text-sm font-medium text-slate-300 hover:text-white px-3 py-2 transition-colors">
                    <i class="fa-solid fa-lock mr-2 text-slate-400"></i> Acceso Clientes
                </a>
                <button onclick="openRegisterModal()" class="relative group overflow-hidden rounded-xl bg-gradient-to-r from-brand-500 to-indigoBrand-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-brand-500/25 hover:shadow-cyan-500/40 hover:scale-[1.02] active:scale-[0.98] transition-all">
                    <span class="relative z-10 flex items-center gap-2">
                        <span>Prueba Gratis 15 Días</span>
                        <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                    </span>
                </button>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative pt-12 pb-24 lg:pt-20 lg:pb-32 overflow-hidden">
        <!-- Glows de Fondo -->
        <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[500px] bg-brand-500/10 rounded-full blur-[140px] pointer-events-none"></div>
        <div class="absolute top-1/3 left-1/4 w-[500px] h-[400px] bg-indigoBrand-500/10 rounded-full blur-[130px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-4xl mx-auto">
                <!-- Pill Badge -->
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-slate-800/80 border border-slate-700/80 text-xs font-semibold text-brand-300 mb-8 backdrop-blur-md shadow-inner">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Compatible al 100% con MikroTik RouterOS v6 & v7</span>
                    <i class="fa-solid fa-shield-halved text-brand-400 ml-1"></i>
                </div>

                <!-- Título Principal -->
                <h1 class="font-outfit font-extrabold text-4xl sm:text-5xl lg:text-6xl text-white tracking-tight leading-[1.15] mb-6">
                    Automatiza tu ISP con MikroTik: <br>
                    <span class="gradient-text">Cortes, Cobranza y Cero Morosidad</span>
                </h1>

                <!-- Subtítulo -->
                <p class="text-lg sm:text-xl text-slate-300 font-normal leading-relaxed max-w-3xl mx-auto mb-10">
                    Sincroniza múltiples routers MikroTik en segundos. Aplica cortes y reconexiones automáticas en milisegundos, envía avisos de pago por WhatsApp y gestiona miles de clientes sin tocar Winbox.
                </p>

                <!-- Botones CTA -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-14">
                    <button onclick="openRegisterModal()" class="w-full sm:w-auto px-8 py-4 rounded-xl bg-gradient-to-r from-brand-500 via-cyan-500 to-indigoBrand-600 font-semibold text-white text-base shadow-xl shadow-brand-500/25 hover:shadow-cyan-400/40 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-3">
                        <i class="fa-solid fa-rocket text-cyan-200"></i>
                        <span>Empezar Prueba Gratuita (15 Días)</span>
                    </button>
                    <a href="#como-funciona" class="w-full sm:w-auto px-8 py-4 rounded-xl bg-slate-800/90 hover:bg-slate-700/90 border border-slate-700 font-semibold text-slate-200 text-base transition-all flex items-center justify-center gap-2">
                        <i class="fa-regular fa-circle-play text-brand-400"></i>
                        <span>Ver Cómo Funciona</span>
                    </a>
                </div>

                <!-- Garantías Rápidas -->
                <div class="flex flex-wrap items-center justify-center gap-6 sm:gap-10 text-xs font-medium text-slate-400">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-check text-emerald-400"></i>
                        <span>Sin tarjeta de crédito para empezar</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-check text-emerald-400"></i>
                        <span>Configuración guiada en 5 minutos</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-check text-emerald-400"></i>
                        <span>Soporte WISP de ingeniería en español</span>
                    </div>
                </div>
            </div>

            <!-- Mockup del Dashboard de MikroHN -->
            <div class="mt-16 max-w-5xl mx-auto relative group">
                <div class="absolute -inset-1 rounded-2xl bg-gradient-to-r from-brand-500/30 via-indigoBrand-500/30 to-purple-500/30 blur-xl opacity-70 group-hover:opacity-100 transition duration-1000"></div>
                
                <div class="relative rounded-2xl bg-slate-900 border border-slate-700/80 shadow-2xl overflow-hidden">
                    <!-- Barra de Ventana -->
                    <div class="h-10 bg-slate-950 px-4 flex items-center justify-between border-b border-slate-800 text-xs text-slate-400">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-rose-500/80 inline-block"></span>
                            <span class="w-3 h-3 rounded-full bg-amber-500/80 inline-block"></span>
                            <span class="w-3 h-3 rounded-full bg-emerald-500/80 inline-block"></span>
                            <span class="ml-2 font-mono text-slate-400 text-[11px]">mikrohn-saas.test:8085 • Panel Central WISP</span>
                        </div>
                        <div class="flex items-center gap-3 text-emerald-400 font-mono text-[11px]">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                            <span>API MikroTik: En Línea</span>
                        </div>
                    </div>

                    <!-- Contenido Interactivo Mockup -->
                    <div class="p-6 bg-slate-900/90 grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Widget 1: Routers Online -->
                        <div class="bg-slate-800/60 p-4 rounded-xl border border-slate-700/60">
                            <div class="flex justify-between items-center text-xs text-slate-400">
                                <span>Routers Conectados</span>
                                <i class="fa-solid fa-server text-cyan-400"></i>
                            </div>
                            <div class="text-2xl font-bold font-outfit text-white mt-2">4 <span class="text-xs font-normal text-emerald-400 font-sans">/ 4 Online</span></div>
                            <div class="text-[11px] text-slate-400 mt-1 flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                <span>Latencia prom: 3.2 ms</span>
                            </div>
                        </div>

                        <!-- Widget 2: Clientes Activos -->
                        <div class="bg-slate-800/60 p-4 rounded-xl border border-slate-700/60">
                            <div class="flex justify-between items-center text-xs text-slate-400">
                                <span>Clientes Abonados</span>
                                <i class="fa-solid fa-users text-indigo-400"></i>
                            </div>
                            <div class="text-2xl font-bold font-outfit text-white mt-2">1,248</div>
                            <div class="text-[11px] text-emerald-400 mt-1 flex items-center gap-1">
                                <i class="fa-solid fa-arrow-trend-up"></i>
                                <span>+38 este mes</span>
                            </div>
                        </div>

                        <!-- Widget 3: Cortes Automáticos -->
                        <div class="bg-slate-800/60 p-4 rounded-xl border border-slate-700/60">
                            <div class="flex justify-between items-center text-xs text-slate-400">
                                <span>Cortes Automáticos</span>
                                <i class="fa-solid fa-ban text-rose-400"></i>
                            </div>
                            <div class="text-2xl font-bold font-outfit text-white mt-2">14</div>
                            <div class="text-[11px] text-rose-300 mt-1">
                                <span>Suspendidos por corte programado</span>
                            </div>
                        </div>

                        <!-- Widget 4: Tráfico Total -->
                        <div class="bg-slate-800/60 p-4 rounded-xl border border-slate-700/60">
                            <div class="flex justify-between items-center text-xs text-slate-400">
                                <span>Tráfico WAN Agregado</span>
                                <i class="fa-solid fa-gauge-high text-emerald-400"></i>
                            </div>
                            <div class="text-2xl font-bold font-outfit text-white mt-2">1.84 <span class="text-xs font-normal text-slate-400 font-sans">Gbps</span></div>
                            <div class="text-[11px] text-cyan-300 mt-1">
                                <span>PCC Balanceador Activo</span>
                            </div>
                        </div>

                        <!-- Feed de Eventos en Vivo MikroTik -->
                        <div class="md:col-span-4 bg-slate-950/70 p-4 rounded-xl border border-slate-800 text-xs">
                            <div class="flex items-center justify-between pb-2 border-b border-slate-800/80 mb-3">
                                <span class="font-semibold text-slate-300 flex items-center gap-2">
                                    <i class="fa-solid fa-bolt text-amber-400"></i> Actividad en Tiempo Real RouterOS
                                </span>
                                <span class="text-[11px] text-slate-500 font-mono">Sincronizado vía API</span>
                            </div>
                            <div class="space-y-2 font-mono text-[11px]">
                                <div class="flex items-center justify-between text-slate-300">
                                    <span class="flex items-center gap-2">
                                        <span class="text-emerald-400">[RECONECTADO]</span>
                                        <span>Cliente #1029 (Mario Zelaya) • Pago recibido vía WhatsApp</span>
                                    </span>
                                    <span class="text-slate-500">Hace 1 min</span>
                                </div>
                                <div class="flex items-center justify-between text-slate-300">
                                    <span class="flex items-center gap-2">
                                        <span class="text-rose-400">[SUSPENDIDO]</span>
                                        <span>Cliente #0843 (Taller Santos) • Vencimiento de gracia de 3 días</span>
                                    </span>
                                    <span class="text-slate-500">Hace 4 mins</span>
                                </div>
                                <div class="flex items-center justify-between text-slate-300">
                                    <span class="flex items-center gap-2">
                                        <span class="text-cyan-400">[BACKUP_OK]</span>
                                        <span>Respaldo encriptado generado para CCR1036-TorreNorte</span>
                                    </span>
                                    <span class="text-slate-500">Hace 12 mins</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Cinta de Estadísticas -->
    <section class="border-y border-slate-800/80 bg-slate-950/50 py-10 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <p class="font-outfit font-extrabold text-3xl sm:text-4xl text-brand-400">+150</p>
                    <p class="text-xs sm:text-sm text-slate-400 mt-1 font-medium">ISPs y WISPs Conectados</p>
                </div>
                <div>
                    <p class="font-outfit font-extrabold text-3xl sm:text-4xl text-indigo-400">+85,000</p>
                    <p class="text-xs sm:text-sm text-slate-400 mt-1 font-medium">Abonados Gestionados</p>
                </div>
                <div>
                    <p class="font-outfit font-extrabold text-3xl sm:text-4xl text-emerald-400">99.98%</p>
                    <p class="text-xs sm:text-sm text-slate-400 mt-1 font-medium">Efectividad en Cortes MikroTik</p>
                </div>
                <div>
                    <p class="font-outfit font-extrabold text-3xl sm:text-4xl text-amber-400">-42%</p>
                    <p class="text-xs sm:text-sm text-slate-400 mt-1 font-medium">Reducción en Morosidad</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Características Principales -->
    <section id="caracteristicas" class="py-24 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-xs font-bold uppercase tracking-wider text-brand-400">Tecnología Especializada</span>
                <h2 class="font-outfit font-extrabold text-3xl sm:text-4xl text-white mt-2">
                    Todo lo que necesita un ISP moderno en un solo panel
                </h2>
                <p class="text-slate-400 mt-3 text-base">
                    Diseñado específicamente para resolver los dolores de cabeza diarios de los operadores de redes fijas, inalámbricas y fibra óptica.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div class="bg-slate-900/90 border border-slate-800 p-8 rounded-2xl hover:border-brand-500/50 hover:shadow-xl hover:shadow-brand-500/10 transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-brand-500/10 border border-brand-500/20 text-brand-400 flex items-center justify-center text-xl mb-6">
                        <i class="fa-solid fa-power-off"></i>
                    </div>
                    <h3 class="font-outfit font-bold text-xl text-white mb-2">Cortes Automáticos en Segundos</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        Despídete de suspender manualmente. El sistema envía las reglas de corte por API a tu MikroTik el día y la hora exacta que tú configures.
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="bg-slate-900/90 border border-slate-800 p-8 rounded-2xl hover:border-indigoBrand-500/50 hover:shadow-xl hover:shadow-indigoBrand-500/10 transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-indigoBrand-500/10 border border-indigoBrand-500/20 text-indigoBrand-500 flex items-center justify-center text-xl mb-6">
                        <i class="fa-solid fa-id-card-clip"></i>
                    </div>
                    <h3 class="font-outfit font-bold text-xl text-white mb-2">Portal Cautivo de Aviso</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        Cuando el cliente abre el navegador, se le muestra su estado de cuenta, monto adeudado y números de cuenta bancaria para pago inmediato.
                    </p>
                </div>

                <!-- Card 3 -->
                <div class="bg-slate-900/90 border border-slate-800 p-8 rounded-2xl hover:border-emerald-500/50 hover:shadow-xl hover:shadow-emerald-500/10 transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center text-xl mb-6">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <h3 class="font-outfit font-bold text-xl text-white mb-2">Cobranza y Avisos WhatsApp</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        Envío automatizado de recordatorios 3 días antes del corte, confirmación de pago y recibos oficiales con código QR y PDF descargable.
                    </p>
                </div>

                <!-- Card 4 -->
                <div class="bg-slate-900/90 border border-slate-800 p-8 rounded-2xl hover:border-cyan-500/50 hover:shadow-xl hover:shadow-cyan-500/10 transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 flex items-center justify-center text-xl mb-6">
                        <i class="fa-solid fa-gauge"></i>
                    </div>
                    <h3 class="font-outfit font-bold text-xl text-white mb-2">Control de Velocidad (Queues / PCQ)</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        Asignación automática de Simple Queues, Queue Trees o perfiles PPPoE con ráfagas (Bursting) para que tus clientes disfruten de velocidad óptima.
                    </p>
                </div>

                <!-- Card 5 -->
                <div class="bg-slate-900/90 border border-slate-800 p-8 rounded-2xl hover:border-amber-500/50 hover:shadow-xl hover:shadow-amber-500/10 transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-400 flex items-center justify-center text-xl mb-6">
                        <i class="fa-solid fa-network-wired"></i>
                    </div>
                    <h3 class="font-outfit font-bold text-xl text-white mb-2">Multi-Router & Nodos Remotos</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        Conecta 1, 5 o 20 routers MikroTik distribuidos en diferentes torres o ciudades. Todo sincronizado en una base de datos centralizada.
                    </p>
                </div>

                <!-- Card 6 -->
                <div class="bg-slate-900/90 border border-slate-800 p-8 rounded-2xl hover:border-purple-500/50 hover:shadow-xl hover:shadow-purple-500/10 transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-purple-500/10 border border-purple-500/20 text-purple-400 flex items-center justify-center text-xl mb-6">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                    </div>
                    <h3 class="font-outfit font-bold text-xl text-white mb-2">Respaldos Automáticos en Nube</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        Generación periódica de archivos .backup y .rsc exportados de tus equipos MikroTik con almacenamiento seguro en la nube.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Cómo Funciona -->
    <section id="como-funciona" class="py-20 bg-slate-950/60 border-t border-slate-800/80 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-xs font-bold uppercase tracking-wider text-cyan-400">Puesta en Marcha en 3 Pasos</span>
                <h2 class="font-outfit font-extrabold text-3xl sm:text-4xl text-white mt-2">
                    Comienza a operar en menos de 10 minutos
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
                <!-- Paso 1 -->
                <div class="relative bg-slate-900 p-8 rounded-2xl border border-slate-800">
                    <div class="w-10 h-10 rounded-full bg-brand-500 text-white font-extrabold font-outfit flex items-center justify-center mb-6 text-lg shadow-lg shadow-brand-500/30">
                        1
                    </div>
                    <h3 class="font-outfit font-bold text-xl text-white mb-2">Crea tu Espacio WISP</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        Regístrate gratis, elige el nombre de tu ISP y obtendrás tu subdominio dedicado (ej. <span class="text-brand-300 font-mono">tunet.mikrohn.com</span>).
                    </p>
                </div>

                <!-- Paso 2 -->
                <div class="relative bg-slate-900 p-8 rounded-2xl border border-slate-800">
                    <div class="w-10 h-10 rounded-full bg-indigoBrand-500 text-white font-extrabold font-outfit flex items-center justify-center mb-6 text-lg shadow-lg shadow-indigoBrand-500/30">
                        2
                    </div>
                    <h3 class="font-outfit font-bold text-xl text-white mb-2">Vincula tu MikroTik</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        Copia un script de 3 líneas en el terminal de RouterOS. La conexión se establece al instante vía API con credenciales seguras.
                    </p>
                </div>

                <!-- Paso 3 -->
                <div class="relative bg-slate-900 p-8 rounded-2xl border border-slate-800">
                    <div class="w-10 h-10 rounded-full bg-emerald-500 text-white font-extrabold font-outfit flex items-center justify-center mb-6 text-lg shadow-lg shadow-emerald-500/30">
                        3
                    </div>
                    <h3 class="font-outfit font-bold text-xl text-white mb-2">Automatización Total</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        Importa tus clientes o dales de alta. El sistema se encarga de las colas, las facturas, los cortes de servicio y las reconexiones.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Tabla de Planes y Precios -->
    <section id="planes" class="py-24 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-xs font-bold uppercase tracking-wider text-brand-400">Planes Transparentes</span>
                <h2 class="font-outfit font-extrabold text-3xl sm:text-5xl text-white mt-2">
                    Invierte en el crecimiento de tu red
                </h2>
                <p class="text-slate-400 mt-4 text-base">
                    Todos los planes incluyen 15 días de prueba completa sin restricciones. Cancela o cambia de plan cuando quieras.
                </p>

                <!-- Selector Mensual / Anual -->
                <div class="mt-8 inline-flex items-center p-1 bg-slate-800/80 border border-slate-700 rounded-xl">
                    <button id="btn-monthly" onclick="setBilling('monthly')" class="px-5 py-2 rounded-lg text-xs font-semibold text-white bg-brand-600 shadow-sm transition-all">
                        Facturación Mensual
                    </button>
                    <button id="btn-yearly" onclick="setBilling('yearly')" class="px-5 py-2 rounded-lg text-xs font-semibold text-slate-400 hover:text-white transition-all flex items-center gap-1.5">
                        <span>Anual</span>
                        <span class="bg-emerald-500/20 text-emerald-400 text-[10px] px-2 py-0.5 rounded-full font-bold">Ahorra 20%</span>
                    </button>
                </div>
            </div>

            <!-- Grid de Planes Dinámicos desde BD -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-stretch">
                @foreach($plans as $plan)
                    @php
                        $isPopular = ($plan->slug === 'profesional');
                    @endphp
                    <div class="relative rounded-3xl p-8 flex flex-col justify-between transition-all duration-300 {{ $isPopular ? 'bg-slate-900 border-2 border-brand-500 shadow-2xl shadow-brand-500/20 scale-105 z-10' : 'bg-slate-900/80 border border-slate-800 hover:border-slate-700' }}">
                        @if($isPopular)
                            <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 bg-gradient-to-r from-brand-500 to-indigoBrand-500 text-white text-[11px] font-extrabold uppercase px-4 py-1 rounded-full tracking-wider shadow-md">
                                ★ Plan Más Elegido
                            </div>
                        @endif

                        <div>
                            <!-- Header de Plan -->
                            <div class="mb-6">
                                <h3 class="font-outfit font-bold text-2xl text-white">{{ $plan->name }}</h3>
                                <p class="text-xs text-slate-400 mt-1">
                                    Ideal para ISPs con hasta {{ number_format($plan->max_clients) }} abonados y {{ $plan->max_routers }} routers.
                                </p>
                            </div>

                            <!-- Precio -->
                            <div class="flex items-baseline gap-1 mb-6">
                                <span class="text-slate-400 text-lg font-medium">$</span>
                                <span class="font-outfit font-extrabold text-5xl text-white plan-price" data-monthly="{{ $plan->price }}">
                                    {{ number_format($plan->price, 0) }}
                                </span>
                                <span class="text-xs text-slate-400 font-medium">USD / mes</span>
                            </div>

                            <!-- Capacidades Rápidas -->
                            <div class="p-3.5 bg-slate-950/60 rounded-xl border border-slate-800/80 mb-6 text-xs text-slate-300 space-y-1.5 font-medium">
                                <div class="flex items-center justify-between">
                                    <span class="text-slate-400">Routers MikroTik:</span>
                                    <span class="text-white font-bold">{{ $plan->max_routers }} equipos</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-slate-400">Límite de Clientes:</span>
                                    <span class="text-brand-300 font-bold">Hasta {{ number_format($plan->max_clients) }}</span>
                                </div>
                            </div>

                            <!-- Lista de Funcionalidades -->
                            <div class="space-y-3 mb-8 text-xs text-slate-300">
                                @if(is_array($plan->features))
                                    @foreach($plan->features as $feature)
                                        <div class="flex items-start gap-2.5">
                                            <i class="fa-solid fa-circle-check text-brand-400 mt-0.5 text-sm shrink-0"></i>
                                            <span>{{ $feature }}</span>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <!-- Botón de Selección -->
                        <button onclick="selectPlan('{{ $plan->id }}', '{{ addslashes($plan->name) }}')" class="w-full py-3.5 px-6 rounded-xl font-semibold text-sm transition-all {{ $isPopular ? 'bg-gradient-to-r from-brand-500 to-indigoBrand-600 hover:from-brand-400 hover:to-indigoBrand-500 text-white shadow-lg shadow-brand-500/30' : 'bg-slate-800 hover:bg-slate-700 text-slate-200' }}">
                            Comenzar Prueba de 15 Días
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Preguntas Frecuentes -->
    <section id="faq" class="py-20 bg-slate-950/70 border-t border-slate-800/80">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="text-xs font-bold uppercase tracking-wider text-cyan-400">Dudas Comunes</span>
                <h2 class="font-outfit font-extrabold text-3xl text-white mt-1">Preguntas Frecuentes</h2>
            </div>

            <div class="space-y-4 text-sm">
                <details class="group bg-slate-900 border border-slate-800 rounded-xl p-5 open:border-brand-500/50 transition-colors">
                    <summary class="font-semibold text-white cursor-pointer flex items-center justify-between list-none">
                        <span>¿Necesito una IP pública fija para conectar mis routers MikroTik?</span>
                        <i class="fa-solid fa-chevron-down text-slate-400 group-open:rotate-180 transition-transform"></i>
                    </summary>
                    <p class="text-slate-400 mt-3 leading-relaxed">
                        No es estrictamente necesario. Puedes conectarlo con IP pública fija, mediante DDNS (Cloud de MikroTik) o mediante una conexión de túnel WireGuard/VPN segura que te proveemos en la plataforma.
                    </p>
                </details>

                <details class="group bg-slate-900 border border-slate-800 rounded-xl p-5 open:border-brand-500/50 transition-colors">
                    <summary class="font-semibold text-white cursor-pointer flex items-center justify-between list-none">
                        <span>¿Es compatible con MikroTik RouterOS v7 y v6?</span>
                        <i class="fa-solid fa-chevron-down text-slate-400 group-open:rotate-180 transition-transform"></i>
                    </summary>
                    <p class="text-slate-400 mt-3 leading-relaxed">
                        Sí, totalmente compatible. MikroHN SaaS utiliza la API nativa de RouterOS y comandos estandarizados que funcionan tanto en arquitecturas x86, Cloud Hosted Router (CHR) como en dispositivos físicos RouterBOARD (CCR, RB3011, RB4011, hEX, etc.).
                    </p>
                </details>

                <details class="group bg-slate-900 border border-slate-800 rounded-xl p-5 open:border-brand-500/50 transition-colors">
                    <summary class="font-semibold text-white cursor-pointer flex items-center justify-between list-none">
                        <span>¿Qué sucede cuando se cumplen los 15 días de prueba?</span>
                        <i class="fa-solid fa-chevron-down text-slate-400 group-open:rotate-180 transition-transform"></i>
                    </summary>
                    <p class="text-slate-400 mt-3 leading-relaxed">
                        Puedes activar tu suscripción mensual en cualquier momento mediante tarjeta de crédito/débito o transferencia bancaria local. Tus datos, clientes y configuraciones de MikroTik permanecerán intactos.
                    </p>
                </details>
            </div>
        </div>
    </section>

    <!-- Modal de Registro de Nuevo Tenant -->
    <div id="register-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm hidden opacity-0 transition-opacity duration-300">
        <div class="bg-slate-900 border border-slate-700/80 rounded-2xl w-full max-w-lg overflow-hidden shadow-2xl relative transform scale-95 transition-transform duration-300">
            <!-- Modal Header -->
            <div class="px-6 py-5 bg-slate-950/90 border-b border-slate-800 flex items-center justify-between">
                <div>
                    <h3 class="font-outfit font-extrabold text-xl text-white">Comienza tu Prueba Gratuita</h3>
                    <p class="text-xs text-slate-400">Acceso total por 15 días para tu ISP o WISP</p>
                </div>
                <button onclick="closeRegisterModal()" class="text-slate-400 hover:text-white p-1">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <!-- Modal Form -->
            <form action="{{ route('tenant.register') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <!-- Nombre del ISP -->
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Nombre de tu ISP / Empresa *</label>
                    <input type="text" name="name" id="isp_name" oninput="updateSubdomainPreview(this.value)" required placeholder="Ej. Redes del Valle WISP" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-brand-500 transition-colors">
                </div>

                <!-- Subdominio Asignado -->
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Subdominio Dedicado en MikroHN *</label>
                    <div class="flex items-center">
                        <input type="text" name="subdomain" id="subdomain_input" required placeholder="valle-wisp" class="w-full bg-slate-950 border border-slate-800 rounded-l-xl px-4 py-2.5 text-sm text-brand-300 placeholder-slate-500 focus:outline-none focus:border-brand-500 font-mono transition-colors">
                        <span class="bg-slate-800 border border-l-0 border-slate-800 text-slate-400 text-xs px-3 py-3 rounded-r-xl font-mono whitespace-nowrap">.mikrohn.com</span>
                    </div>
                    <p class="text-[11px] text-slate-500 mt-1">Este será el enlace donde tu personal y clientes accederán.</p>
                </div>

                <!-- Nombre del Administrador -->
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Nombre del Administrador / Dueño *</label>
                    <input type="text" name="owner_name" required placeholder="Ej. Carlos Fernando" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-brand-500 transition-colors">
                </div>

                <!-- Email y Teléfono -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1">Correo Electrónico *</label>
                        <input type="email" name="email" required placeholder="admin@tuisp.com" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-brand-500 transition-colors">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1">Teléfono / WhatsApp</label>
                        <input type="tel" name="phone" placeholder="+504 9900-0000" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-brand-500 transition-colors">
                    </div>
                </div>

                <!-- Plan Seleccionado -->
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Plan a Probar *</label>
                    <select name="saas_plan_id" id="plan_select" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-brand-500 transition-colors">
                        @foreach($plans as $p)
                            <option value="{{ $p->id }}" {{ $p->slug === 'profesional' ? 'selected' : '' }}>
                                {{ $p->name }} - ${{ number_format($p->price, 0) }}/mes (Hasta {{ number_format($p->max_clients) }} clientes)
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Botón de Envío -->
                <button type="submit" class="w-full mt-2 py-3.5 px-6 rounded-xl bg-gradient-to-r from-brand-500 to-indigoBrand-600 hover:from-brand-400 hover:to-indigoBrand-500 font-semibold text-white text-sm shadow-xl shadow-brand-500/25 transition-all">
                    Activar mi Prueba Gratuita de 15 Días
                </button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="border-t border-slate-800/80 bg-slate-950 py-12 text-slate-400 text-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-brand-500/20 text-brand-400 flex items-center justify-center font-bold">
                    <i class="fa-solid fa-network-wired"></i>
                </div>
                <div>
                    <p class="font-outfit font-bold text-white text-sm">MikroHN SaaS</p>
                    <p class="text-[11px] text-slate-500">Gestión de Clientes y Automatización MikroTik para WISPs</p>
                </div>
            </div>

            <p class="text-slate-500">
                &copy; {{ date('Y') }} MikroHN SaaS. Todos los derechos reservados. Desarrollado para la comunidad de ISPs.
            </p>

            <div class="flex items-center gap-4 text-slate-400">
                <span class="inline-flex items-center gap-1.5 text-emerald-400">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    <span>Sistemas Operativos 100%</span>
                </span>
            </div>
        </div>
    </footer>

    <!-- JavaScript Interactivo -->
    <script>
        function openRegisterModal() {
            const modal = document.getElementById('register-modal');
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modal.querySelector('div').classList.remove('scale-95');
                modal.querySelector('div').classList.add('scale-100');
            }, 10);
        }

        function closeRegisterModal() {
            const modal = document.getElementById('register-modal');
            modal.classList.add('opacity-0');
            modal.querySelector('div').classList.remove('scale-100');
            modal.querySelector('div').classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        function selectPlan(planId, planName) {
            const select = document.getElementById('plan_select');
            if (select) {
                select.value = planId;
            }
            openRegisterModal();
        }

        function updateSubdomainPreview(val) {
            const clean = val.toLowerCase()
                .normalize('NFD').replace(/[\u0300-\u036f]/g, "")
                .replace(/[^a-z0-9]/g, '-')
                .replace(/-+/g, '-')
                .replace(/^-|-$/g, '');
            document.getElementById('subdomain_input').value = clean;
        }

        function setBilling(interval) {
            const btnM = document.getElementById('btn-monthly');
            const btnY = document.getElementById('btn-yearly');
            const priceElements = document.querySelectorAll('.plan-price');

            if (interval === 'yearly') {
                btnY.className = "px-5 py-2 rounded-lg text-xs font-semibold text-white bg-brand-600 shadow-sm transition-all flex items-center gap-1.5";
                btnM.className = "px-5 py-2 rounded-lg text-xs font-semibold text-slate-400 hover:text-white transition-all";
                
                priceElements.forEach(el => {
                    const monthly = parseFloat(el.getAttribute('data-monthly'));
                    const discounted = Math.round(monthly * 0.80);
                    el.innerText = discounted;
                });
            } else {
                btnM.className = "px-5 py-2 rounded-lg text-xs font-semibold text-white bg-brand-600 shadow-sm transition-all";
                btnY.className = "px-5 py-2 rounded-lg text-xs font-semibold text-slate-400 hover:text-white transition-all flex items-center gap-1.5";

                priceElements.forEach(el => {
                    const monthly = parseFloat(el.getAttribute('data-monthly'));
                    el.innerText = Math.round(monthly);
                });
            }
        }
    </script>
</body>
</html>
