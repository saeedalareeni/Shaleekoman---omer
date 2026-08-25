<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('chalets', function (Blueprint $table) {
                  $table->tinyInteger('show_contact_icon')->default(1)->after('is_feature'); // 1 = يظهر، 0 = يخفي

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chalets', function (Blueprint $table) {
                   $table->dropColumn('show_contact_icon');

        });
    }
};

