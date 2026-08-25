<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    if (Schema::hasTable('faqs')) {
        return;
    }

    Schema::create('faqs', function (Blueprint $table) {
        $table->id();
        $table->string('question_ar');
        $table->string('question_en');
        $table->text('answer_ar');
        $table->text('answer_en');
        $table->string('category')->default('general');
        $table->integer('order')->default(0);
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
}

    public function down()
    {
        Schema::dropIfExists('faqs');
    }
};
