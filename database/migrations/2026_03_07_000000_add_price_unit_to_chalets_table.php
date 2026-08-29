<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chalets', function (Blueprint $table) {
            // The label shown next to the price (e.g. "ليلة", "مناسبة أفراح",
            // "جلسة") — the choices offered depend on the property's category.
            $table->string('price_unit')->nullable()->after('default_day_price');
        });
    }

    public function down(): void
    {
        Schema::table('chalets', function (Blueprint $table) {
            $table->dropColumn('price_unit');
        });
    }
};
