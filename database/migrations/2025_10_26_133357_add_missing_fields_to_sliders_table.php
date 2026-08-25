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
        Schema::table('sliders', function (Blueprint $table) {
            $table->text('description_ar')->nullable()->after('title_en');
            $table->text('description_en')->nullable()->after('description_ar');
            $table->string('button_text_ar')->nullable()->after('description_en');
            $table->string('button_text_en')->nullable()->after('button_text_ar');
            $table->string('link')->nullable()->after('button_text_en');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->dropColumn(['description_ar', 'description_en', 'button_text_ar', 'button_text_en', 'link']);
        });
    }
};
