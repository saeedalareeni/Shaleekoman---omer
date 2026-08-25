<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chalets', function (Blueprint $table) {
            if (!Schema::hasColumn('chalets', 'booking_terms_ar')) {
                $table->text('booking_terms_ar')->nullable()->after('rules_en');
            }
        });
    }

    public function down(): void
    {
        Schema::table('chalets', function (Blueprint $table) {
            if (Schema::hasColumn('chalets', 'booking_terms_ar')) {
                $table->dropColumn('booking_terms_ar');
            }
        });
    }
};
