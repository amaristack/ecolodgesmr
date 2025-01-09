<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HallController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\PoolController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\UserRegisterController;
use App\Http\Middleware\VerifyCsrfToken;
use App\Models\Activity;
use App\Models\Room;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnnouncementController;

// Public Pages (Accessible by guests)
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        $rooms = Room::whereNotNull('room_type')->get(); // Only include rooms with non-null room_type
        $activities = Activity::all(); // Fetch activities data as well
        return view('user.user-welcome', ['rooms' => $rooms, 'activities' => $activities]);
    });

    Route::get('/aboutus', fn() => view('about_us'));


    // Authentication routes for login, register, forgot password
    Route::get('/login', [UserController::class, 'index'])->name('login');
    Route::post('/login', [UserController::class, 'store']);
    // Show the email verification page
    Route::get('/verify-email', [OtpController::class, 'showVerifyEmailForm'])->name('verify.email');

    // Handle the OTP sending
    Route::post('/send-otp', [OtpController::class, 'sendOtp'])->name('send.otp');

    // Show the OTP verification form
    Route::get('/verify-otp', [OtpController::class, 'showVerifyOtpForm'])->name('verify.otp');

    // Handle the OTP verification
    Route::post('/verify-otp', [OtpController::class, 'verifyOtp'])->name('verify.otp.post');

    Route::get('/register', [UserRegisterController::class, 'index'])->name('register');
    Route::post('/register', [UserRegisterController::class, 'store']);
    Route::view('/forgot-password', 'auth.forgot-password')->name('password.request');
    Route::post('/forgot-password', [ResetPasswordController::class, 'passwordEmail']);
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'passwordReset'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'passwordUpdate'])->name('password.update');
});

// Protected Routes (Accessible only by authenticated users)
Route::middleware('auth')->group(function () {
    // Dashboard for logged-in users
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('home');
    Route::post('/logout', [UserController::class, 'destroy'])->name('logout');

    // User profile and bookings
    Route::get('/user/{id}', [UserDashboardController::class, 'show']);
    Route::get('/user/{id}/edit', [UserDashboardController::class, 'edit']);
    Route::patch('/user/{id}', [UserDashboardController::class, 'update'])->name('users.update');
    Route::get('/user/{id}/change_password', [UserDashboardController::class, 'ChangePassword']);
    Route::put('/user/{id}/edit/change_password', [UserDashboardController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::get('/my_bookings', [UserDashboardController::class, 'ViewBooking'])->name('view.booking');
    Route::get('/my_bookings/{booking_id}', [BookingController::class, 'viewDetailedBooking'])->name('viewDetailed.booking');
    Route::post('/cancel-booking/{booking_id}', [BookingController::class, 'cancelBooking'])->name('cancel.booking');
    Route::post('/submit-feedback', [BookingController::class, 'submitFeedback'])->name('submit.feedback');



    // Booking and checkout
    Route::post('/book', [CheckoutController::class, 'book'])->name('book');
    Route::get('/checkout/{type}/{id}', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::get('/user_paynow', [CheckoutController::class, 'userPaynow'])->name('user_paynow');
    Route::get('/pay-with-gcash', [CheckoutController::class, 'payWithPayMongo'])->name('pay-with-gcash');
    Route::get('/pay-with-card', [CheckoutController::class, 'payWithCard'])->name('pay-with-card');
    Route::get('/payment-success', [CheckoutController::class, 'success'])->name('payment-success');
    Route::get('/payment-failure', [CheckoutController::class, 'paymentFailure'])->name('payment-failure');
    Route::post('/webhook/paymongo', [CheckoutController::class, 'handleWebhook']);

    Route::get('/notifications', [NotificationController::class, 'getNotifications'])->name('notifications');


    //PayPal Routes
    Route::get('/pay-with-paypal', [CheckoutController::class, 'payWithPayPal'])->name('pay-with-paypal');
    Route::get('/paypal/success', [CheckoutController::class, 'paypalSuccess'])->name('paypal.success');
    Route::get('/paypal/cancel', [CheckoutController::class, 'paypalCancel'])->name('paypal.cancel');
});

// Routes Accessible to Both Guests and Authenticated Users
Route::get('/rooms', [RoomController::class, 'index']);
Route::get('/rooms/{room_id}', [RoomController::class, 'show'])->name('rooms.show');
Route::get('/activities', [ActivityController::class, 'index']);
Route::get('/activities/{activity_id}', [ActivityController::class, 'show'])->name('activities.show');
Route::get('/cottages', [PoolController::class, 'index']);
Route::get('/cottages/{pool_id}', [PoolController::class, 'show'])->name('pools.show');
Route::get('/function_hall', [HallController::class, 'index']);
Route::get('/function_hall/{hall_id}', [HallController::class, 'show'])->name('function-hall.show');
Route::get('/privacy', fn() => view('privacy'));
Route::get('/terms', fn() => view('terms_and_condition'))->name('terms_and_condition');

Route::post('/check-availability', [BookingController::class, 'checkAvailability'])->name('checkAvailability');
Route::get('/bookings', [BookingController::class, 'showAll'])->name('user.book');
Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');


// Newsletter Subscription (Accessible by both guests and authenticated users)
Route::post('/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscribe');
