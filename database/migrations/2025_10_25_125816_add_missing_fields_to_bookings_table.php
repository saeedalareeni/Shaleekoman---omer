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
        Schema::table('bookings', function (Blueprint $table) {
            // إضافة حقول التاريخ والوقت
            $table->date('checkin_date')->after('phone_number')->nullable();
            $table->date('checkout_date')->after('checkin_date')->nullable();
            $table->time('checkin_time')->after('checkout_date')->nullable();
            $table->time('checkout_time')->after('checkin_time')->nullable();
            
            // إضافة تفاصيل الحجز
            $table->integer('number_of_guests')->after('checkout_time')->default(2);
            $table->decimal('price_per_night', 10, 2)->after('number_of_guests')->nullable();
            $table->decimal('total_nights', 10, 2)->after('price_per_night')->nullable();
            $table->decimal('subtotal', 10, 2)->after('total_nights')->nullable();
            $table->decimal('service_fee', 10, 2)->after('subtotal')->default(0);
            $table->decimal('vat', 10, 2)->after('service_fee')->default(0);
            
            // إضافة حقول إضافية
            $table->text('special_requests')->after('message')->nullable();
            $table->text('cancellation_reason')->after('special_requests')->nullable();
            $table->timestamp('cancelled_at')->after('cancellation_reason')->nullable();
            $table->timestamp('confirmed_at')->after('cancelled_at')->nullable();
            
            // إضافة user_id للربط مع جدول users
            $table->foreignId('user_id')->after('id')->nullable()->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn([
                'user_id',
                'checkin_date',
                'checkout_date',
                'checkin_time',
                'checkout_time',
                'number_of_guests',
                'price_per_night',
                'total_nights',
                'subtotal',
                'service_fee',
                'vat',
                'special_requests',
                'cancellation_reason',
                'cancelled_at',
                'confirmed_at'
            ]);
        });
    }
};
