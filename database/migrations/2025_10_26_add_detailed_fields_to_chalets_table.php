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
        Schema::table('chalets', function (Blueprint $table) {
            // معلومات المساحة والسعة
            $table->integer('area_size')->nullable()->after('map_link'); // مساحة الشاليه بالمتر المربع
            $table->integer('max_guests')->nullable()->after('area_size'); // العدد الأقصى للضيوف
            $table->integer('bedrooms')->nullable()->after('max_guests'); // عدد غرف النوم
            $table->integer('bathrooms')->nullable()->after('bedrooms'); // عدد دورات المياه
            
            // المرافق والخدمات
            $table->json('amenities')->nullable()->after('bathrooms'); // قائمة المرافق
            $table->json('nearby_places')->nullable()->after('amenities'); // الأماكن القريبة
            
            // أوقات الدخول والخروج
            $table->time('check_in_time')->default('14:00')->after('nearby_places');
            $table->time('check_out_time')->default('12:00')->after('check_in_time');
            
            // معلومات إضافية
            $table->text('rules_ar')->nullable()->after('check_out_time'); // القواعد والشروط بالعربية
            $table->text('rules_en')->nullable()->after('rules_ar'); // القواعد والشروط بالإنجليزية
            $table->string('whatsapp_number')->nullable()->after('rules_en'); // رقم الواتساب للتواصل
            
            // التقييم
            $table->decimal('rating', 2, 1)->default(0)->after('whatsapp_number'); // التقييم من 5
            $table->integer('total_reviews')->default(0)->after('rating'); // عدد التقييمات
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chalets', function (Blueprint $table) {
            $table->dropColumn([
                'area_size',
                'max_guests',
                'bedrooms',
                'bathrooms',
                'amenities',
                'nearby_places',
                'check_in_time',
                'check_out_time',
                'rules_ar',
                'rules_en',
                'whatsapp_number',
                'rating',
                'total_reviews'
            ]);
        });
    }
};
