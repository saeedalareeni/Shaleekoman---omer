<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('customer_messages', function (Blueprint $table) {
            if (!Schema::hasColumn('customer_messages', 'is_read')) {
                $table->boolean('is_read')->default(0)->after('message');
            }

            if (!Schema::hasColumn('customer_messages', 'is_replied')) {
                $table->boolean('is_replied')->default(0)->after('is_read');
            }

            if (!Schema::hasColumn('customer_messages', 'reply')) {
                $table->longText('reply')->nullable()->after('is_replied');
            }

            if (!Schema::hasColumn('customer_messages', 'replied_at')) {
                $table->timestamp('replied_at')->nullable()->after('reply');
            }
        });
    }

    public function down()
    {
        Schema::table('customer_messages', function (Blueprint $table) {
            if (Schema::hasColumn('customer_messages', 'is_read')) {
                $table->dropColumn('is_read');
            }

            if (Schema::hasColumn('customer_messages', 'is_replied')) {
                $table->dropColumn('is_replied');
            }

            if (Schema::hasColumn('customer_messages', 'reply')) {
                $table->dropColumn('reply');
            }

            if (Schema::hasColumn('customer_messages', 'replied_at')) {
                $table->dropColumn('replied_at');
            }
        });
    }
};
