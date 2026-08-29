<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Some tables in this database (e.g. owners) were created/restored in a
     * way that dropped AUTO_INCREMENT on their `id` column — inserts then
     * fail with "Field 'id' doesn't have a default value". This scans every
     * table for that exact problem and fixes it in one pass, instead of
     * patching tables one at a time as they're discovered (as was done
     * earlier for `wishlists`).
     */
    public function up(): void
    {
        $database = DB::getDatabaseName();

        $broken = DB::select(
            "SELECT TABLE_NAME, COLUMN_TYPE
             FROM information_schema.COLUMNS
             WHERE TABLE_SCHEMA = ?
               AND COLUMN_NAME = 'id'
               AND EXTRA NOT LIKE '%auto_increment%'
               AND COLUMN_TYPE LIKE '%int%'",
            [$database]
        );

        foreach ($broken as $row) {
            $table = $row->TABLE_NAME;
            $type = $row->COLUMN_TYPE; // e.g. "bigint(20) unsigned"

            DB::statement("ALTER TABLE `{$table}` MODIFY `id` {$type} NOT NULL AUTO_INCREMENT");
        }
    }

    public function down(): void
    {
        // Not reversible on purpose — we never want to strip AUTO_INCREMENT
        // back off a fixed table.
    }
};
