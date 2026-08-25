<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeOwnerIdNullableInNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
            // Make owner_id nullable for admin notifications
            if (Schema::hasColumn('notifications', 'owner_id')) {
                $table->unsignedBigInteger('owner_id')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            if (Schema::hasColumn('notifications', 'owner_id')) {
                $table->unsignedBigInteger('owner_id')->nullable(false)->change();
            }
        });
    }
}
