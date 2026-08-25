<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraFieldsToPostsTable extends Migration
{
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            if (!Schema::hasColumn('posts', 'category')) {
                $table->string('category')->nullable()->after('status');
            }
            if (!Schema::hasColumn('posts', 'views')) {
                $table->integer('views')->default(0)->after('category');
            }
            if (!Schema::hasColumn('posts', 'tags')) {
                $table->string('tags')->nullable()->after('views');
            }
            if (!Schema::hasColumn('posts', 'meta_title_ar')) {
                $table->string('meta_title_ar')->nullable()->after('tags');
            }
            if (!Schema::hasColumn('posts', 'meta_title_en')) {
                $table->string('meta_title_en')->nullable()->after('meta_title_ar');
            }
            if (!Schema::hasColumn('posts', 'meta_description_ar')) {
                $table->text('meta_description_ar')->nullable()->after('meta_title_en');
            }
            if (!Schema::hasColumn('posts', 'meta_description_en')) {
                $table->text('meta_description_en')->nullable()->after('meta_description_ar');
            }
            if (!Schema::hasColumn('posts', 'featured_image')) {
                $table->string('featured_image')->nullable()->after('image');
            }
        });
    }

    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['category', 'views', 'tags', 'meta_title_ar', 'meta_title_en', 'meta_description_ar', 'meta_description_en', 'featured_image']);
        });
    }
}
