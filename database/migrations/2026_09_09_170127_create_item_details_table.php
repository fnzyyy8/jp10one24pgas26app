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
        Schema::create('item_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('section_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('category_id')
                ->nullable()
                ->constrained('categories')
                ->nullOnDelete();

            $table->foreignId('sub_category_id')
                ->nullable()
                ->constrained('sub_categories')
                ->nullOnDelete();

            $table->string('name');
            $table->string('unit');

            $table->unsignedInteger('sort_order')->default(0);

            $table->index([
                'section_id',
                'sort_order'
            ]);

            $table->index(
                [
                    'category_id',
                    'sort_order'
                ]
            );

            $table->index([
                'sub_category_id',
                'sort_order'
            ]);


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_details');
    }
};
