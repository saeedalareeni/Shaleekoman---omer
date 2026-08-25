<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cities', function (Blueprint $table) {
            // Only add slug column if it doesn't exist
            if (!Schema::hasColumn('cities', 'slug')) {
                $table->string('slug')->nullable()->after('name_en');
            }
            // Only add image column if it doesn't exist
            if (!Schema::hasColumn('cities', 'image')) {
                $table->string('image')->nullable()->after('slug');
            }
        });
        
        // Update existing cities with slugs
        $cities = \App\Models\City::all();
        foreach ($cities as $city) {
            if (!$city->slug) {
                $city->slug = Str::slug($city->name_en ?: $city->name_ar);
                $city->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->dropColumn(['slug', 'image']);
        });
    }
};
