<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('saas_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->decimal('price', 10, 2);
            $table->string('currency', 5)->default('USD')->comment('USD o HNL');
            $table->enum('billing_interval', ['monthly', 'yearly'])->default('monthly');
            $table->unsignedInteger('max_routers')->default(1);
            $table->unsignedInteger('max_clients')->default(100);
            $table->json('features')->comment('Lista de funcionalidades en formato JSON');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saas_plans');
    }
};
