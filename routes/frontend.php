<?php


use App\Http\Controllers\Auth\AuthAppleController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\LoginCustomerController;
use App\Http\Controllers\Auth\LoginOwnerController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\RegisteredCustomerController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CustomerProfileController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;






//Web Routes =============================
Route::post('/coupon/check', [FrontendController::class, 'check'])->name('coupon.check');

Route::group(
[
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function(){

    // Route::get('admin/login', [DashboardController::class, 'admin_login'])->name('admin_login');

    Route::get('/', [FrontendController::class, 'weekendHome'])->name('shaleek.home');
    Route::redirect('/weekend-home', LaravelLocalization::localizeUrl('/'), 301);
    Route::redirect('/shaleek-home', LaravelLocalization::localizeUrl('/'), 301);

    // Test route for debugging bookings
    Route::get('/test-bookings', function() {
        return view('test-bookings');
    })->middleware('auth:customer');
    Route::get('/about-us', [FrontendController::class, 'about_us'])->name('about_us');
    Route::get('post-details/{slug}', [FrontendController::class, 'post_details'])->name('post_details');
    Route::get('all-posts', [FrontendController::class, 'posts'])->name('all-posts');

    Route::get('page/{slug}', [FrontendController::class, 'page'])->name('page');
    Route::get('/contact-us', [FrontendController::class, 'contact_us'])->name('contact_us');
    Route::get('/terms', [FrontendController::class, 'terms'])->name('terms');
    Route::post('send-messages', [FrontendController::class, 'send_messages'])->name('send_messages');
    Route::get('/all-chalet', [FrontendController::class, 'showAllChalet'])->name('showAllChalet');
    Route::get('/premium-chalets', [FrontendController::class, 'showPremiumChalets'])->name('showPremiumChalets');
    Route::get('/chalet/{slug}', [FrontendController::class, 'showChalet'])->name('showChalet');
    Route::get('/city/{slug}', [FrontendController::class, 'cityDetails'])->name('city.details');

    // API Ù„Ù„ÙÙ„ØªØ±Ø§Øª Ø§Ù„Ù…ØªØ³Ù„Ø³Ù„Ø©
    Route::get('/api/states/{govId}', [FrontendController::class, 'getAreasByState'])->name('api.states');
    Route::get('/api/areas/{stateId}', [FrontendController::class, 'getAreasByState'])->name('api.areas');

    Route::get('/search-result', [FrontendController::class, 'showAllChalet'])->name('search-result');

    Route::post('/review', [ReviewController::class, 'store'])->name('review.store')->middleware('auth:customer');
    Route::put('/review/{id}', [ReviewController::class, 'update'])->name('review.update')->middleware('auth:customer');
    Route::delete('/review/{id}', [ReviewController::class, 'destroy'])->name('review.destroy')->middleware('auth:customer');

    // Ø¬Ù„Ø¨ Ø§Ù„Ø£Ø³Ø¹Ø§Ø±
    Route::post('/get-prices/{chalet}', [FrontendController::class, 'getPrices']);

    // Ø§Ù„Ø­Ø¬Ø² Ø§Ù„Ø¬Ø¯ÙŠØ¯ Ù…Ù† ØµÙØ­Ø© Ø§Ù„ØªÙØ§ØµÙŠÙ„
    Route::post('/chalet/{id}/book', [BookingController::class, 'createBooking'])->name('chalet.book');
    Route::post('/chalet/check-availability', [BookingController::class, 'checkAvailability'])->name('chalet.check.availability');
    Route::get('/booking/confirm', [BookingController::class, 'confirmBookingPage'])->name('booking.confirm')->middleware('auth:customer');
    Route::get('/booking/confirm/{booking_number}', [BookingController::class, 'confirmExistingBooking'])->name('booking.confirm.page')->middleware('auth:customer');
    Route::put('/booking/{booking_number}/update-status', [BookingController::class, 'updateBookingStatus'])->name('booking.update.status')->middleware('auth:customer');
    Route::post('/booking/store', [BookingController::class, 'storeNewBooking'])->name('booking.store')->middleware('auth:customer');

    Route::post('/book-chalet', [BookingController::class, 'bookChalet'])->name('bookChalet')->middleware('auth:customer');
    Route::get('/invoice/{booking}', [BookingController::class, 'showInvoice'])->name('showInvoice');


    // ØµÙØ­Ø© Ø§Ù„ØºØ§Ø¡ Ø§Ù„Ø·Ù„Ø¨
    Route::get('payments_cancel/{order_no?}',[BookingController::class,'payments_cancel'])->name('payments_cancel');
    // Ù†Ø¬Ø§Ø­ Ø§Ù„Ø¯ÙØ¹
    Route::get('payments_success/{order_no?}', [BookingController::class, 'payments_success'])->name('payments_success');


    Route::post('/wishlist/toggle/{chalet}', [WishlistController::class, 'toggle'])->name('wishlist.toggle')->middleware('auth:customer');







 //============================== Ø§Ù„Ø¹Ù…Ù„Ø§Ø¡============================

    Route::group(
    [
       'middleware' => ['auth:customer']
    ],  function() {
        // Route::get('index/user', function () {
        //     return view('frontend.customer.index');
        // })->name('customers-index');
        Route::resource('user-index', CustomerProfileController::class);
        Route::post('profile-update',[ CustomerProfileController::class,'update'])->name('profile-update');
        Route::post('reset-password',[ CustomerProfileController::class,'ResetPassword'])->name('reset-password');
        Route::post('customer/logout', [LoginCustomerController::class, 'destroy'])->middleware('auth:customer')->name('customer_logout');


        Route::get('/account/orders', [CustomerProfileController::class, 'orders'])->name('account.orders');
        Route::get('/account/wishlist', [CustomerProfileController::class, 'wishlist'])->name('account.wishlist');




        Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index')->middleware('auth:customer');

        // Customer Notifications Routes
        Route::get('/notifications', [\App\Http\Controllers\CustomerNotificationController::class, 'index'])->name('customer.notifications.index');
        Route::get('/notifications/unread-count', [\App\Http\Controllers\CustomerNotificationController::class, 'unreadCount'])->name('customer.notifications.unread-count');
        Route::post('/notifications/{id}/mark-as-read', [\App\Http\Controllers\CustomerNotificationController::class, 'markAsRead'])->name('customer.notifications.mark-as-read');
        Route::post('/notifications/mark-all-read', [\App\Http\Controllers\CustomerNotificationController::class, 'markAllAsRead'])->name('customer.notifications.mark-all-read');
        Route::delete('/notifications/{id}', [\App\Http\Controllers\CustomerNotificationController::class, 'destroy'])->name('customer.notifications.destroy');
        Route::get('/notifications/recent', [\App\Http\Controllers\CustomerNotificationController::class, 'recent'])->name('customer.notifications.recent');

        // Customer Bookings
        Route::get('/my-bookings/{id}', [CustomerProfileController::class, 'showBooking'])->name('customer.bookings.show');

        // Owner chalets route
        Route::get('/owner/{owner}/chalets', [FrontendController::class, 'ownerChalets'])->name('owner.chalets');
    });


    Route::group(['prefix' => 'admin', 'as' => 'admin.' ], function () {
        Route::get('/login', [AuthenticatedSessionController::class, 'create'])->middleware('guest')->name('login');
        Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('guest');
        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');
    });



    Route::middleware('guest:customer')->group(function () {
        // Only property owners have accounts on Shaleek — visitors browse and
        // contact owners directly with no sign-up. These bare /login and
        // /register URLs used to serve a customer-facing auth page; they now
        // just forward to the owner login/register so old links still resolve
        // somewhere useful. The customer auth backend below stays intact and
        // reachable directly (customer_store/customer_register_store) in case
        // it's needed again later — it's just no longer linked to from the UI.
        Route::get('login', function () {
            return redirect()->route('owner.login');
        })->name('login');
        Route::post('store', [LoginCustomerController::class, 'customer_store'])->name('customer_store');
        Route::get('register', function () {
            return redirect()->route('owner.register');
        })->name('customer_register');
        Route::post('register', [RegisteredCustomerController::class, 'store'])->name('customer_register_store');

        Route::get('/user/forgot-password', function () {
            return view('auth.forgot-password');
        })->name('user.forgot_password');
        Route::get('/user/code-verify-password', function () {
            return view('auth.code-verify-password');
        })->name('user.code_verify_password');
        Route::post('/user/reset', [PasswordResetController::class, 'handlePasswordForm'])->name('user.reset');
        Route::post('/user/send-code', [PasswordResetController::class, 'sendCode'])->name('user.sendCode');
        Route::post('/user/check-code', [PasswordResetController::class, 'checkCode'])->name('user.checkCode');

        Route::get('/user/forgot-password', function () {
            return view('auth.forgot-password');
        })->name('user.forgot_password');
        Route::get('/user/code-verify-password', function () {
            return view('auth.code-verify-password');
        })->name('user.code_verify_password');
        Route::post('/user/reset', [PasswordResetController::class, 'handlePasswordForm'])->name('user.reset');
        Route::post('/user/send-code', [PasswordResetController::class, 'sendCode'])->name('user.sendCode');
        Route::post('/user/check-code', [PasswordResetController::class, 'checkCode'])->name('user.checkCode');




        // Google

        Route::get('auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
        Route::get('auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);
// Ø¥Ø°Ø§ ÙƒÙ†Øª ØªØ¨ÙŠ ØªØ±Ø³Ù„ type Ù…Ø®ØªÙ„Ù (Ù…Ø«Ù„Ø§Ù‹ ØªØ³Ø¬ÙŠÙ„ ÙƒÙ…Ø³ØªØ®Ø¯Ù… Ø£Ùˆ ÙƒÙ…Ø¯ÙŠØ±)
Route::get('auth/google/type/{type}', [SocialAuthController::class, 'redirectToGooglewithType'])->name('auth.google.withType');



        // Apple
        Route::get('auth/apple/type/{type}', [AuthAppleController::class, 'redirectToAppleewithType'])->name('auth.apple.withType');
        Route::get('auth/apple', [AuthAppleController::class, 'redirectToApple']);
        Route::post('auth/apple/callback', [AuthAppleController::class, 'handleAppleCallback']);

    });
});
    Route::get('/get-areas', [CityController::class, 'getAreas'])->name('get.areas');

