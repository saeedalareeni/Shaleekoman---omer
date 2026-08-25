<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('views')) {
            return;
        }

        $createTable = DB::selectOne('SHOW CREATE TABLE `views`');
        $sql = $createTable->{'Create Table'} ?? '';

        if (str_contains(strtolower($sql), '`id` bigint(20) unsigned not null auto_increment')) {
            return;
        }

        DB::statement('ALTER TABLE `views` MODIFY `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');
    }

    public function down(): void
    {
        if (!Schema::hasTable('views')) {
            return;
        }

        DB::statement('ALTER TABLE `views` MODIFY `id` BIGINT UNSIGNED NOT NULL');
    }
};
