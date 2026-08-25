<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{


    public function up()
    {
        Schema::create('owners_expenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('payment_method_id');
            $table->unsignedBigInteger('owner_id');

            $table->string('check_number')->nullable();
            $table->decimal('amount', 14,3);
            $table->date('expense_date');
            $table->text('about')->nullable();
            $table->text('notes')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
            // $table->foreignId('payment_method_id')->constrained()->onDelete('cascade');
            // $table->foreignId('owner_id')->constrained()->onDelete('cascade');

        });
    }


    public function down()
    {
        Schema::dropIfExists('owners_expenses');
    }
};
