<?php


use App\Http\Controllers\Auth\LoginOwnerController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\RegisteredOwnerController;
use App\Http\Controllers\Owner\BookingController;
use App\Http\Controllers\Owner\ChaletController;
use App\Http\Controllers\Owner\ChaletPriceController;
use App\Http\Controllers\Owner\DashboardController;
use App\Http\Controllers\Owner\ExpenseController;
use App\Http\Controllers\Owner\ProfileController;
use App\Http\Controllers\Owner\NotificationController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;




/*
|--------------------------------------------------------------------------
| Web Routes
*/


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'guest:owner' ]
    ], function(){
        Route::group(['prefix' => 'owner', 'as' => 'owner.' ], function () {
            Route::get('login', [LoginOwnerController::class, 'create'])->name('login');
            Route::post('login', [LoginOwnerController::class, 'store']);

            Route::get('forgot-password', function () {
                return view('auth.forgot-password', ['resetType' => 'owner']);
            })->name('forgot_password');
            Route::get('code-verify-password', function () {
                return view('auth.code-verify-password', ['resetType' => 'owner']);
            })->name('code_verify_password');
            Route::post('reset', [PasswordResetController::class, 'handlePasswordForm'])->name('reset');
            Route::post('send-code', [PasswordResetController::class, 'sendCode'])->name('sendCode');
            Route::post('check-code', [PasswordResetController::class, 'checkCode'])->name('checkCode');

            Route::get('register', [RegisteredOwnerController::class, 'create'])->name('register');
            Route::post('register', [RegisteredOwnerController::class, 'store']);
        });
    }
);
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth:owner' ]
    ], function(){

        Route::group(['prefix' => 'owner', 'as' => 'owner.' ], function () {

            Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
            Route::get('test-notifications', function() {
                return view('test-notifications');
            });
            Route::resource('chalets', ChaletController::class);
            Route::get('chalets/{id}/edit-json', [ChaletController::class, 'editJson'])->name('chalets.edit.json');
            Route::post('/logout', [LoginOwnerController::class, 'destroy'])->name('logout');
            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
            Route::post('/profile', [ProfileController::class, 'updateImage'])->name('profile.image.update');
            Route::put('password', [ProfileController::class, 'updatePassword'])->name('password.update');

            Route::get('chalets/{chalet}/images', [ChaletController::class, 'getImages'])->name('chalets.images.index');
                // اضافة صور
            Route::post('chalets/{chalet}/images', [ChaletController::class, 'storeImages'])->name('chalets.images.store');
            // حذف الصورة
            Route::delete('chalet-images/{image}', [ChaletController::class, 'destroyImage'])->name('chalets.images.destroy');


            // إدارة الأسعار
            Route::get('/chalets/{chalet}/prices', [ChaletPriceController::class, 'index'])->name('chalets.prices.index');
            Route::get('/chalets/{chalet}/prices/data', [ChaletPriceController::class, 'getPrices'])->name('chalets.prices.data');
            Route::post('/chalets/{chalet}/prices/update', [ChaletPriceController::class, 'updatePrices'])->name('chalet.prices.update');
            // تحديث سعر أيام محددة
            Route::post('chalets/{chalet}/prices/update-recurrence', [ChaletPriceController::class, 'updatePricesRecurrence'])->name('chalet.prices.update.recurrence');

            Route::resource('bookings', BookingController::class);
            Route::post('bookings/cancel/{booking_number}', [BookingController::class, 'cancelBooking'])->name('bookings.cancel');
            Route::post('bookings/change-status/{booking_number}', [BookingController::class, 'changeStatus'])->name('bookings.change-status');
            Route::post('bookings/{booking_number}/confirm-payment', [BookingController::class, 'confirmPayment'])->name('bookings.confirm-payment');
            Route::delete('bookings/{booking_number}', [BookingController::class, 'destroy'])->name('bookings.destroy');
            Route::resource('expenses', ExpenseController::class);

            Route::get('search_booking', [BookingController::class, 'search_booking'])->name('search_booking');

            Route::get('filter_booking_by_chalet', [BookingController::class, 'filter_booking_by_chalet'])->name('filter_booking_by_chalet');
            // تصدير اكسيل
            Route::post('filter_booking_by_chalet_excel', [BookingController::class, 'filter_booking_by_chalet_excel'])->name('filter_booking_by_chalet_excel');
            Route::get('search_booking_between_date', [BookingController::class, 'search_booking_between_date'])->name('search_booking_between_date');
            Route::post('search_booking_between_date', [BookingController::class, 'search_booking_between_date'])->name('search_booking.store');

            // Notifications Routes
            Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
            Route::get('notifications/unread', [NotificationController::class, 'getUnread'])->name('notifications.unread');
            Route::post('notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
            Route::post('notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllRead');
            Route::delete('notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
            Route::delete('notifications', [NotificationController::class, 'clearAll'])->name('notifications.clearAll');

        });
    });
