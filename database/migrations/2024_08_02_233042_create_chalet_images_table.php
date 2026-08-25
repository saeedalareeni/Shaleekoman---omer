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
        Schema::create('chalet_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('chalet_id');
            $table->string('image_path');
            $table->string('image_name_ar')->nullable(); // اسم الصورة بالعربية
            $table->string('image_name_en')->nullable(); // اسم الصورة بالإنجليزية
            $table->timestamps();

            $table->foreign('chalet_id')->references('id')->on('chalets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chalet_images');
    }
};
