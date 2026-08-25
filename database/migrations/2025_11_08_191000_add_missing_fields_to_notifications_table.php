<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingFieldsToNotificationsTable extends Migration
{
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
            // Add missing fields
            if (!Schema::hasColumn('notifications', 'url')) {
                $table->string('url')->nullable()->after('message_en');
            }
            if (!Schema::hasColumn('notifications', 'icon')) {
                $table->string('icon')->nullable()->after('url');
            }
            if (!Schema::hasColumn('notifications', 'color')) {
                $table->string('color')->nullable()->default('info')->after('icon');
            }
        });
    }

    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropColumn(['url', 'icon', 'color']);
        });
    }
}
