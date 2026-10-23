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
        Schema::create('worker_work_scope', function (Blueprint $table) {
            $table->id();

            $table->foreignId('worker_id')->constrained('workers')->cascadeOnDelete();

            $table->foreignId('work_scope_id')->constrained('work_scopes')->cascadeOnDelete();

            $table->unique(['worker_id', 'work_scope_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('worker_work_scope');
    }
};
