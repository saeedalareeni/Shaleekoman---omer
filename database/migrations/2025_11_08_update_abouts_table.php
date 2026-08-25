<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('abouts', function (Blueprint $table) {
            // Hero Section
            $table->string('hero_title_ar')->nullable()->after('bg');
            $table->string('hero_title_en')->nullable()->after('hero_title_ar');
            $table->text('hero_subtitle_ar')->nullable()->after('hero_title_en');
            $table->text('hero_subtitle_en')->nullable()->after('hero_subtitle_ar');
            $table->string('hero_image')->nullable()->after('hero_subtitle_en');
            
            // Our Story Section
            $table->string('story_badge_ar')->default('قصتنا')->after('hero_image');
            $table->string('story_badge_en')->default('Our Story')->after('story_badge_ar');
            $table->string('story_title_ar')->nullable()->after('story_badge_en');
            $table->string('story_title_en')->nullable()->after('story_title_ar');
            $table->text('story_content_ar')->nullable()->after('story_title_en');
            $table->text('story_content_en')->nullable()->after('story_content_ar');
            $table->text('story_content2_ar')->nullable()->after('story_content_en');
            $table->text('story_content2_en')->nullable()->after('story_content2_ar');
            $table->string('story_image')->nullable()->after('story_content2_en');
            $table->string('story_years')->default('5')->after('story_image');
            $table->string('story_years_text_ar')->default('سنوات من الخبرة')->after('story_years');
            $table->string('story_years_text_en')->default('Years of Experience')->after('story_years_text_ar');
            
            // Features (Why Us)
            $table->string('features_badge_ar')->default('لماذا نحن')->after('story_years_text_en');
            $table->string('features_badge_en')->default('Why Us')->after('features_badge_ar');
            $table->string('features_title_ar')->nullable()->after('features_badge_en');
            $table->string('features_title_en')->nullable()->after('features_title_ar');
            
            // 6 Features
            for ($i = 1; $i <= 6; $i++) {
                $table->string("feature{$i}_icon")->default('fas fa-star')->after('features_title_en');
                $table->string("feature{$i}_title_ar")->nullable();
                $table->string("feature{$i}_title_en")->nullable();
                $table->text("feature{$i}_desc_ar")->nullable();
                $table->text("feature{$i}_desc_en")->nullable();
            }
            
            // Statistics
            $table->string('stat1_number')->default('500')->after('feature6_desc_en');
            $table->string('stat1_text_ar')->default('شاليه واستراحة')->after('stat1_number');
            $table->string('stat1_text_en')->default('Chalets & Rest Houses')->after('stat1_text_ar');
            
            $table->string('stat2_number')->default('10000')->after('stat1_text_en');
            $table->string('stat2_text_ar')->default('عميل سعيد')->after('stat2_number');
            $table->string('stat2_text_en')->default('Happy Customers')->after('stat2_text_ar');
            
            $table->string('stat3_number')->default('15000')->after('stat2_text_en');
            $table->string('stat3_text_ar')->default('حجز ناجح')->after('stat3_number');
            $table->string('stat3_text_en')->default('Successful Bookings')->after('stat3_text_ar');
            
            $table->string('stat4_number')->default('5')->after('stat3_text_en');
            $table->string('stat4_text_ar')->default('سنوات من الخبرة')->after('stat4_number');
            $table->string('stat4_text_en')->default('Years of Experience')->after('stat4_text_ar');
            
            // CTA Section
            $table->string('cta_title_ar')->nullable()->after('stat4_text_en');
            $table->string('cta_title_en')->nullable()->after('cta_title_ar');
            $table->text('cta_subtitle_ar')->nullable()->after('cta_title_en');
            $table->text('cta_subtitle_en')->nullable()->after('cta_subtitle_ar');
            $table->string('cta_button_text_ar')->default('سجل كمالك')->after('cta_subtitle_en');
            $table->string('cta_button_text_en')->default('Register as Owner')->after('cta_button_text_ar');
        });
    }

    public function down()
    {
        Schema::table('abouts', function (Blueprint $table) {
            $columns = [
                'hero_title_ar', 'hero_title_en', 'hero_subtitle_ar', 'hero_subtitle_en', 'hero_image',
                'story_badge_ar', 'story_badge_en', 'story_title_ar', 'story_title_en',
                'story_content_ar', 'story_content_en', 'story_content2_ar', 'story_content2_en',
                'story_image', 'story_years', 'story_years_text_ar', 'story_years_text_en',
                'features_badge_ar', 'features_badge_en', 'features_title_ar', 'features_title_en',
                'feature1_icon', 'feature1_title_ar', 'feature1_title_en', 'feature1_desc_ar', 'feature1_desc_en',
                'feature2_icon', 'feature2_title_ar', 'feature2_title_en', 'feature2_desc_ar', 'feature2_desc_en',
                'feature3_icon', 'feature3_title_ar', 'feature3_title_en', 'feature3_desc_ar', 'feature3_desc_en',
                'feature4_icon', 'feature4_title_ar', 'feature4_title_en', 'feature4_desc_ar', 'feature4_desc_en',
                'feature5_icon', 'feature5_title_ar', 'feature5_title_en', 'feature5_desc_ar', 'feature5_desc_en',
                'feature6_icon', 'feature6_title_ar', 'feature6_title_en', 'feature6_desc_ar', 'feature6_desc_en',
                'stat1_number', 'stat1_text_ar', 'stat1_text_en',
                'stat2_number', 'stat2_text_ar', 'stat2_text_en',
                'stat3_number', 'stat3_text_ar', 'stat3_text_en',
                'stat4_number', 'stat4_text_ar', 'stat4_text_en',
                'cta_title_ar', 'cta_title_en', 'cta_subtitle_ar', 'cta_subtitle_en',
                'cta_button_text_ar', 'cta_button_text_en'
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('abouts', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
