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
            $table->json('tags')->nullable()->after('is_feature');
            $table->boolean('has_pool')->default(false)->after('tags');
            $table->boolean('has_beachfront')->default(false)->after('has_pool');
            $table->boolean('has_beach')->default(false)->after('has_beachfront');
            $table->boolean('has_garden')->default(false)->after('has_beach');
            $table->boolean('has_mountain_view')->default(false)->after('has_garden');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chalets', function (Blueprint $table) {
            $table->dropColumn(['tags', 'has_pool', 'has_beachfront', 'has_beach', 'has_garden', 'has_mountain_view']);
        });
    }
};
