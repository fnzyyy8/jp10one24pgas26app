
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'sqlite') {
            Schema::table('users', function (Blueprint $table) {
                $table->string('division')
                    ->default('site')
                    ->change();
            });

            return;
        }

        if ($driver === 'mysql') {
            DB::statement("
                ALTER TABLE `users`
                MODIFY COLUMN `division`
                ENUM('site', 'pscm', 'vendor')
                NOT NULL DEFAULT 'site'
            ");

            return;
        }

        throw new RuntimeException(
            "Database driver tidak didukung: {$driver}"
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'sqlite') {
            // Kembalikan nilai yang tidak tersedia pada ENUM lama.
            DB::table('users')
                ->whereNotIn('division', ['Site', 'PSCM'])
                ->update(['division' => 'Site']);

            Schema::table('users', function (Blueprint $table) {
                $table->string('division')
                    ->default('Site')
                    ->change();
            });

            return;
        }

        if ($driver === 'mysql') {
            // Normalisasi nilai sebelum membatasi ENUM.
            DB::statement("
                UPDATE `users`
                SET `division` = CASE
                    WHEN LOWER(`division`) = 'pscm' THEN 'PSCM'
                    ELSE 'Site'
                END
            ");

            DB::statement("
                ALTER TABLE `users`
                MODIFY COLUMN `division`
                ENUM('Site', 'PSCM')
                NOT NULL DEFAULT 'Site'
            ");

            return;
        }

        throw new RuntimeException(
            "Database driver tidak didukung: {$driver}"
        );
    }
};
