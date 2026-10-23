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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('position', [
                'head division',
                'project manager',
                'project control',
                'administration and contract',
                'finance',
                'hsse',
                'qaqc',
                'engineering',
                'general affair',
                'procurement',
                'logistic',
                'admin',
                'others'
            ])->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('position', [
                'Project Control',
                'Administration and Contract',
                'Finance',
                'HSSE',
                'QAQC',
                'Engineering',
                'General Affair',
                'Procurement',
                'Logistic',
                'Others'
            ])->nullable(false)->change();
        });
    }
};
