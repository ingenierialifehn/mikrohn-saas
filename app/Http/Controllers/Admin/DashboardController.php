<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SaasInvoice;
use App\Models\SaasPlan;
use App\Models\Subscription;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Muestra el resumen y métricas generales del SaaS.
     */
    public function index(Request $request): View
    {
        $totalTenants = Tenant::count();
        $activeSubscriptions = Subscription::where('status', 'active')->count();
        $trialTenants = Tenant::where('status', 'trial')->count();
        $suspendedTenants = Tenant::where('status', 'suspended')->count();

        // Cálculo de MRR (Ingresos Mensuales Recurrentes Estimados)
        $mrr = Subscription::where('subscriptions.status', 'active')
            ->join('saas_plans', 'subscriptions.saas_plan_id', '=', 'saas_plans.id')
            ->sum('saas_plans.price');

        // Total facturado histórico
        $totalInvoiced = SaasInvoice::where('status', 'paid')->sum('amount');

        // Búsqueda rápida o filtro opcional en dashboard
        $query = Tenant::with(['currentSubscription.plan']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('subdomain', 'like', "%{$search}%")
                  ->orWhere('owner_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && in_array($request->status, ['trial', 'active', 'suspended'])) {
            $query->where('status', $request->status);
        }

        $tenants = $query->latest()->paginate(10)->withQueryString();

        // Planes disponibles con conteo para widget
        $plans = SaasPlan::withCount(['subscriptions' => function ($q) {
            $q->where('status', 'active');
        }])->get();

        return view('admin.dashboard', compact(
            'totalTenants',
            'activeSubscriptions',
            'trialTenants',
            'suspendedTenants',
            'mrr',
            'totalInvoiced',
            'tenants',
            'plans'
        ));
    }
}
