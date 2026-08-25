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
        Schema::table('settings', function (Blueprint $table) {
            // إضافة الحقول المفقودة للعنوان
            if (!Schema::hasColumn('settings', 'governorate_ar')) {
                $table->string('governorate_ar')->nullable()->after('city');
            }
            if (!Schema::hasColumn('settings', 'governorate_en')) {
                $table->string('governorate_en')->nullable()->after('governorate_ar');
            }
            
            // Payment method fields
            $paymentFields = [
                'paypal_enabled' => ['boolean', false],
                'stripe_enabled' => ['boolean', false],
                'thawani_enabled' => ['boolean', false],
                'cash_enabled' => ['boolean', true],
                'bank_transfer_enabled' => ['boolean', false],
            ];
            
            foreach ($paymentFields as $field => $config) {
                if (!Schema::hasColumn('settings', $field)) {
                    $column = $table->{$config[0]}($field);
                    $column->default($config[1]);
                }
            }
            
            // Payment credentials
            $paymentCredentials = [
                'paypal_client_id' => 'string',
                'paypal_secret' => 'text',
                'paypal_mode' => 'string',
                'stripe_publishable_key' => 'string',
                'stripe_secret_key' => 'text',
                'thawani_secret_key' => 'text',
                'thawani_publishable_key' => 'string',
                'thawani_api_url' => 'string',
            ];
            
            foreach ($paymentCredentials as $field => $type) {
                if (!Schema::hasColumn('settings', $field)) {
                    $column = $table->$type($field)->nullable();
                    if ($field === 'paypal_mode') {
                        $column->default('sandbox');
                    }
                }
            }
            
            // Email settings
            $emailFields = [
                'mail_driver' => ['string', 'smtp'],
                'mail_host' => ['string', null],
                'mail_port' => ['integer', 587],
                'mail_username' => ['string', null],
                'mail_password' => ['text', null],
                'mail_encryption' => ['string', 'tls'],
                'mail_from_address' => ['string', null],
                'mail_from_name' => ['string', null],
            ];
            
            foreach ($emailFields as $field => $config) {
                if (!Schema::hasColumn('settings', $field)) {
                    $column = $table->{$config[0]}($field);
                    if ($config[1] !== null) {
                        $column->default($config[1]);
                    } else {
                        $column->nullable();
                    }
                }
            }
            
            // OAuth additional settings
            if (!Schema::hasColumn('settings', 'google_auto_register')) {
                $table->boolean('google_auto_register')->default(true);
            }
            if (!Schema::hasColumn('settings', 'google_sync_profile')) {
                $table->boolean('google_sync_profile')->default(true);
            }
            
            // Commission fields
            if (!Schema::hasColumn('settings', 'commission_rate')) {
                $table->decimal('commission_rate', 5, 2)->default(10.00);
            }
            if (!Schema::hasColumn('settings', 'service_fee')) {
                $table->decimal('service_fee', 8, 2)->default(0.00);
            }
            if (!Schema::hasColumn('settings', 'vat_rate')) {
                $table->decimal('vat_rate', 5, 2)->default(5.00);
            }
            if (!Schema::hasColumn('settings', 'owner_payment_period')) {
                $table->integer('owner_payment_period')->default(7);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $fieldsToRemove = [
                'governorate_ar',
                'governorate_en',
                'paypal_enabled',
                'stripe_enabled',
                'thawani_enabled',
                'cash_enabled',
                'bank_transfer_enabled',
                'paypal_client_id',
                'paypal_secret',
                'paypal_mode',
                'stripe_publishable_key',
                'stripe_secret_key',
                'thawani_secret_key',
                'thawani_publishable_key',
                'thawani_api_url',
                'mail_driver',
                'mail_host',
                'mail_port',
                'mail_username',
                'mail_password',
                'mail_encryption',
                'mail_from_address',
                'mail_from_name',
                'google_auto_register',
                'google_sync_profile',
                'commission_rate',
                'service_fee',
                'vat_rate',
                'owner_payment_period',
            ];
            
            foreach ($fieldsToRemove as $field) {
                if (Schema::hasColumn('settings', $field)) {
                    $table->dropColumn($field);
                }
            }
        });
    }
};
