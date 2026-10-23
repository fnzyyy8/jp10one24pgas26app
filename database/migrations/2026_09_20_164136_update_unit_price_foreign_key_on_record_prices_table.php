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
        Schema::table('record_prices', function (Blueprint $table) {
            $table->dropforeign(['unit_price_id']);
            $table
                ->foreign('unit_price_id')->references('id')->on('unit_prices')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('record_prices', function (Blueprint $table) {
            $table->dropforeign(['unit_price_id']);
            $table->foreign('unit_price_id')->references('id')->on('unit_prices');
        });
    }
};
