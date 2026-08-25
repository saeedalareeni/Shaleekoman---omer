<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToNotificationsTable extends Migration
{
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
            // Add user_id column for admin notifications
            if (!Schema::hasColumn('notifications', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('owner_id');
                $table->index('user_id');
            }
            
            // Make owner_id nullable since we'll use either owner_id or user_id
            if (Schema::hasColumn('notifications', 'owner_id')) {
                $table->unsignedBigInteger('owner_id')->nullable()->change();
            }
        });
    }

    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
}
