<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chalet_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->string('booking_number')->unique();
            $table->string('slug')->unique();
            $table->string('customer_name');
            $table->string('phone_number');

            $table->string('email')->nullable();
            $table->string('message')->nullable();
            $table->string('country')->nullable();

            $table->decimal('total_amount',14,2)->default(0)->nullable();
            $table->decimal('payment_amount',14,2)->default(0)->nullable();

            $table->enum('booking_type', ['stayDay', 'fullDay', 'halfDay'])->default('fullDay');
            $table->enum('payment_status', ['paid', 'unpaid'])->default('unpaid');
            $table->string('status')->default('new');

            $table->unsignedBigInteger('payment_method_id')->nullable();
            $table->timestamps();
        });

        Schema::create('booking_dates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->decimal('price', 8, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('booking_dates');
        Schema::dropIfExists('bookings');
    }
};
