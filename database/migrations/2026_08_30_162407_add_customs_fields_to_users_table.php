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
            $table->enum('division', ['Site', 'PSCM'])->default('PSCM')->after('email');
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
            ])->after('division');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('division', 'position');
        });
    }
};
