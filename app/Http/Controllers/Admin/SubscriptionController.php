<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SaasPlan;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubscriptionController extends Controller
{
    /**
     * Listado de suscripciones y estados de pago.
     */
    public function index(Request $request): View
    {
        $query = Subscription::with(['tenant', 'plan', 'invoices']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('tenant', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('subdomain', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('plan_id')) {
            $query->where('saas_plan_id', $request->plan_id);
        }

        $subscriptions = $query->latest()->paginate(15)->withQueryString();

        $metrics = [
            'total' => Subscription::count(),
            'active' => Subscription::where('status', 'active')->count(),
            'past_due' => Subscription::where('status', 'past_due')->count(),
            'canceled' => Subscription::where('status', 'canceled')->count(),
        ];

        $plans = SaasPlan::all();

        return view('admin.subscriptions.index', compact('subscriptions', 'metrics', 'plans'));
    }
}
