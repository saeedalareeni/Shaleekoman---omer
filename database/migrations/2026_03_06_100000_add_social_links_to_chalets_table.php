<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chalets', function (Blueprint $table) {
            if (!Schema::hasColumn('chalets', 'instagram_url')) {
                $table->string('instagram_url', 500)->nullable()->after('booking_terms_ar');
            }
            if (!Schema::hasColumn('chalets', 'tiktok_url')) {
                $table->string('tiktok_url', 500)->nullable()->after('instagram_url');
            }
        });
    }

    public function down(): void
    {
        Schema::table('chalets', function (Blueprint $table) {
            if (Schema::hasColumn('chalets', 'instagram_url')) {
                $table->dropColumn('instagram_url');
            }
            if (Schema::hasColumn('chalets', 'tiktok_url')) {
                $table->dropColumn('tiktok_url');
            }
        });
    }
};
