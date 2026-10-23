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
        Schema::create('unit_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('price_list_id')->constrained('price_lists');
            $table->foreignId('item_detail_id')->constrained('item_details');
            $table->boolean('isFreeIssueMaterial')->default(false);
            $table->timestamps();
            $table->unique(['price_list_id', 'item_detail_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_prices');
    }
};
