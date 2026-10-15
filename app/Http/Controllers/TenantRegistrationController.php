<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\SaasPlan;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TenantRegistrationController extends Controller
{
    /**
     * Procesa el registro rápido de un nuevo ISP (Tenant) en período de prueba gratuito.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'subdomain' => [
                'required',
                'string',
                'alpha_dash',
                'min:3',
                'max:50',
                'unique:tenants,subdomain'
            ],
            'owner_name' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:tenants,email',
            'phone' => 'nullable|string|max:30',
            'saas_plan_id' => 'required|exists:saas_plans,id',
        ], [
            'subdomain.unique' => 'El subdominio solicitado ya está en uso por otro ISP. Por favor elige otro.',
            'subdomain.alpha_dash' => 'El subdominio solo puede contener letras, números y guiones.',
            'email.unique' => 'Ya existe una cuenta registrada con este correo electrónico.',
            'saas_plan_id.exists' => 'El plan seleccionado no es válido.',
        ]);

        try {
            DB::beginTransaction();

            // Creación del nuevo Tenant en prueba de 15 días
            $tenant = Tenant::create([
                'uuid' => (string) Str::uuid(),
                'name' => $validated['name'],
                'subdomain' => strtolower($validated['subdomain']),
                'owner_name' => $validated['owner_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'status' => 'trial',
                'trial_ends_at' => now()->addDays(15),
            ]);

            // Asignación de suscripción inicial en período de prueba
            Subscription::create([
                'tenant_id' => $tenant->id,
                'saas_plan_id' => $validated['saas_plan_id'],
                'status' => 'active',
                'current_period_start' => now(),
                'current_period_end' => now()->addDays(15),
                'payment_method' => 'Prueba Gratuita (15 días)',
                'gateway_subscription_id' => 'trial_' . Str::random(12),
            ]);

            DB::commit();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => '¡Tu espacio de MikroHN ha sido creado con éxito! Tienes 15 días de prueba completa.',
                    'tenant' => [
                        'name' => $tenant->name,
                        'subdomain' => $tenant->subdomain,
                        'url' => 'http://' . $tenant->subdomain . '.mikrohn.test:8085',
                    ],
                ]);
            }

            return redirect()->route('landing')->with('success', '¡Felicitaciones! El espacio para "' . $tenant->name . '" ha sido reservado. Tu subdominio es: ' . $tenant->subdomain . '.mikrohn.com');
        } catch (\Throwable $e) {
            DB::rollBack();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ocurrió un error al procesar el registro: ' . $e->getMessage(),
                ], 500);
            }

            return back()->withInput()->withErrors(['error' => 'No se pudo completar el registro: ' . $e->getMessage()]);
        }
    }
}
