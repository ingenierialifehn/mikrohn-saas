<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SaasPlan;
use App\Models\Tenant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TenantController extends Controller
{
    /**
     * Listado y gestión completa de ISPs/Tenants registrados.
     */
    public function index(Request $request): View
    {
        $query = Tenant::with(['currentSubscription.plan', 'invoices']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('subdomain', 'like', "%{$search}%")
                  ->orWhere('owner_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('plan_id')) {
            $query->whereHas('currentSubscription', function ($q) use ($request) {
                $q->where('saas_plan_id', $request->plan_id);
            });
        }

        $tenants = $query->latest()->paginate(15)->withQueryString();
        $plans = SaasPlan::all();

        return view('admin.tenants.index', compact('tenants', 'plans'));
    }

    /**
     * Alterna o actualiza el estado del tenant (Activar / Suspender).
     */
    public function toggleStatus(Request $request, Tenant $tenant): RedirectResponse
    {
        if ($request->filled('status') && in_array($request->status, ['active', 'suspended', 'trial', 'cancelled'])) {
            $newStatus = $request->status;
        } else {
            // Toggle dinámico
            $newStatus = match ($tenant->status) {
                'active' => 'suspended',
                'suspended' => 'active',
                'trial' => 'active',
                default => 'active',
            };
        }

        $tenant->update(['status' => $newStatus]);

        // Sincronizar estado de suscripción si existe
        if ($tenant->currentSubscription) {
            $subscriptionStatus = match ($newStatus) {
                'active' => 'active',
                'suspended' => 'past_due',
                'cancelled' => 'canceled',
                default => 'active',
            };
            $tenant->currentSubscription->update(['status' => $subscriptionStatus]);
        }

        $statusLabel = match ($newStatus) {
            'active' => 'Activado',
            'suspended' => 'Suspendido',
            'trial' => 'en Periodo de Prueba',
            'cancelled' => 'Cancelado',
            default => $newStatus,
        };

        return back()->with('success', "El ISP \"{$tenant->name}\" ahora se encuentra {$statusLabel}.");
    }

    /**
     * Simulación de impersonación / acceso directo a la consola del ISP.
     */
    public function impersonate(Tenant $tenant): RedirectResponse
    {
        session()->flash('impersonating_tenant', [
            'id' => $tenant->id,
            'name' => $tenant->name,
            'subdomain' => $tenant->subdomain,
            'owner_name' => $tenant->owner_name,
            'email' => $tenant->email,
        ]);

        return back()->with('info', "Simulando sesión del ISP \"{$tenant->name}\" ({$tenant->subdomain}.mikrohn.com). Modo impersonación administrativo activado.");
    }
}
