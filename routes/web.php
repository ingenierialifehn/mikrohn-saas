<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\TenantRegistrationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - MikroHN SaaS
|--------------------------------------------------------------------------
| Rutas públicas del portal de MikroHN SaaS y registro de clientes WISP.
*/

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::post('/register-tenant', [TenantRegistrationController::class, 'store'])->name('tenant.register');
