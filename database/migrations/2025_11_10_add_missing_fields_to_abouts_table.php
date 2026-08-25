<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('abouts', function (Blueprint $table) {
            // Company Info
            if (!Schema::hasColumn('abouts', 'slogan_ar')) {
                $table->text('slogan_ar')->nullable();
            }
            if (!Schema::hasColumn('abouts', 'slogan_en')) {
                $table->text('slogan_en')->nullable();
            }
            if (!Schema::hasColumn('abouts', 'founded_year')) {
                $table->integer('founded_year')->nullable();
            }
            if (!Schema::hasColumn('abouts', 'employees_count')) {
                $table->integer('employees_count')->nullable();
            }
            if (!Schema::hasColumn('abouts', 'clients_count')) {
                $table->integer('clients_count')->nullable();
            }
            
            // Vision & Mission
            if (!Schema::hasColumn('abouts', 'vision_ar')) {
                $table->text('vision_ar')->nullable();
            }
            if (!Schema::hasColumn('abouts', 'vision_en')) {
                $table->text('vision_en')->nullable();
            }
            if (!Schema::hasColumn('abouts', 'mission_ar')) {
                $table->text('mission_ar')->nullable();
            }
            if (!Schema::hasColumn('abouts', 'mission_en')) {
                $table->text('mission_en')->nullable();
            }
            
            // SEO
            if (!Schema::hasColumn('abouts', 'meta_title_ar')) {
                $table->text('meta_title_ar')->nullable();
            }
            if (!Schema::hasColumn('abouts', 'meta_title_en')) {
                $table->text('meta_title_en')->nullable();
            }
            if (!Schema::hasColumn('abouts', 'keywords')) {
                $table->text('keywords')->nullable();
            }
            
            // Features
            if (!Schema::hasColumn('abouts', 'feature1_ar')) {
                $table->text('feature1_ar')->nullable();
            }
            if (!Schema::hasColumn('abouts', 'feature1_en')) {
                $table->text('feature1_en')->nullable();
            }
            if (!Schema::hasColumn('abouts', 'feature2_ar')) {
                $table->text('feature2_ar')->nullable();
            }
            if (!Schema::hasColumn('abouts', 'feature2_en')) {
                $table->text('feature2_en')->nullable();
            }
            if (!Schema::hasColumn('abouts', 'feature3_ar')) {
                $table->text('feature3_ar')->nullable();
            }
            if (!Schema::hasColumn('abouts', 'feature3_en')) {
                $table->text('feature3_en')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('abouts', function (Blueprint $table) {
            $columns = [
                'slogan_ar', 'slogan_en', 'founded_year', 'employees_count', 
                'clients_count', 'vision_ar', 'vision_en', 'mission_ar', 
                'mission_en', 'meta_title_ar', 'meta_title_en', 'keywords',
                'feature1_ar', 'feature1_en', 'feature2_ar', 'feature2_en',
                'feature3_ar', 'feature3_en'
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('abouts', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
