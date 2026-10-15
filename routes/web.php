<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\TenantController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\TenantRegistrationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - MikroHN SaaS
|--------------------------------------------------------------------------
| Portal público, autenticación administrativa por username y panel SaaS.
*/

// Portal Público & Landing Page
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::post('/register-tenant', [TenantRegistrationController::class, 'store'])->name('tenant.register');

// Autenticación de Administradores (Username / Password)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Panel Administrativo del SaaS (Protegido por Middleware Auth)
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Gestión de Tenants / ISPs
    Route::get('/tenants', [TenantController::class, 'index'])->name('tenants.index');
    Route::post('/tenants/{tenant}/toggle-status', [TenantController::class, 'toggleStatus'])->name('tenants.toggle-status');
    Route::get('/tenants/{tenant}/impersonate', [TenantController::class, 'impersonate'])->name('tenants.impersonate');

    // Gestión de Suscripciones y Pagos
    Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');

    // Catálogo y Edición Rápida de Planes
    Route::get('/plans', [PlanController::class, 'index'])->name('plans.index');
    Route::put('/plans/{plan}', [PlanController::class, 'update'])->name('plans.update');
    Route::post('/plans/{plan}/toggle-active', [PlanController::class, 'toggleActive'])->name('plans.toggle-active');
});
