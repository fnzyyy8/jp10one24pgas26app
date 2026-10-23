<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('plan_details');
        Schema::dropIfExists('plans');

        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boq_id')->constrained('boqs')->cascadeOnDelete();
            $table->foreignId('unit_price_id')->constrained('unit_prices')->cascadeOnDelete();
            $table->decimal('volume', 15, 2)->nullable();
            $table->timestamps();
        });

        Schema::create('plan_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')->references('id')->on('plans')->onDelete('cascade');
            $table->date('plan_date');
            $table->decimal('plan_volume', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_details');
        Schema::dropIfExists('plans');
    }
};
