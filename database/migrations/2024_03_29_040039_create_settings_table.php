<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{


    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->default('logo.png');
            $table->string('header')->default('header.png');
            $table->string('footer')->default('header.png');
            $table->string('stamp')->default('stamp.png');

            $table->string('company_name_ar');
            $table->string('company_name_en');
            $table->string('cr_no')->nullable();

            $table->string('address_ar')->nullable();
            $table->string('address_en')->nullable();

            $table->string('email')->nullable();
            $table->string('phone')->nullable();

            $table->string('tax_no')->nullable();
            $table->decimal('tax', 8, 2)->nullable();
            $table->decimal('advance_amount', 14,2)->default(0)->nullable();
            $table->longText('terms_ar')->nullable();
            $table->longText('terms_en')->nullable();

            $table->timestamps();
        });
    }



    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
