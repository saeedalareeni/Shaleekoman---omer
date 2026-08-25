<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chalets', function (Blueprint $table) {
            // العقار مخصص: عوائل - عزاب - الجميع
            $table->string('dedicated_to', 32)->nullable()->after('area_size')->comment('families|singles|everyone');
            // عدد المجالس
            $table->unsignedTinyInteger('councils_count')->nullable()->after('bathrooms');
        });
    }

    public function down(): void
    {
        Schema::table('chalets', function (Blueprint $table) {
            $table->dropColumn(['dedicated_to', 'councils_count']);
        });
    }
};
