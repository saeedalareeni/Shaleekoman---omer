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
    public function up():void
    {
        Schema::create('infos', function (Blueprint $table) {
            $table->id();
            $table->string('image')->default('images/no_image.png');

            $table->string('name_ar');
            $table->string('name_en');

            $table->longText('body_ar');
            $table->longText('body_en');
            $table->string('icon')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down():void
    {
        Schema::dropIfExists('infos');
    }
};
