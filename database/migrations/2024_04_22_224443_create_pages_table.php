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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();

            $table->string('name_ar');
            $table->string('name_en');

            $table->string('slug')->unique();

            $table->longText('body_ar');
            $table->longText('body_en');

            $table->text('meta_keywords_ar')->nullable();
            $table->text('meta_keywords_en')->nullable();

            $table->text('meta_description_ar')->nullable();
            $table->text('meta_description_en')->nullable();

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
        Schema::dropIfExists('pages');
    }
};
