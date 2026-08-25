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
        Schema::create('chalets', function (Blueprint $table) {
            $table->id();
            $table->string('chalet_name_ar');
            $table->string('chalet_name_en');
            $table->string('slug')->unique();
            $table->string('main_image')->nullable();
            $table->text('video')->nullable();


            $table->text('short_description_ar')->nullable();
            $table->text('short_description_en')->nullable();

            $table->longText('long_description_ar')->nullable();
            $table->longText('long_description_en')->nullable();

            $table->longText('location')->nullable();
            $table->longText('map_link')->nullable();

            $table->decimal('default_day_price', 8, 2); // السعر الافتراضي لأيام السنة
            $table->decimal('half_day_price', 14, 2);//السعر في  نصف يوم
            $table->decimal('stay_price', 14, 2);//حقل  في حالة المبيت
            $table->decimal('holiday_day_price', 8, 2); // سعر أيام الاجازات

            $table->enum('status', ['rejected', 'pending', 'approved'])->default('pending'); // Course status
            $table->boolean('is_feature')->default(1);
            
            $table->longText('seo_keywords_ar')->nullable();
            $table->longText('seo_keywords_en')->nullable();

            $table->longText('seo_meta_description_ar')->nullable();
            $table->longText('seo_meta_description_en')->nullable();

            $table->foreignId('city_id')->constrained('cities')->onDelete('cascade');
            $table->foreignId('area_id')->constrained('areas')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->unsignedBigInteger('owner_id');
            // $table->foreignId('owner_id')->constrained('owners')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chalets');
    }
};
