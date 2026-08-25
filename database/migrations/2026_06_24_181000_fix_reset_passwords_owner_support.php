<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('reset_passwords', 'user_type')) {
            Schema::table('reset_passwords', function (Blueprint $table) {
                $table->string('user_type', 20)->default('customer')->after('user_id');
            });
        }

        DB::statement('ALTER TABLE reset_passwords MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');
    }

    public function down(): void
    {
        if (Schema::hasColumn('reset_passwords', 'user_type')) {
            Schema::table('reset_passwords', function (Blueprint $table) {
                $table->dropColumn('user_type');
            });
        }

        DB::statement('ALTER TABLE reset_passwords MODIFY id BIGINT UNSIGNED NOT NULL');
    }
};
