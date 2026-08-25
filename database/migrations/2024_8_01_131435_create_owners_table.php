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
        Schema::create('owners', function (Blueprint $table) {
            $table->id();
            $table->boolean('status')->default(1);
            $table->string('image')->nullable();
            $table->string('name');
            $table->string('account_number')->unique()->nullable();
            $table->string('username')->unique()->nullable();
            $table->string('phone')->unique();
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('address')->nullable();

            $table->decimal('commission', 14, 3)->default(0);
            $table->string('bank_account_name')->nullable();
            $table->string('bank_account_number')->nullable();

            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();
            $table->string('google_id')->nullable(); // تم إضافة google_id

            $table->rememberToken();
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
        Schema::dropIfExists('owners');
    }
};
