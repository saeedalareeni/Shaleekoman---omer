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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_id');
            $table->string('type'); // booking, review, reminder, payment
            $table->string('title_ar');
            $table->string('title_en');
            $table->text('message_ar');
            $table->text('message_en');
            $table->string('icon_type')->default('info'); // success, info, warning, error
            $table->boolean('is_read')->default(false);
            $table->json('data')->nullable(); // Additional data like booking_id, chalet_id, etc.
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            
            $table->foreign('owner_id')->references('id')->on('owners')->onDelete('cascade');
            $table->index(['owner_id', 'is_read']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
