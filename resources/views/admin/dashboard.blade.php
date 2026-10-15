@extends('layouts.admin')

@section('title', 'Dashboard General')
@section('header_title', 'Dashboard General')

@section('content')
<div class="space-y-8">

    <!-- Encabezado con Bienvenida -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold font-outfit text-white tracking-tight">
                Bienvenido, <span class="gradient-text">{{ Auth::user()->name }}</span>
            </h1>
            <p class="text-sm text-slate-400 mt-1">
                Monitoreo en tiempo real del estado de tenants, suscripciones activas y facturación MRR de MikroHN SaaS.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.tenants.index') }}" class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-brand-500 to-indigoBrand-600 hover:from-brand-400 hover:to-indigoBrand-500 text-white text-xs font-semibold shadow-lg shadow-brand-500/20 flex items-center gap-2 transition-all">
                <i class="fa-solid fa-server"></i>
                <span>Gestionar Tenants</span>
            </a>
            <a href="{{ route('admin.plans.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-semibold border border-slate-700 transition-all flex items-center gap-2">
                <i class="fa-solid fa-sliders"></i>
                <span>Planes SaaS</span>
            </a>
        </div>
    </div>

    <!-- 4 Tarjetas de Métricas Superiores -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

        <!-- 1. Total Tenants Registrados -->
        <div class="bg-slate-900/80 border border-slate-800/90 rounded-2xl p-5 backdrop-blur-xl relative overflow-hidden group hover:border-brand-500/50 transition-all">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-brand-500/5 rounded-full blur-xl group-hover:bg-brand-500/10 transition-colors"></div>
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Total Tenants</span>
                <div class="w-10 h-10 rounded-xl bg-brand-500/10 border border-brand-500/20 text-brand-400 flex items-center justify-center text-base">
                    <i class="fa-solid fa-server"></i>
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-extrabold font-outfit text-white tracking-tight">{{ number_format($totalTenants) }}</span>
                <span class="text-xs text-slate-400 font-medium">ISPs</span>
            </div>
            <div class="mt-3 flex items-center gap-1.5 text-xs text-emerald-400">
                <i class="fa-solid fa-arrow-trend-up text-[10px]"></i>
                <span>100% operativos en la nube</span>
            </div>
        </div>

        <!-- 2. Suscripciones Activas -->
        <div class="bg-slate-900/80 border border-slate-800/90 rounded-2xl p-5 backdrop-blur-xl relative overflow-hidden group hover:border-emerald-500/50 transition-all">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-emerald-500/5 rounded-full blur-xl group-hover:bg-emerald-500/10 transition-colors"></div>
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Suscripciones Activas</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center text-base">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-extrabold font-outfit text-white tracking-tight">{{ number_format($activeSubscriptions) }}</span>
                <span class="text-xs text-slate-400 font-medium">Pagos al día</span>
            </div>
            <div class="mt-3 flex items-center gap-1.5 text-xs text-slate-400">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                <span>Facturación automática recurrente</span>
            </div>
        </div>

        <!-- 3. Ingresos Mensuales Estimados (MRR) -->
        <div class="bg-slate-900/80 border border-slate-800/90 rounded-2xl p-5 backdrop-blur-xl relative overflow-hidden group hover:border-indigoBrand-500/50 transition-all">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-indigoBrand-500/5 rounded-full blur-xl group-hover:bg-indigoBrand-500/10 transition-colors"></div>
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">MRR Estimado</span>
                <div class="w-10 h-10 rounded-xl bg-indigoBrand-500/10 border border-indigoBrand-500/20 text-indigoBrand-400 flex items-center justify-center text-base">
                    <i class="fa-solid fa-dollar-sign"></i>
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-extrabold font-outfit text-white tracking-tight">${{ number_format($mrr, 2) }}</span>
                <span class="text-xs text-indigoBrand-300 font-medium">USD / mes</span>
            </div>
            <div class="mt-3 flex items-center gap-1.5 text-xs text-slate-400">
                <i class="fa-solid fa-wallet text-[10px] text-indigoBrand-400"></i>
                <span>Histórico pagado: ${{ number_format($totalInvoiced, 2) }} USD</span>
            </div>
        </div>

        <!-- 4. Tenants en Periodo de Prueba (Trial) -->
        <div class="bg-slate-900/80 border border-slate-800/90 rounded-2xl p-5 backdrop-blur-xl relative overflow-hidden group hover:border-amber-500/50 transition-all">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-amber-500/5 rounded-full blur-xl group-hover:bg-amber-500/10 transition-colors"></div>
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">En Periodo Trial</span>
                <div class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-400 flex items-center justify-center text-base">
                    <i class="fa-solid fa-stopwatch"></i>
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-extrabold font-outfit text-white tracking-tight">{{ number_format($trialTenants) }}</span>
                <span class="text-xs text-slate-400 font-medium">Prueba (15 días)</span>
            </div>
            <div class="mt-3 flex items-center gap-1.5 text-xs text-amber-400">
                <i class="fa-solid fa-clock-rotate-left text-[10px]"></i>
                <span>Oportunidades de conversión</span>
            </div>
        </div>

    </div>

    <!-- Sección de la Tabla Interactiva de Tenants -->
    <div class="bg-slate-900/80 border border-slate-800/90 rounded-2xl backdrop-blur-xl overflow-hidden shadow-xl shadow-black/40">

        <!-- Barra de Herramientas de la Tabla -->
        <div class="p-5 sm:p-6 border-b border-slate-800/80 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="font-outfit font-bold text-lg text-white tracking-tight flex items-center gap-2">
                    <span>ISPs y Tenants Registrados</span>
                    <span class="text-xs px-2 py-0.5 rounded-full bg-slate-800 text-slate-300 font-mono font-medium">{{ $tenants->total() }}</span>
                </h3>
                <p class="text-xs text-slate-400 mt-0.5">Control directo de estado, accesos e información técnica por proveedor.</p>
            </div>

            <!-- Buscador y Filtros -->
            <form method="GET" action="{{ route('admin.dashboard') }}" class="flex flex-wrap items-center gap-2.5">
                <div class="relative min-w-[200px]">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 text-xs"></i>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Buscar ISP, subdominio..."
                        class="w-full bg-slate-950/80 border border-slate-800 rounded-xl pl-8 pr-3 py-2 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-brand-500 transition-colors"
                    >
                </div>

                <select name="status" onchange="this.form.submit()" class="bg-slate-950/80 border border-slate-800 rounded-xl px-3 py-2 text-xs text-slate-300 focus:outline-none focus:border-brand-500 transition-colors">
                    <option value="">Todos los Estados</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Activos</option>
                    <option value="trial" {{ request('status') === 'trial' ? 'selected' : '' }}>Trial</option>
                    <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspendidos</option>
                </select>

                @if(request('search') || request('status'))
                    <a href="{{ route('admin.dashboard') }}" class="p-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white text-xs transition-colors" title="Limpiar filtros">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </form>
        </div>

        <!-- Tabla -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-300">
                <thead class="bg-slate-950/60 border-b border-slate-800 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">
                    <tr>
                        <th class="py-3.5 px-4 sm:px-6">Nombre del ISP</th>
                        <th class="py-3.5 px-4">Subdominio</th>
                        <th class="py-3.5 px-4">Contacto / Dueño</th>
                        <th class="py-3.5 px-4">Plan Actual</th>
                        <th class="py-3.5 px-4">Estado</th>
                        <th class="py-3.5 px-4">Fecha Registro</th>
                        <th class="py-3.5 px-4 sm:px-6 text-right">Acciones Rápidas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 font-normal">
                    @forelse($tenants as $tenant)
                        @php
                            $sub = $tenant->currentSubscription;
                            $plan = $sub?->plan;
                        @endphp
                        <tr class="hover:bg-slate-800/30 transition-colors">
                            <!-- Nombre del ISP -->
                            <td class="py-4 px-4 sm:px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-700/60 flex items-center justify-center text-brand-400 font-bold font-outfit shadow-sm">
                                        {{ strtoupper(substr($tenant->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-white text-sm tracking-tight">{{ $tenant->name }}</p>
                                        <p class="text-[11px] text-slate-500 font-mono">UUID: {{ substr($tenant->uuid, 0, 8) }}...</p>
                                    </div>
                                </div>
                            </td>

                            <!-- Subdominio -->
                            <td class="py-4 px-4 font-mono">
                                <span class="px-2.5 py-1 rounded-md bg-slate-950 border border-slate-800 text-brand-300 font-medium">
                                    {{ $tenant->subdomain }}.mikrohn.com
                                </span>
                            </td>

                            <!-- Contacto / Dueño -->
                            <td class="py-4 px-4">
                                <p class="font-medium text-slate-200">{{ $tenant->owner_name }}</p>
                                <p class="text-[11px] text-slate-400">{{ $tenant->email }}</p>
                                @if($tenant->phone)
                                    <p class="text-[10px] text-slate-500 mt-0.5"><i class="fa-solid fa-phone text-[9px] mr-1"></i>{{ $tenant->phone }}</p>
                                @endif
                            </td>

                            <!-- Plan Actual -->
                            <td class="py-4 px-4">
                                @if($plan)
                                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-indigoBrand-500/10 border border-indigoBrand-500/20 text-indigoBrand-300 font-medium">
                                        <i class="fa-solid fa-layer-group text-[10px]"></i>
                                        <span>{{ $plan->name }}</span>
                                    </div>
                                    <p class="text-[10px] text-slate-400 mt-1 font-mono">${{ number_format($plan->price, 0) }} USD/mes</p>
                                @else
                                    <span class="text-xs text-slate-500 italic">Sin plan asignado</span>
                                @endif
                            </td>

                            <!-- Estado (Badges: Activo, Trial, Suspendido) -->
                            <td class="py-4 px-4">
                                @if($tenant->status === 'active')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/25 text-emerald-400 text-[11px] font-semibold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                        Activo
                                    </span>
                                @elseif($tenant->status === 'trial')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-500/10 border border-amber-500/25 text-amber-400 text-[11px] font-semibold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                        Periodo Trial
                                    </span>
                                @elseif($tenant->status === 'suspended')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-rose-500/10 border border-rose-500/25 text-rose-400 text-[11px] font-semibold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                                        Suspendido
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-slate-800 text-slate-400 text-[11px]">
                                        {{ ucfirst($tenant->status) }}
                                    </span>
                                @endif
                            </td>

                            <!-- Fecha Registro -->
                            <td class="py-4 px-4 text-slate-400 font-mono text-[11px]">
                                {{ $tenant->created_at->format('d/m/Y') }}
                                <span class="block text-[10px] text-slate-500">{{ $tenant->created_at->diffForHumans() }}</span>
                            </td>

                            <!-- Acciones Rápidas por Tenant -->
                            <td class="py-4 px-4 sm:px-6 text-right">
                                <div class="inline-flex items-center gap-2">

                                    <!-- Botón Simulado para Impersonar/Acceder -->
                                    <a
                                        href="{{ route('admin.tenants.impersonate', $tenant) }}"
                                        class="px-2.5 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white border border-slate-700/80 text-[11px] font-medium transition-all flex items-center gap-1.5 shadow-sm"
                                        title="Simular acceso a la consola del ISP"
                                    >
                                        <i class="fa-solid fa-arrow-right-to-bracket text-brand-400"></i>
                                        <span class="hidden md:inline">Acceder</span>
                                    </a>

                                    <!-- Botón para Cambiar Estado (Suspender / Activar) -->
                                    <form action="{{ route('admin.tenants.toggle-status', $tenant) }}" method="POST" onsubmit="return confirm('¿Confirmas el cambio de estado para este tenant?');">
                                        @csrf
                                        @if($tenant->status === 'active')
                                            <button
                                                type="submit"
                                                class="px-2.5 py-1.5 rounded-lg bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 border border-rose-500/30 text-[11px] font-medium transition-all flex items-center gap-1.5 cursor-pointer"
                                                title="Suspender acceso a este ISP"
                                            >
                                                <i class="fa-solid fa-ban text-[10px]"></i>
                                                <span class="hidden md:inline">Suspender</span>
                                            </button>
                                        @else
                                            <button
                                                type="submit"
                                                class="px-2.5 py-1.5 rounded-lg bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 text-[11px] font-medium transition-all flex items-center gap-1.5 cursor-pointer"
                                                title="Activar tenant"
                                            >
                                                <i class="fa-solid fa-play text-[10px]"></i>
                                                <span class="hidden md:inline">Activar</span>
                                            </button>
                                        @endif
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-500">
                                <div class="max-w-xs mx-auto space-y-3">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-800/80 flex items-center justify-center text-slate-400 mx-auto text-xl">
                                        <i class="fa-solid fa-inbox"></i>
                                    </div>
                                    <p class="font-medium text-slate-300 text-sm">No se encontraron tenants</p>
                                    <p class="text-xs text-slate-500">No hay proveedores registrados que coincidan con los filtros aplicados.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        @if($tenants->hasPages())
            <div class="p-4 border-t border-slate-800/80 bg-slate-950/40">
                {{ $tenants->links() }}
            </div>
        @endif

    </div>

    <!-- Catálogo Rápido de Planes SaaS (Widgets Inferiores) -->
    <div class="bg-slate-900/80 border border-slate-800/90 rounded-2xl p-5 sm:p-6 backdrop-blur-xl">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h3 class="font-outfit font-bold text-lg text-white tracking-tight flex items-center gap-2">
                    <i class="fa-solid fa-layer-group text-brand-400"></i>
                    <span>Distribución y Catálogo de Planes SaaS</span>
                </h3>
                <p class="text-xs text-slate-400 mt-0.5">Límites técnicos configurados por router MikroTik y cuota de clientes.</p>
            </div>
            <a href="{{ route('admin.plans.index') }}" class="text-xs text-brand-400 hover:text-brand-300 font-medium flex items-center gap-1 transition-colors">
                <span>Editar catálogo</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            @foreach($plans as $plan)
                <div class="p-5 rounded-xl bg-slate-950/70 border border-slate-800 relative group hover:border-slate-700 transition-all">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <span class="text-xs uppercase font-bold text-brand-400 tracking-wider font-mono">{{ $plan->slug }}</span>
                            <h4 class="font-outfit font-bold text-base text-white mt-0.5">{{ $plan->name }}</h4>
                        </div>
                        <span class="text-xl font-extrabold font-outfit text-white font-mono">${{ number_format($plan->price, 0) }}</span>
                    </div>

                    <div class="space-y-1.5 text-xs text-slate-400 py-3 border-y border-slate-800/80 my-3">
                        <div class="flex items-center justify-between">
                            <span class="flex items-center gap-1.5"><i class="fa-solid fa-microchip text-[10px] text-slate-500"></i> Routers MikroTik:</span>
                            <span class="font-semibold text-slate-200">Hasta {{ $plan->max_routers }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="flex items-center gap-1.5"><i class="fa-solid fa-users text-[10px] text-slate-500"></i> Clientes Finales:</span>
                            <span class="font-semibold text-slate-200">Hasta {{ number_format($plan->max_clients) }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="flex items-center gap-1.5"><i class="fa-solid fa-circle-check text-[10px] text-emerald-400"></i> Suscriptores Activos:</span>
                            <span class="font-semibold text-emerald-400">{{ $plan->subscriptions_count }}</span>
                        </div>
                    </div>

                    <p class="text-[11px] text-slate-500 truncate">
                        {{ is_array($plan->features) ? implode(' • ', array_slice($plan->features, 0, 2)) : '' }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>

</div>
@endsection
