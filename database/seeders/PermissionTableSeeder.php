<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{

    public function run(): void
    {
        $permissions = [
            'dashboard',
            'setting',

            'about_us',
            'contact_us',

            'payment_methods',
            'payment_methods_add',
            'payment_methods_edit',
            'payment_methods_delete',

            // التقارير
            'reports',
            'reports_all',
            'reports_all_between_two_dates',

            // المستخدمين
            'users',
            'create_user',
            'edit_user',
            'delete_user',
            'show_user',

            // الصلاحيات
            'roles',
            'add_role',
            'edit_role',
            'delete_role',
            'show_role',
            'search_role',

            // customers
            'customers',
            'add_customer',
            'edit_customer',
            'delete_customer',
            'show_customer',
            'search_customer',

            // الصلاحيات
            'permissions',
            'permission_add',
            'permission_edit',
            'permission_delete',


            // chalets
            'chalets',
            'add_chalet',
            'edit_chalet',
            'delete_chalet',
            'show_chalet',
            'search_chalet',
            'customer_messages',

            'sliders',
            'add_slider',
            'delete_slider',
            'edit_slider',

            'cities',
            'add_city',
            'delete_city',
            'edit_city',

            'categories',
            'add_category',
            'delete_category',
            'edit_category',
            'chalets_count',

            'areas',
            'add_area',
            'edit_area',
            'delete_area',
            'delete_customer_message',

            'owners',
            'add_owner',
            'edit_owner',
            'delete_owner',
            'show_owner',
            'search_owner',

            // مصروفات الملاك
            'owners_expenses',
            'add_owners_expense',
            'show_owners_expense',
            'edit_owners_expense',
            'delete_owners_expense',

            'banners',
            'add_banner',
            'edit_banner',
            'delete_banner',

            'pages',
            'add_page',
            'edit_page',
            'delete_page',

            'posts',
            'add_post',
            'show_post',
            'edit_post',
            'delete_post',
            'search_post',

            'cancel_booking',
            'delete_booking',
            
            'coupons',
            'add_coupon',
            'edit_coupon',
            'delete_coupon',
            'search_coupon',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
