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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('image')->default('images/no_image.png');
            $table->string('image2')->default('images/no_image.png');
            $table->text('video')->nullable();

            $table->string('slug')->unique();

            $table->string('body_ar');
            $table->string('body_en');

            $table->longText('title_ar');
            $table->longText('title_en');

            $table->text('meta_keywords_ar')->nullable();
            $table->text('meta_keywords_en')->nullable();

            $table->text('meta_description_ar')->nullable();
            $table->text('meta_description_en')->nullable();

            $table->boolean('featured')->default(1);
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('posts');
    }
};
