<?php

namespace App\Http\Controllers;

use App\Models\SaasPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class LandingController extends Controller
{
    /**
     * Muestra la Landing Page principal del SaaS con los planes dinámicos.
     */
    public function index()
    {
        $plans = collect();

        // Verificamos si la tabla de planes existe para evitar errores si aún no se ejecutan migraciones
        try {
            if (Schema::hasTable('saas_plans')) {
                $plans = SaasPlan::where('is_active', true)->orderBy('price', 'asc')->get();
            }
        } catch (\Throwable $e) {
            // Silencioso: se usarán planes predeterminados en la vista
        }

        // Si aún no hay planes en BD, cargamos planes de respaldo visuales
        if ($plans->isEmpty()) {
            $plans = collect([
                (object)[
                    'id' => 1,
                    'name' => 'Plan Básico (WISP Inicio)',
                    'slug' => 'basico',
                    'price' => 29.00,
                    'currency' => 'USD',
                    'billing_interval' => 'monthly',
                    'max_routers' => 2,
                    'max_clients' => 250,
                    'features' => [
                        'Hasta 2 Routers MikroTik sincronizados',
                        'Hasta 250 clientes activos gestionados',
                        'Cortes y reconexiones automáticas por morosidad',
                        'Aviso de suspensión en pantalla (Portal Cautivo)',
                        'Control de ancho de banda con Simple Queues',
                        'Soporte técnico estándar por correo',
                    ],
                ],
                (object)[
                    'id' => 2,
                    'name' => 'Plan Profesional (WISP Pro)',
                    'slug' => 'profesional',
                    'price' => 59.00,
                    'currency' => 'USD',
                    'billing_interval' => 'monthly',
                    'max_routers' => 6,
                    'max_clients' => 800,
                    'features' => [
                        'Hasta 6 Routers MikroTik sincronizados',
                        'Hasta 800 clientes activos gestionados',
                        'Cortes instantáneos en milisegundos vía API MikroTik',
                        'Recordatorios de pago automáticos por WhatsApp',
                        'Portal de autoservicio para el cliente final',
                        'Control avanzado de velocidad, ráfagas (Burst) y PCQ',
                        'Soporte prioritario por WhatsApp y Tickets',
                    ],
                ],
                (object)[
                    'id' => 3,
                    'name' => 'Plan Enterprise (ISP Master)',
                    'slug' => 'enterprise',
                    'price' => 119.00,
                    'currency' => 'USD',
                    'billing_interval' => 'monthly',
                    'max_routers' => 20,
                    'max_clients' => 3000,
                    'features' => [
                        'Hasta 20 Routers MikroTik y Balanceadores de Carga',
                        'Hasta 3,000 clientes activos con alta concurrencia',
                        'Soporte para múltiples sucursales y zonas WISP',
                        'Balanceo PCC, Failover y monitoreo de enlaces WAN',
                        'Auditoría completa de cambios en RouterOS y personal',
                        'Respaldos automáticos encriptados en la nube (.backup)',
                        'Soporte VIP 24/7 con canal directo de ingeniería',
                    ],
                ],
            ]);
        }

        return view('landing', compact('plans'));
    }
}
