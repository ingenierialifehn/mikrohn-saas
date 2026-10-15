@extends('layouts.admin')

@section('title', 'Catálogo de Planes SaaS')
@section('header_title', 'Catálogo de Planes SaaS')

@section('content')
<div class="space-y-6">

    <!-- Encabezado -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold font-outfit text-white tracking-tight">Catálogo y Edición de Planes SaaS</h1>
            <p class="text-xs text-slate-400 mt-1">Configura los límites técnicos de MikroTik, cuotas de clientes y precios ofertados en la landing.</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="px-3 py-1.5 rounded-xl bg-slate-900 border border-slate-800 text-xs font-mono text-brand-300">
                Planes Disponibles: <strong>{{ $plans->count() }}</strong>
            </span>
        </div>
    </div>

    <!-- Grid de Planes -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($plans as $plan)
            <div class="bg-slate-900/80 border {{ $plan->is_active ? 'border-slate-800/90' : 'border-rose-900/40 opacity-75' }} rounded-2xl p-6 backdrop-blur-xl flex flex-col justify-between relative group hover:border-brand-500/50 transition-all shadow-xl shadow-black/40">

                <!-- Header de Tarjeta -->
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-2.5 py-1 rounded-md bg-slate-950 border border-slate-800 text-brand-400 text-xs font-mono font-bold uppercase tracking-wider">
                            {{ $plan->slug }}
                        </span>
                        <div class="flex items-center gap-2">
                            @if($plan->is_active)
                                <span class="px-2 py-0.5 rounded-full bg-emerald-500/15 border border-emerald-500/30 text-emerald-400 text-[10px] font-semibold">
                                    Público
                                </span>
                            @else
                                <span class="px-2 py-0.5 rounded-full bg-rose-500/15 border border-rose-500/30 text-rose-400 text-[10px] font-semibold">
                                    Desactivado
                                </span>
                            @endif
                        </div>
                    </div>

                    <h3 class="font-outfit font-extrabold text-xl text-white tracking-tight">{{ $plan->name }}</h3>

                    <!-- Precio -->
                    <div class="mt-3 mb-5 flex items-baseline gap-1.5">
                        <span class="font-outfit text-4xl font-black text-white font-mono">${{ number_format($plan->price, 0) }}</span>
                        <span class="text-xs text-slate-400 font-medium">USD / {{ $plan->billing_interval === 'yearly' ? 'año' : 'mes' }}</span>
                    </div>

                    <!-- Métricas Técnicas MikroTik -->
                    <div class="p-3.5 rounded-xl bg-slate-950/70 border border-slate-800/80 space-y-2 text-xs mb-5">
                        <div class="flex items-center justify-between text-slate-300">
                            <span class="flex items-center gap-2 text-slate-400">
                                <i class="fa-solid fa-microchip text-brand-400 text-[11px]"></i>
                                Routers MikroTik:
                            </span>
                            <span class="font-bold text-white font-mono">{{ $plan->max_routers }}</span>
                        </div>
                        <div class="flex items-center justify-between text-slate-300">
                            <span class="flex items-center gap-2 text-slate-400">
                                <i class="fa-solid fa-users text-indigoBrand-400 text-[11px]"></i>
                                Límite de Clientes:
                            </span>
                            <span class="font-bold text-white font-mono">{{ number_format($plan->max_clients) }}</span>
                        </div>
                        <div class="flex items-center justify-between text-slate-300">
                            <span class="flex items-center gap-2 text-slate-400">
                                <i class="fa-solid fa-circle-check text-emerald-400 text-[11px]"></i>
                                Suscripciones Activas:
                            </span>
                            <span class="font-bold text-emerald-400 font-mono">{{ $plan->subscriptions_count }}</span>
                        </div>
                    </div>

                    <!-- Lista de Funcionalidades -->
                    <div class="space-y-2 mb-6">
                        <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Funcionalidades:</p>
                        <ul class="space-y-1.5 text-xs text-slate-300">
                            @if(is_array($plan->features))
                                @foreach($plan->features as $feature)
                                    <li class="flex items-start gap-2">
                                        <i class="fa-solid fa-check text-emerald-400 text-[11px] mt-0.5"></i>
                                        <span class="leading-relaxed">{{ $feature }}</span>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="pt-4 border-t border-slate-800/80 flex items-center gap-2.5">
                    <button
                        type="button"
                        onclick="openEditPlanModal({{ json_encode($plan) }})"
                        class="flex-1 py-2.5 px-3 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 hover:text-white border border-slate-700 text-xs font-semibold transition-colors flex items-center justify-center gap-2 cursor-pointer"
                    >
                        <i class="fa-solid fa-pen-to-square text-brand-400"></i>
                        <span>Editar Plan</span>
                    </button>

                    <form action="{{ route('admin.plans.toggle-active', $plan) }}" method="POST">
                        @csrf
                        @if($plan->is_active)
                            <button
                                type="submit"
                                class="p-2.5 rounded-xl bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 border border-rose-500/30 text-xs transition-colors cursor-pointer"
                                title="Desactivar plan de la landing"
                            >
                                <i class="fa-solid fa-eye-slash"></i>
                            </button>
                        @else
                            <button
                                type="submit"
                                class="p-2.5 rounded-xl bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 text-xs transition-colors cursor-pointer"
                                title="Activar plan en la landing"
                            >
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        @endif
                    </form>
                </div>

            </div>
        @endforeach
    </div>

