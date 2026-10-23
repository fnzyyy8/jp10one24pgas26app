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
        Schema::create('signature_tables', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');

            $table->string('name');
            $table->string('type', 50);
            $table->string('signature_path');
            $table->string('original_filename')->nullable();
            $table->string('mime_type', 50);
            $table->unsignedInteger('file_size');

            $table->boolean('is_default')->default(false);

            $table->timestamps();

            $table->index(
                ['user_id', 'type'],
                'signature_tables_user_type_index'
            );
        });

        Schema::table('signature_tables', function (Blueprint $table) {
            $table->foreign('user_id', 'signature_tables_user_id_foreign')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('signature_tables');
    }
};
