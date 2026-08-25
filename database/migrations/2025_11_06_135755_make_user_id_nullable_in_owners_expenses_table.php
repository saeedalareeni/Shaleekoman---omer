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
        Schema::table('owners_expenses', function (Blueprint $table) {
            // جعل user_id قابل للـ null
            $table->unsignedBigInteger('user_id')->nullable()->change();
            
            // جعل payment_method_id قابل للـ null أيضاً
            $table->unsignedBigInteger('payment_method_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('owners_expenses', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
            $table->unsignedBigInteger('payment_method_id')->nullable(false)->change();
        });
    }
};