</div>

<!-- Modal para Edición Rápida de Plan -->
<div id="edit-plan-modal" class="fixed inset-0 z-50 bg-black/80 backdrop-blur-md hidden flex items-center justify-center p-4">
    <div class="bg-slate-900 border border-slate-800 rounded-2xl w-full max-w-lg p-6 sm:p-8 relative shadow-2xl overflow-y-auto max-h-[90vh]">
        <div class="flex items-center justify-between pb-4 border-b border-slate-800 mb-5">
            <h3 class="font-outfit font-bold text-lg text-white flex items-center gap-2">
                <i class="fa-solid fa-pen-to-square text-brand-400"></i>
                <span id="modal-plan-title">Editar Plan SaaS</span>
            </h3>
            <button onclick="closeEditPlanModal()" class="text-slate-400 hover:text-white p-1">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <form id="edit-plan-form" method="POST" action="" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- Nombre -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Nombre Comercial del Plan *</label>
                <input type="text" name="name" id="modal-plan-name" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-brand-500">
            </div>

            <!-- Precio y Moneda -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Precio *</label>
                    <input type="number" step="0.01" min="0" name="price" id="modal-plan-price" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3.5 py-2.5 text-xs text-white font-mono focus:outline-none focus:border-brand-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Moneda *</label>
                    <select name="currency" id="modal-plan-currency" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-brand-500">
                        <option value="USD">USD ($)</option>
                        <option value="HNL">HNL (L)</option>
                    </select>
                </div>
            </div>

            <!-- Ciclo de Facturación -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Intervalo de Cobro *</label>
                <select name="billing_interval" id="modal-plan-interval" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-brand-500">
                    <option value="monthly">Mensual</option>
                    <option value="yearly">Anual</option>
                </select>
            </div>

            <!-- Límites Técnicos -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Máx. Routers MikroTik *</label>
                    <input type="number" min="1" name="max_routers" id="modal-plan-routers" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3.5 py-2.5 text-xs text-white font-mono focus:outline-none focus:border-brand-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Máx. Clientes Finales *</label>
                    <input type="number" min="1" name="max_clients" id="modal-plan-clients" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3.5 py-2.5 text-xs text-white font-mono focus:outline-none focus:border-brand-500">
                </div>
            </div>

            <!-- Lista de Funcionalidades (una por línea) -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">
                    Funcionalidades (una por línea)
                </label>
                <textarea name="features" id="modal-plan-features" rows="5" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-brand-500 leading-relaxed font-sans"></textarea>
            </div>

            <!-- Estado Activo -->
            <div class="flex items-center gap-2 pt-1">
                <input type="checkbox" name="is_active" id="modal-plan-active" value="1" class="w-4 h-4 rounded bg-slate-950 border-slate-700 text-brand-500 focus:ring-brand-500">
                <label for="modal-plan-active" class="text-xs text-slate-300 cursor-pointer">Plan visible y activo para contratación pública</label>
            </div>

            <!-- Botones -->
            <div class="pt-4 border-t border-slate-800 flex items-center justify-end gap-3">
                <button type="button" onclick="closeEditPlanModal()" class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-semibold transition-colors">
                    Cancelar
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-brand-500 to-indigoBrand-600 hover:from-brand-400 hover:to-indigoBrand-500 font-semibold text-white text-xs shadow-lg shadow-brand-500/20 transition-all cursor-pointer">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditPlanModal(plan) {
        document.getElementById('modal-plan-title').innerText = 'Editar Plan: ' + plan.name;
        document.getElementById('edit-plan-form').action = '/admin/plans/' + plan.id;
        document.getElementById('modal-plan-name').value = plan.name;
        document.getElementById('modal-plan-price').value = plan.price;
        document.getElementById('modal-plan-currency').value = plan.currency;
        document.getElementById('modal-plan-interval').value = plan.billing_interval;
        document.getElementById('modal-plan-routers').value = plan.max_routers;
        document.getElementById('modal-plan-clients').value = plan.max_clients;
        document.getElementById('modal-plan-active').checked = Boolean(plan.is_active);

        const features = Array.isArray(plan.features) ? plan.features.join('\n') : '';
        document.getElementById('modal-plan-features').value = features;

        document.getElementById('edit-plan-modal').classList.remove('hidden');
    }

    function closeEditPlanModal() {
        document.getElementById('edit-plan-modal').classList.add('hidden');
    }
</script>
@endsection
