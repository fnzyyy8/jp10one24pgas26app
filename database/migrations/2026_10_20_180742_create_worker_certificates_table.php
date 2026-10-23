
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('worker_certificates', function (Blueprint $table) {
            $table->id();

            $table->foreignId('worker_id')
                ->constrained('workers')
                ->cascadeOnDelete();

            $table->string('certificate_name');
            $table->date('expired_date')->nullable();
            $table->string('document_path')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('worker_certificates');
    }
};
