<?php

use App\Http\Controllers\Student\HomeController;
use App\Http\Controllers\Student\Auth\LoginController;
use App\Http\Controllers\Student\CustomAuthcontroller;
use App\Http\Controllers\Student\FavoritesController;
use App\Http\Controllers\Student\ChildrenController;
use App\Http\Controllers\Student\OrderController;
use Illuminate\Support\Facades\Route;
// Dashboard
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::post('register',  [CustomAuthcontroller::class, 'register'])->name('st_register');


// favorites
Route::get('favorites',  [FavoritesController::class,'index']);
Route::get('/Consatlations', [HomeController::class,'Consatlations']);
Route::get('/RentConsaltation/{stid}', [HomeController::class,'RentConsaltation']);
Route::post('/remove-from-favorite/{id}', [FavoritesController::class,'removeFromFavorite'])->name('favorite.remove');
Route::post('/add-to-favorite/{id}', [FavoritesController::class,'addToFavorite'])->name('favorite.add');

Route::post('RegistrationForm', [CustomAuthcontroller::class, 'RegistrationForm'])->name('RegistrationForm');
Route::get('childrens',[ChildrenController::class, 'index']);
Route::post('child/add',[ChildrenController::class, 'store'])->name('StoreChild');
Route::post('child/update',[ChildrenController::class, 'update'])->name('EditChild');
Route::post('childrens/{id}/delete',[ChildrenController::class, 'destroy'])->name('childrens.remove');
Route::get('childrens/{id}/edit',[ChildrenController::class, 'edit']);
Route::get('profile', [CustomAuthcontroller::class, 'profile'])->name('profile');
Route::post('profile/update', [CustomAuthcontroller::class, 'updateProfile'])->name('st_profile');


Route::get('orders', [OrderController::class, 'index']);
Route::get('make-order/{id}/{pr_id}', [OrderController::class, 'create']); 
Route::get('order/cancel/{id}', [OrderController::class, 'cancel']);
Route::get('order/Pay/{id}/{method}', [OrderController::class, 'Pay']);
Route::get('order/invoice/{id}', [OrderController::class, 'invoice']);
Route::post('make-order', [OrderController::class, 'store'])->name('makeorder');


// Login
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');

// Register
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');


// Reset Password
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');

Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');


// Confirm Password
Route::get('password/confirm', 'Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');

//profile change password
Route::get('change-password', 'HomeController@changePassword');
Route::post('change-password', 'HomeController@changePasswordPost')->name('st_reset_password');


// notifications
Route::get('notifications', 'NotificationController@index');

// notifications


// orders 
Route::get('tabby-success/{id}', 'OrderController@Tabbysuccess');
Route::get('tabby-cancel', 'OrderController@Tabbycancel');
Route::get('tabby-failure', 'OrderController@Tabbyfailure');
Route::get('Jeel-Payment/{id}', 'OrderController@JeelResponse');
Route::get('jeel-installments/{order_id}', 'PaymentController@jeelPay');

Route::get('get-payment-methods/{order_id}', 'PaymentController@getPaymentMethods');
Route::get('pay/{order_id}/{method_id}', 'PaymentController@requesPaymentLink');
Route::get('successful-payment', 'PaymentController@checkPayment')->name('tap.callback');
Route::get('invoice/{invoice_id}/{order_id}', 'PaymentController@invoice');


Route::get('tamara-payment/{order_id}', 'PaymentController@tamaraPayment');
Route::get('alrajhi-installments/{order_id}', 'PaymentController@alrajhiInstallements');
Route::post('alrajhi-installments/{order_id}', 'PaymentController@createAlrajhiInstallements');

Route::get('tamara/{order_id}', 'PaymentController@Tamara');
Route::get('tamara/invoice/{order_id}', 'PaymentController@TamaraInvoice');


Route::get('tabby/{order_id}', 'PaymentController@tabbyPayment');
Route::get('tabby-payment/{order_id}', 'PaymentController@TabbyPreScoring');




Route::post('login', 'Auth\LoginController@login')->name('st_login');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
Route::post('password/confirm', 'Auth\ConfirmPasswordController@confirm')->name('password_confirm');

Route::post('childrens/complete-account', 'CustomAuthcontroller@completeAccountData')->name('childrens_complete_account');
Route::post('make-order/complete-account', 'CustomAuthcontroller@completeAccountOrder')->name('make_order_complete_account');
Route::post('rate', 'HomeController@rate')->name('rate');
Route::post('facility/rate', 'HomeController@facilityRate')->name('facility.rate');
Route::get('/Skip-rate/{facility_ID}/skip', 'HomeController@skipRate');

// Verify Email
// Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
// Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
// Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
//

Route::get('phone/verify', 'PhoneAuthController@index');
Route::get('phone/verify/{id}/{hash}', 'PhoneAuthController@verify');
Route::post('phone/resend', 'PhoneAuthController@resend');
Route::get('phone-auth', 'PhoneAuthController@index');
Route::get('otp-success', 'PhoneAuthController@otpSuccess');

 