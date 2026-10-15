<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SaasPlan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PlanController extends Controller
{
    /**
     * Catálogo de planes SaaS y estadísticas de adopción.
     */
    public function index(): View
    {
        $plans = SaasPlan::withCount(['subscriptions' => function ($q) {
            $q->where('status', 'active');
        }])->get();

        return view('admin.plans.index', compact('plans'));
    }

    /**
     * Edición rápida de parámetros de un plan SaaS.
     */
    public function update(Request $request, SaasPlan $plan): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'price' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'in:USD,HNL'],
            'billing_interval' => ['required', 'in:monthly,yearly'],
            'max_routers' => ['required', 'integer', 'min:1'],
            'max_clients' => ['required', 'integer', 'min:1'],
            'features' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $features = $request->filled('features')
            ? array_filter(array_map('trim', explode("\n", str_replace("\r", "", $request->features))))
            : ($plan->features ?? []);

        $plan->update([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'currency' => $validated['currency'],
            'billing_interval' => $validated['billing_interval'],
            'max_routers' => $validated['max_routers'],
            'max_clients' => $validated['max_clients'],
            'features' => array_values($features),
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with('success', "El plan \"{$plan->name}\" se actualizó exitosamente.");
    }

    /**
     * Alternar estado activo/inactivo del plan.
     */
    public function toggleActive(SaasPlan $plan): RedirectResponse
    {
        $plan->update(['is_active' => !$plan->is_active]);

        $status = $plan->is_active ? 'activado' : 'desactivado';
        return back()->with('success', "El plan \"{$plan->name}\" ha sido {$status}.");
    }
}
