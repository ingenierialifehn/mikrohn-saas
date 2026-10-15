@extends('layouts.admin')

@section('title', 'Suscripciones y Facturación')
@section('header_title', 'Suscripciones y Facturación')

@section('content')
<div class="space-y-6">

    <!-- Encabezado -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold font-outfit text-white tracking-tight">Gestión de Suscripciones SaaS</h1>
            <p class="text-xs text-slate-400 mt-1">Supervisa los periodos de facturación, pasarelas de pago y estados de cobranza de los ISPs.</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="px-3 py-1.5 rounded-xl bg-slate-900 border border-slate-800 text-xs font-mono text-emerald-400">
                Suscripciones Activas: <strong>{{ $metrics['active'] }}</strong>
            </span>
        </div>
    </div>

    <!-- 4 Métricas de Suscripción -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="p-4 rounded-xl bg-slate-900/80 border border-slate-800">
            <span class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Total Suscripciones</span>
            <p class="text-2xl font-bold font-outfit text-white mt-1">{{ number_format($metrics['total']) }}</p>
            <p class="text-[11px] text-slate-500 mt-0.5">Historial acumulado</p>
        </div>
        <div class="p-4 rounded-xl bg-slate-900/80 border border-emerald-500/30">
            <span class="text-[11px] font-medium text-emerald-400 uppercase tracking-wider">Activas / Al Día</span>
            <p class="text-2xl font-bold font-outfit text-emerald-400 mt-1">{{ number_format($metrics['active']) }}</p>
            <p class="text-[11px] text-emerald-500/70 mt-0.5">Generando ingresos recurrentes</p>
        </div>
        <div class="p-4 rounded-xl bg-slate-900/80 border border-amber-500/30">
            <span class="text-[11px] font-medium text-amber-400 uppercase tracking-wider">En Mora / Past Due</span>
            <p class="text-2xl font-bold font-outfit text-amber-400 mt-1">{{ number_format($metrics['past_due']) }}</p>
            <p class="text-[11px] text-amber-500/70 mt-0.5">Pendientes de confirmación</p>
        </div>
        <div class="p-4 rounded-xl bg-slate-900/80 border border-rose-500/30">
            <span class="text-[11px] font-medium text-rose-400 uppercase tracking-wider">Canceladas</span>
            <p class="text-2xl font-bold font-outfit text-rose-400 mt-1">{{ number_format($metrics['canceled']) }}</p>
            <p class="text-[11px] text-rose-500/70 mt-0.5">Bajas de servicio</p>
        </div>
    </div>

    <!-- Filtros -->
    <div class="bg-slate-900/80 border border-slate-800/90 rounded-2xl p-4 sm:p-5 backdrop-blur-xl">
        <form method="GET" action="{{ route('admin.subscriptions.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-500 text-xs"></i>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Buscar por ISP o subdominio..."
                    class="w-full bg-slate-950/90 border border-slate-800 rounded-xl pl-9 pr-3 py-2.5 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-brand-500 transition-colors"
                >
            </div>

            <div>
                <select name="status" onchange="this.form.submit()" class="w-full bg-slate-950/90 border border-slate-800 rounded-xl px-3 py-2.5 text-xs text-slate-300 focus:outline-none focus:border-brand-500 transition-colors">
                    <option value="">Todos los Estados</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Activas</option>
                    <option value="past_due" {{ request('status') === 'past_due' ? 'selected' : '' }}>En Mora (Past Due)</option>
                    <option value="canceled" {{ request('status') === 'canceled' ? 'selected' : '' }}>Canceladas</option>
                </select>
            </div>

            <div class="flex items-center gap-2">
                <select name="plan_id" onchange="this.form.submit()" class="flex-1 bg-slate-950/90 border border-slate-800 rounded-xl px-3 py-2.5 text-xs text-slate-300 focus:outline-none focus:border-brand-500 transition-colors">
                    <option value="">Todos los Planes</option>
                    @foreach($plans as $p)
                        <option value="{{ $p->id }}" {{ request('plan_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                    @endforeach
                </select>

                @if(request()->hasAny(['search', 'status', 'plan_id']))
                    <a href="{{ route('admin.subscriptions.index') }}" class="p-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white text-xs transition-colors" title="Restablecer">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tabla de Suscripciones -->
    <div class="bg-slate-900/80 border border-slate-800/90 rounded-2xl backdrop-blur-xl overflow-hidden shadow-xl shadow-black/40">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-300">
                <thead class="bg-slate-950/70 border-b border-slate-800 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">
                    <tr>
                        <th class="py-4 px-4 sm:px-6">Tenant / ISP</th>
                        <th class="py-4 px-4">Plan SaaS</th>
                        <th class="py-4 px-4">Periodo de Facturación</th>
                        <th class="py-4 px-4">Método de Pago</th>
                        <th class="py-4 px-4">Estado</th>
                        <th class="py-4 px-4 sm:px-6 text-right">Facturas Asociadas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 font-normal">
                    @forelse($subscriptions as $subscription)
                        <tr class="hover:bg-slate-800/30 transition-colors">
                            <!-- Tenant -->
                            <td class="py-4 px-4 sm:px-6">
                                <p class="font-semibold text-white text-sm">{{ $subscription->tenant?->name ?? 'ISP Desconocido' }}</p>
                                <p class="text-[11px] text-slate-500 font-mono">{{ $subscription->tenant?->subdomain }}.mikrohn.com</p>
                            </td>

                            <!-- Plan -->
                            <td class="py-4 px-4">
                                <span class="font-semibold text-brand-300">{{ $subscription->plan?->name ?? 'Plan Personalizado' }}</span>
                                <p class="text-[11px] text-slate-400 font-mono">${{ number_format($subscription->plan?->price ?? 0, 2) }} {{ $subscription->plan?->currency ?? 'USD' }} / {{ $subscription->plan?->billing_interval === 'yearly' ? 'año' : 'mes' }}</p>
                            </td>

                            <!-- Fechas -->
                            <td class="py-4 px-4 font-mono text-[11px]">
                                <p class="text-slate-200">
                                    {{ $subscription->current_period_start ? $subscription->current_period_start->format('d/m/Y') : 'N/A' }} 
                                    <span class="text-slate-500">→</span> 
                                    {{ $subscription->current_period_end ? $subscription->current_period_end->format('d/m/Y') : 'N/A' }}
                                </p>
                                @if($subscription->current_period_end)
                                    <p class="text-[10px] text-slate-500">Vence: {{ $subscription->current_period_end->diffForHumans() }}</p>
                                @endif
                            </td>

                            <!-- Método de Pago -->
                            <td class="py-4 px-4">
                                <p class="font-medium text-slate-300 flex items-center gap-1.5">
                                    <i class="fa-solid fa-credit-card text-slate-500 text-[10px]"></i>
                                    <span>{{ $subscription->payment_method ?? 'Pasarela Integrada' }}</span>
                                </p>
                                @if($subscription->gateway_subscription_id)
                                    <p class="text-[10px] text-slate-500 font-mono truncate max-w-[150px]">Ref: {{ $subscription->gateway_subscription_id }}</p>
                                @endif
                            </td>

                            <!-- Estado -->
                            <td class="py-4 px-4">
                                @if($subscription->status === 'active')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/25 text-emerald-400 text-[11px] font-semibold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                        Activa
                                    </span>
                                @elseif($subscription->status === 'past_due')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-500/10 border border-amber-500/25 text-amber-400 text-[11px] font-semibold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                        En Mora
                                    </span>
                                @elseif($subscription->status === 'canceled')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-rose-500/10 border border-rose-500/25 text-rose-400 text-[11px] font-semibold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                                        Cancelada
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-slate-800 text-slate-400 text-[11px]">
                                        {{ ucfirst($subscription->status) }}
                                    </span>
                                @endif
                            </td>

                            <!-- Facturas / Recibos -->
                            <td class="py-4 px-4 sm:px-6 text-right">
                                <span class="px-2.5 py-1 rounded-lg bg-slate-800 border border-slate-700/80 text-slate-300 font-mono text-[11px]">
                                    {{ $subscription->invoices->count() }} Factura(s)
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-500">
                                <p class="text-sm font-medium text-slate-300">No hay suscripciones registradas</p>
                                <p class="text-xs text-slate-500 mt-1">Las suscripciones activas de los clientes se reflejarán en este módulo.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($subscriptions->hasPages())
            <div class="p-4 border-t border-slate-800/80 bg-slate-950/40">
                {{ $subscriptions->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
