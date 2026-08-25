<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BackendController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BookingCustomerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChaletController;
use App\Http\Controllers\ChaletPriceController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerMessageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\TermController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\OwnersExpenseController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/test-time', function() {
    echo "الوقت العالمي: " . now() . "<br>";
    echo "توقيت عمان: " . now()->timezone('Asia/Muscat') . "<br>";
    echo "توقيت عمان بالعربية: " . now()->timezone('Asia/Muscat')
        ->locale('ar')
        ->translatedFormat('l، d F Y - h:i A');
});


// Test Icons Page
Route::get('/test-icons', function () {
    return view('test-icons');
})->name('test.icons');
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

use App\Http\Controllers\ChaletReportController;

Route::post('/chalet/report', [ChaletReportController::class, 'store'])
    ->name('chalet.report.store');


Route::post('/chalet/report', [\App\Http\Controllers\ChaletReportController::class, 'store'])
    ->name('chalet.report');

//Amr ===================================
Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {
    Route::resource('categories', \App\Http\Controllers\CategoryController::class);
});


//Web Routes Backend ===================================

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
                'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]

    ], function(){

    Route::resource('dashboard', DashboardController::class);
    Route::resource('setting', SettingController::class);
    
    // FAQs Management
    Route::resource('faqs', FaqController::class);
    Route::patch('faqs/{faq}/toggle-status', [FaqController::class, 'toggleStatus'])->name('faqs.toggle-status');
    
    // Terms & Conditions Management
    Route::resource('terms', TermController::class);
    Route::patch('terms/{term}/toggle-status', [TermController::class, 'toggleStatus'])->name('terms.toggle-status');
    
    // Admin Settings Routes
    Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
        Route::get('settings', [\App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings');
        Route::put('settings/general', [\App\Http\Controllers\Admin\SettingsController::class, 'updateGeneral'])->name('settings.update.general');
        Route::put('settings/payment', [\App\Http\Controllers\Admin\SettingsController::class, 'updatePayment'])->name('settings.update.payment');
        Route::put('settings/oauth', [\App\Http\Controllers\Admin\SettingsController::class, 'updateOAuth'])->name('settings.update.oauth');
        Route::put('settings/email', [\App\Http\Controllers\Admin\SettingsController::class, 'updateEmail'])->name('settings.update.email');
        Route::put('settings/commission', [\App\Http\Controllers\Admin\SettingsController::class, 'updateCommission'])->name('settings.update.commission');
        Route::put('settings/social', [\App\Http\Controllers\Admin\SettingsController::class, 'updateSocial'])->name('settings.update.social');
        Route::post('settings/test-email', [\App\Http\Controllers\Admin\SettingsController::class, 'testEmail'])->name('settings.test-email');
        
        // Admin Profile Routes
        Route::get('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('profile');
        Route::put('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
    });
    Route::resource('abouts', AboutController::class);
    Route::resource('contacts', ContactController::class);
    Route::resource('pages', PageController::class);
    Route::resource('Infos', InfoController::class);
    Route::resource('sliders', SliderController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('posts', PostController::class);
    Route::patch('posts/{id}/toggle-status', [PostController::class, 'toggleStatus'])->name('posts.toggle-status');
    Route::resource('coupons', CouponController::class);
    Route::resource('image-gallery', ImageController::class);


    // PaymentMethod ======================================================================
    Route::resource('paymentsMethod', PaymentMethodController::class);
    Route::post('payment-methods-setting', [PaymentMethodController::class, 'setting'])->name('payment_methods.setting');
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    
    // Booking Customers Routes
    Route::resource('booking-customers', BookingCustomerController::class);
    Route::post('bookings/export/excel', [BookingCustomerController::class, 'exportExcel'])->name('bookings.export.excel');
    Route::post('bookings/export/pdf', [BookingCustomerController::class, 'exportPDF'])->name('bookings.export.pdf');
    Route::delete('/admin/bookings/cancel/{booking_number}', [BookingCustomerController::class, 'cancelBooking'])->name('booking-customers.cancel');
    Route::post('change_orders/{order}/{status}',   [BookingCustomerController::class, 'updateStatus'])->name('booking-customers.updateStatus');
    
    // بحث عن طلب
    Route::get('search_booking', [BookingCustomerController::class, 'search_booking'])->name('search_booking');
    
    // فلتر الطلبات حسب الشاليه
    Route::get('filter_booking_by_chalet', [BookingCustomerController::class, 'filter_booking_by_chalet'])->name('filter_booking_by_chalet');
    // تصدير اكسيل
    Route::post('filter_booking_by_chalet_excel', [BookingCustomerController::class, 'filter_booking_by_chalet_excel'])->name('filter_booking_by_chalet_excel');
    
    //  بحث في الطلبات بين تاريخين
    Route::get('search_booking_between_date', [BookingCustomerController::class, 'search_booking_between_date'])->name('search_booking_between_date');
    Route::post('search_booking_between_date', [BookingCustomerController::class, 'search_booking_between_date'])->name('search_booking.store');
    
    Route::resource('customer-messages', CustomerMessageController::class);
    Route::post('customer-messages/{id}/mark-read', [CustomerMessageController::class, 'markAsRead']);
    Route::post('customer-messages/mark-all-read', [CustomerMessageController::class, 'markAllAsRead']);
    Route::post('customer-messages/{id}/reply', [CustomerMessageController::class, 'reply']);
    Route::post('customer-messages/bulk-delete', [CustomerMessageController::class, 'bulkDestroy'])
        ->name('customer-messages.bulk-destroy');

    // الصلاحيات
    Route::resource('permissions', PermissionController::class);

    // عرض جميع الاشعارات
    Route::get('/show_notification_all', [BackendController::class, 'show_notification_all'])->name('show_notification_all');
    // مسح الاشعارات
    Route::get('/markAsRead_all', [BackendController::class, 'markAsRead_all'])->name('markAsRead_all');
    Route::get('/markAsRead/{id}', [BackendController::class, 'markAsRead'])->name('markAsRead');
    // Test notifications
    Route::get('/test-notifications', [BackendController::class, 'testNotifications'])->name('test.notifications');
    Route::post('/test-notification-create', [BackendController::class, 'createTestNotification'])->name('test.notification.create');

    // chalets
    Route::resource('chalets', ChaletController::class);
    Route::post('chalets/export/excel', [ChaletController::class, 'exportExcel'])->name('chalets.export.excel');
    Route::post('chalets/export/pdf', [ChaletController::class, 'exportPDF'])->name('chalets.export.pdf');
    Route::resource('areas', AreaController::class);
    Route::resource('cities', CityController::class);
    Route::resource('banners', BannerController::class);

    Route::resource('owners', OwnerController::class);
    Route::patch('owners/{id}/toggle-status', [OwnerController::class, 'toggleStatus'])->name('owners.toggle-status');
    Route::post('owners/export/excel', [OwnerController::class, 'exportExcel'])->name('owners.export.excel');
    Route::post('owners/export/pdf', [OwnerController::class, 'exportPDF'])->name('owners.export.pdf');
    Route::resource('customers', CustomerController::class);

    // اضافة صور
    Route::get('chalets/{chalet}/images', [ChaletController::class, 'getImages'])->name('chalets.images.index');
    Route::post('chalets/{chalet}/images', [ChaletController::class, 'storeImages'])->name('chalets.images.store');
    // حذف الصورة
    Route::delete('chalet-images/{image}', [ChaletController::class, 'destroyImage'])->name('chalets.images.destroy');

    Route::post('chalets/status', [ChaletController::class, 'status'])->name('chalets.status');


    // إدارة الأسعار
    Route::get('/chalets/{chalet}/prices', [ChaletPriceController::class, 'index'])->name('chalets.prices.index');
    Route::post('/chalets/{chalet}/prices/update', [ChaletPriceController::class, 'updatePrices'])->name('chalet.prices.update');
    // تحديث سعر أيام محددة
    Route::post('chalets/{chalet}/prices/update-recurrence', [ChaletPriceController::class, 'updatePricesRecurrence'])->name('chalet.prices.update.recurrence');


    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::resource('owners_expenses', OwnersExpenseController::class);
});
Route::get('/chalets/{chalet}/prices/data', [ChaletPriceController::class, 'getPrices'])->name('chalets.prices.data');
Route::get('/getareas/{id}', [AreaController::class, 'getareas'])->name('getareas');

// Language Switcher Route - With LaravelLocalization
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['ar', 'en'])) {
        // Save locale in session
        session(['locale' => $locale]);
        
        // Set locale for LaravelLocalization
        LaravelLocalization::setLocale($locale);
        
        // Get the current URL without locale prefix
        $url = LaravelLocalization::getNonLocalizedURL();
        
        // Get the localized URL for the new locale
        $localizedUrl = LaravelLocalization::getLocalizedURL($locale, $url);
        
        // Redirect to the localized URL with cookie
        return redirect($localizedUrl)->cookie('locale', $locale, 525600);
    }
    
    return redirect()->back();
})->name('lang.switch');

require __DIR__.'/auth.php';



