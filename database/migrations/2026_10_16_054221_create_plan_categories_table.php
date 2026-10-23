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
        Schema::create('plan_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->enum('scope', ['RT', 'PK', 'KI'])->default('RT');
        });

        Schema::table('plans', function (Blueprint $table) {
            $table->foreignId('plan_category_id')
                ->nullable()
                ->after('unit_price_id')
                ->constrained('plan_categories')
                ->nullOnDelete();
        });

        Schema::table('unit_prices', function (Blueprint $table) {
            $table->enum('scope', ['RT', 'PK', 'KI'])->default('RT');
        });

        Schema::table('item_details', function (Blueprint $table) {
            $table->enum('scope', ['RT', 'PK', 'KI'])->default('RT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropForeign('plans_plan_category_id_foreign');
            $table->dropColumn('plan_category_id');
        });

        Schema::dropIfExists('plan_categories');

        Schema::table('unit_prices', function (Blueprint $table) {
            $table->dropColumn('scope');
        });

        Schema::table('item_details', function (Blueprint $table) {
            $table->dropColumn('scope');
        });
    }
};
