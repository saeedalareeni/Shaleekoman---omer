<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abouts', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->default('logo.png');
            $table->string('image_about_us')->default('images/bg_title.webp');
            $table->string('bg')->default('images/bg_title.webp');

            $table->string('company_name_ar');
            $table->string('company_name_en');

            $table->longText('short_about_ar')->nullable();
            $table->longText('short_about_en')->nullable();

            $table->longText('about_ar')->nullable();
            $table->longText('about_en')->nullable();

            $table->text('meta_keywords_ar')->nullable();
            $table->text('meta_keywords_en')->nullable();

            $table->text('meta_description_ar')->nullable();
            $table->text('meta_description_en')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('abouts');
    }
};
