<?php

namespace Database\Seeders;

use App\Models\SaasPlan;
use App\Models\Tenant;
use App\Models\Subscription;
use App\Models\SaasInvoice;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SaasPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
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
                    'Exportación de reportes de cobro en Excel y PDF',
                    'Soporte técnico por correo electrónico',
                ],
                'is_active' => true,
            ],
            [
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
                    'Cortes instantáneos en milisegundos vía API RouterOS',
                    'Recordatorios de pago automáticos por WhatsApp',
                    'Portal de autoservicio para el cliente final',
                    'Control avanzado de velocidad, ráfagas (Burst) y PCQ',
                    'Generación de recibos de caja y facturación térmica',
                    'Soporte prioritario por WhatsApp y Tickets',
                ],
                'is_active' => true,
            ],
            [
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
                    'Pasarelas de cobro online con confirmación en tiempo real',
                    'Auditoría completa de cambios en RouterOS y personal',
                    'Respaldos automáticos encriptados en la nube (.backup y .rsc)',
                    'Soporte VIP 24/7 con canal directo de ingeniería',
                ],
                'is_active' => true,
            ],
        ];

        foreach ($plans as $planData) {
            SaasPlan::updateOrCreate(
                ['slug' => $planData['slug']],
                $planData
            );
        }

        // Crear un Tenant de demostración inicial
        $proPlan = SaasPlan::where('slug', 'profesional')->first();

        $demoTenant = Tenant::firstOrCreate(
            ['subdomain' => 'demo-isp'],
            [
                'uuid' => (string) Str::uuid(),
                'name' => 'Demo WISP Networks',
                'owner_name' => 'Fernando Administrador',
                'email' => 'admin@demowisp.hn',
                'phone' => '+504 9900-1122',
                'status' => 'active',
                'trial_ends_at' => now()->addDays(15),
            ]
        );

        if ($proPlan && $demoTenant->subscriptions()->count() === 0) {
            $subscription = Subscription::create([
                'tenant_id' => $demoTenant->id,
                'saas_plan_id' => $proPlan->id,
                'status' => 'active',
                'current_period_start' => now(),
                'current_period_end' => now()->addMonth(),
                'payment_method' => 'Tarjeta de Crédito',
                'gateway_subscription_id' => 'sub_demo_mikrohn_123',
            ]);

            SaasInvoice::create([
                'tenant_id' => $demoTenant->id,
                'subscription_id' => $subscription->id,
                'amount' => $proPlan->price,
                'status' => 'paid',
                'payment_gateway' => 'stripe',
                'receipt_url' => 'https://mikrohn.com/receipts/demo_inv_001.pdf',
                'paid_at' => now(),
            ]);
        }
    }
}
