@extends('layouts.admin')

@section('title', 'Gestión de Tenants e ISPs')
@section('header_title', 'Gestión de Tenants e ISPs')

@section('content')
<div class="space-y-6">

    <!-- Encabezado de la Sección -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold font-outfit text-white tracking-tight">Proveedores ISP y Tenants</h1>
            <p class="text-xs text-slate-400 mt-1">Supervisa las instancias de MikroHN SaaS creadas para cada proveedor de internet.</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="px-3 py-1.5 rounded-xl bg-slate-900 border border-slate-800 text-xs font-mono text-slate-300">
                Total Registrados: <strong class="text-brand-400">{{ $tenants->total() }}</strong>
            </span>
        </div>
    </div>

    <!-- Barra de Filtros y Búsqueda -->
    <div class="bg-slate-900/80 border border-slate-800/90 rounded-2xl p-4 sm:p-5 backdrop-blur-xl">
        <form method="GET" action="{{ route('admin.tenants.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <!-- Búsqueda por texto -->
            <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-500 text-xs"></i>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Buscar por ISP, correo, dueño..."
                    class="w-full bg-slate-950/90 border border-slate-800 rounded-xl pl-9 pr-3 py-2.5 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-brand-500 transition-colors"
                >
            </div>

            <!-- Filtro por Estado -->
            <div>
                <select name="status" onchange="this.form.submit()" class="w-full bg-slate-950/90 border border-slate-800 rounded-xl px-3 py-2.5 text-xs text-slate-300 focus:outline-none focus:border-brand-500 transition-colors">
                    <option value="">Todos los Estados</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Activos</option>
                    <option value="trial" {{ request('status') === 'trial' ? 'selected' : '' }}>En Periodo de Prueba (Trial)</option>
                    <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspendidos</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelados</option>
                </select>
            </div>

            <!-- Filtro por Plan -->
            <div>
                <select name="plan_id" onchange="this.form.submit()" class="w-full bg-slate-950/90 border border-slate-800 rounded-xl px-3 py-2.5 text-xs text-slate-300 focus:outline-none focus:border-brand-500 transition-colors">
                    <option value="">Todos los Planes</option>
                    @foreach($plans as $plan)
                        <option value="{{ $plan->id }}" {{ request('plan_id') == $plan->id ? 'selected' : '' }}>
                            {{ $plan->name }} (${{ number_format($plan->price, 0) }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Botones de Acción -->
            <div class="flex items-center gap-2">
                <button type="submit" class="flex-1 py-2.5 px-4 rounded-xl bg-brand-500 hover:bg-brand-400 font-semibold text-white text-xs transition-colors flex items-center justify-center gap-2 cursor-pointer shadow-md shadow-brand-500/20">
                    <i class="fa-solid fa-filter text-[11px]"></i>
                    <span>Filtrar</span>
                </button>
                @if(request()->hasAny(['search', 'status', 'plan_id']))
                    <a href="{{ route('admin.tenants.index') }}" class="p-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white text-xs transition-colors" title="Restablecer filtros">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tabla Completa de Tenants -->
    <div class="bg-slate-900/80 border border-slate-800/90 rounded-2xl backdrop-blur-xl overflow-hidden shadow-xl shadow-black/40">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-300">
                <thead class="bg-slate-950/70 border-b border-slate-800 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">
                    <tr>
                        <th class="py-4 px-4 sm:px-6">Proveedor ISP</th>
                        <th class="py-4 px-4">Subdominio / URL</th>
                        <th class="py-4 px-4">Contacto Principal</th>
                        <th class="py-4 px-4">Plan Actual</th>
                        <th class="py-4 px-4">Estado</th>
                        <th class="py-4 px-4">Registro / Trial</th>
                        <th class="py-4 px-4 sm:px-6 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 font-normal">
                    @forelse($tenants as $tenant)
                        @php
                            $sub = $tenant->currentSubscription;
                            $plan = $sub?->plan;
                        @endphp
                        <tr class="hover:bg-slate-800/30 transition-colors">
                            <!-- ISP Info -->
                            <td class="py-4 px-4 sm:px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-brand-600/30 to-indigoBrand-600/30 border border-brand-500/30 flex items-center justify-center text-brand-300 font-bold font-outfit shadow-sm">
                                        {{ strtoupper(substr($tenant->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-white text-sm tracking-tight">{{ $tenant->name }}</p>
                                        <p class="text-[11px] text-slate-500 font-mono">UUID: {{ $tenant->uuid }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- Subdominio -->
                            <td class="py-4 px-4 font-mono">
                                <a href="http://{{ $tenant->subdomain }}.mikrohn.com" target="_blank" class="px-2.5 py-1 rounded-md bg-slate-950 border border-slate-800 text-brand-400 hover:text-brand-300 font-medium inline-flex items-center gap-1.5 transition-colors">
                                    <span>{{ $tenant->subdomain }}.mikrohn.com</span>
                                    <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
                                </a>
                            </td>

                            <!-- Contacto -->
                            <td class="py-4 px-4">
                                <p class="font-medium text-slate-200">{{ $tenant->owner_name }}</p>
                                <p class="text-[11px] text-slate-400">{{ $tenant->email }}</p>
                                @if($tenant->phone)
                                    <p class="text-[10px] text-slate-500 mt-0.5"><i class="fa-solid fa-phone text-[9px] mr-1"></i>{{ $tenant->phone }}</p>
                                @endif
                            </td>

                            <!-- Plan -->
                            <td class="py-4 px-4">
                                @if($plan)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-indigoBrand-500/10 border border-indigoBrand-500/20 text-indigoBrand-300 font-medium">
                                        <i class="fa-solid fa-layer-group text-[10px]"></i>
                                        <span>{{ $plan->name }}</span>
                                    </span>
                                    <p class="text-[10px] text-slate-400 mt-1 font-mono">${{ number_format($plan->price, 0) }} USD/mes</p>
                                @else
                                    <span class="text-xs text-slate-500 italic">Sin suscripción</span>
                                @endif
                            </td>

                            <!-- Estado -->
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

                            <!-- Registro / Fechas -->
                            <td class="py-4 px-4 font-mono text-[11px]">
                                <p class="text-slate-300">{{ $tenant->created_at->format('d/m/Y') }}</p>
                                @if($tenant->trial_ends_at)
                                    <p class="text-[10px] text-amber-400/80">Trial hasta: {{ $tenant->trial_ends_at->format('d/m/Y') }}</p>
                                @endif
                            </td>

                            <!-- Acciones -->
                            <td class="py-4 px-4 sm:px-6 text-right">
                                <div class="inline-flex items-center gap-2">

                                    <!-- Botón Impersonar -->
                                    <a
                                        href="{{ route('admin.tenants.impersonate', $tenant) }}"
                                        class="px-2.5 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 hover:text-white border border-slate-700 text-[11px] font-medium transition-colors inline-flex items-center gap-1.5"
                                        title="Simular acceso a la consola del ISP"
                                    >
                                        <i class="fa-solid fa-arrow-right-to-bracket text-brand-400"></i>
                                        <span>Consola</span>
                                    </a>

                                    <!-- Alternar Estado -->
                                    <form action="{{ route('admin.tenants.toggle-status', $tenant) }}" method="POST" onsubmit="return confirm('¿Confirmas el cambio de estado para este tenant?');">
                                        @csrf
                                        @if($tenant->status === 'active')
                                            <button
                                                type="submit"
                                                class="px-2.5 py-1.5 rounded-lg bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 border border-rose-500/30 text-[11px] font-medium transition-colors inline-flex items-center gap-1 cursor-pointer"
                                                title="Suspender ISP"
                                            >
                                                <i class="fa-solid fa-ban text-[10px]"></i>
                                                <span>Suspender</span>
                                            </button>
                                        @else
                                            <button
                                                type="submit"
                                                class="px-2.5 py-1.5 rounded-lg bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 text-[11px] font-medium transition-colors inline-flex items-center gap-1 cursor-pointer"
                                                title="Activar ISP"
                                            >
                                                <i class="fa-solid fa-play text-[10px]"></i>
                                                <span>Activar</span>
                                            </button>
                                        @endif
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-500">
                                <p class="text-sm font-medium text-slate-300">No hay tenants registrados</p>
                                <p class="text-xs text-slate-500 mt-1">Los registros realizados desde la landing aparecerán automáticamente aquí.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($tenants->hasPages())
            <div class="p-4 border-t border-slate-800/80 bg-slate-950/40">
                {{ $tenants->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
