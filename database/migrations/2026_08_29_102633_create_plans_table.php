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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boq_id')->constrained();
            $table->string('section')->nullable(false);
            $table->string('category')->nullable(true);
            $table->string('sub_category')->nullable(true);
            $table->string('item_detail')->nullable(false);
            $table->string('unit')->nullable(false);

            $table->decimal('volume', 15, 2);
            $table->decimal('unit_price', 15, 2)->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
