<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('chalets', function (Blueprint $table) {
        $table->decimal('insurance_amount', 10, 2)->nullable()->after('stay_price');
    });
}

public function down()
{
    Schema::table('chalets', function (Blueprint $table) {
        $table->dropColumn('insurance_amount');
    });
}

};
