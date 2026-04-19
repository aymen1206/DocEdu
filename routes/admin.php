<?php

use Illuminate\Support\Facades\Route;

// Dashboard
Route::get('/', 'HomeController@index')->name('home');
Route::get('/notifications', 'HomeController@notifications')->name('notifications');
Route::get('/notification/{id}', 'HomeController@notification')->name('notification');
// Login
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// Register
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Reset Password
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// Confirm Password
Route::get('password/confirm', 'Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
Route::post('password/confirm', 'Auth\ConfirmPasswordController@confirm');

// Verify Email
// Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
// Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
// Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

//----------------------- settings -----------------------------
Route::resource('setting','SettingController');
Route::get('legal','SettingController@legal');
Route::get('legal/edit','SettingController@legalEdit');
Route::post('legal/update','SettingController@updateTerms');
Route::post('tc/update','SettingController@legalTCUpdate');

//----------------------- profile -----------------------------
Route::get('profile','AdminController@profile');
Route::post('profile','AdminController@updateProfile');


//-------------------------Gallary----------------------------------



Route::get('gallery/{id}','GalleryController@index');
Route::get('gallery/create/{id}','GalleryController@create');
Route::Post('galleryUpload','GalleryController@galleryUpload')->name('galleryUpload');
Route::get('gallery/{Facid}/{id}/delete','GalleryController@destroy');

//----------------------- facilities types -----------------------------
Route::resource('facilities-types','EduFacilitiesTypeController');
Route::get('facilities-types/{id}/delete','EduFacilitiesTypeController@destroy');

//----------------------- Stages -----------------------------
Route::resource('stages','EduStageController');
Route::get('stages/{id}/delete','EduStageController@destroy');

//----------------------- Types -----------------------------
Route::resource('types','TypeController');
Route::get('types/{id}/delete','TypeController@destroy');

//----------------------- Edu Facilities -----------------------------
Route::resource('edu-facilities','EduFacilitiesController');
Route::get('edu-facilities/{id}/delete','EduFacilitiesController@destroy');
Route::get('edu-facilities/{id}/softdelete','EduFacilitiesController@softdelete');
Route::get('trashed/edu-facilities/','EduFacilitiesController@trashed');
Route::get('edu-facilities/{id}/restore','EduFacilitiesController@restore');
Route::get('edu-facilities/{status}/{id}','EduFacilitiesController@statusSwicher');
Route::get('get_stages/{id}','EduFacilitiesController@getStages');

Route::get('finance-profile/{id}','EduFacilitiesController@finance');
Route::post('finance-profile/update/{id}','EduFacilitiesController@financeUpdate');
Route::get('edu-facilities-balance/{id}/balance_withdrawal','EduFacilitiesController@balanceWithdrawalShow');
Route::post('edu-facilities-balance/confirm','EduFacilitiesController@balanceWithdrawalConfirm');


//----------------------- About -----------------------------
Route::resource('about','AboutController');
Route::get('adminlogs','AdminLogController@index');
Route::get('logs/{id}','AdminLogController@log');
//----------------------- Ratings -----------------------------
Route::resource('ratings','RatingController');
Route::get('ratings/{id}/status','RatingController@status');

//-------------------- Contacts -----------------------------
Route::resource('contact','ContactsController'); 
Route::resource('blog','BlogController');
Route::get('blog/{id}/delete','BlogController@destroy');
//-------------------- Messages -----------------------------
Route::resource('messages','MessageController');
Route::get('messages/delete/{message}','MessageController@destroy');
Route::get('messages/read/{id}','MessageController@ReadMessage');

//--------------------------- Withdrawal ------------------
Route::resource('withdrawal','WithdrawalController');

// -------------------------center-types --------------------------

Route::resource('center-types','CenterTypesController');

//------------------------- delete sp ---------------------------------
Route::get('sp/delete/{id}','EduFacilitiesController@deleteSp');

//----------------------- Orders -----------------------------------
Route::resource('orders','OrderController'); 
Route::put('orders/edit/','OrderController@update')->name('updateStatus');
//----------------------- ads -----------------------------------
Route::resource('ads','FacilityAdController');
Route::get('ads/{id}/delete','FacilityAdController@destroy');

//---------------------------- advertisements -----------------------
Route::resource('advertisements','AdvertisementController');
Route::get('advertisements/{id}/delete','AdvertisementController@destroy');
//-------------------------- languages ----------------------------
Route::resource('languages','LanguageController');
// Route::get('languages/{id}/delete','LanguageController@destroy');

//--------------------------------- currencies ----------------------
Route::resource('currencies','CurrencyContoller');
Route::get('currencies/{id}/delete','CurrencyContoller@destroy');

Route::resource('paymentmethods','PaymentMethodsContoller');
Route::get('paymentmethods/{id}/delete','PaymentMethodsContoller@destroy');

Route::resource('subjects','SubjectsContoller');
Route::get('subjects/{id}/delete','SubjectsContoller@destroy');

Route::resource('commission','CommissionController');
Route::get('financial','FinancialLogsController@index');
Route::get('incomes','FinancialLogsController@incomes');
Route::get('dues','FinancialLogsController@dues');
Route::get('instalmentprovider','FinancialLogsController@instalmentprovider');
Route::get('financial-logs','FinancialLogsController@logs');
Route::get('facility-financial-logs/{id}','FinancialLogsController@facilitieslogs');
Route::get('facility-financial-logs/orders/{id}','FinancialLogsController@facilitieslogsorders');
Route::get('invoices/{id}','FinancialLogsController@invoices');
Route::get('invoice/details/{invid}/{facid}','FinancialLogsController@invoicedetails');

Route::post('orders/collect/','FinancialLogsController@orderscollect')->name('orders.collect');

Route::resource('seo','SeosettingController');

//----------------------- profile -----------------------------
Route::get('tamara','TamaraController@index');
Route::get('tamara/edit','TamaraController@edit');
Route::post('tamara','TamaraController@update');



Route::get('tabby','TabbyController@index');
Route::get('tabby/edit','TabbyController@edit');
Route::post('tabby','TabbyController@update');


Route::get('jeel','JeelController@index');
Route::get('jeel/edit','JeelController@edit');
Route::post('jeel','JeelController@update');
//----------------------- Students ----------------------------

Route::resource('students','StudentsController');
Route::get('student/{id}/delete','StudentsController@destroy');
Route::get('student/{id}/edit','StudentsController@edit');
Route::put('student/{id}/','StudentsController@update');
Route::get('student/{id}/','StudentsController@show');


//----------------------- recommended-facility ----------------------------


Route::resource('recommended-facility','RecommendedFacilityController');

Route::get('recommended-facility/{id}/delete','RecommendedFacilityController@destroy');


//----------------------- recommended-home-care ----------------------------

Route::resource('recommended-home-care','RecommendedHomeCareController');
Route::get('recommended-home-care/{id}/delete','RecommendedHomeCareController@destroy');


Route::resource('commentsOnMain','CommentsOnMainController');
Route::get('commentsOnMain/{id}/reject','CommentsOnMainController@reject');
Route::get('commentsOnMain/{id}/accept','CommentsOnMainController@accept');


Route::resource('commentsOnBlogs','CommentsOnBlogsController');
Route::get('commentsOnBlogs/{id}/reject','CommentsOnBlogsController@reject');
Route::get('commentsOnBlogs/{id}/accept','CommentsOnBlogsController@accept');

Route::resource('Finances/','FinancesController'); 
Route::get('Finances/read/{id}','FinancesController@ReadFinances');


Route::get('facility-prices/{fid}','FacilityPriceController@index');
Route::get('prices/{facilityid}/{id}/show','FacilityPriceController@show');
Route::get('prices/{facilityid}/{id}/edit','FacilityPriceController@edit');
Route::post('prices/update','FacilityPriceController@update')->name('priceupdate');
Route::get('prices/create/{fid}','FacilityPriceController@create');
Route::post('pricesCreat','FacilityPriceController@store')->name('pricecreate');
Route::get('prices/{facilityid}/{id}/delete','FacilityPriceController@destroy');



Route::get('get_facility_types/{id}','HomeController@getFacilityTypes');
Route::get('get_stages/{id}','HomeController@getFacilityStages');
Route::get('get_payment_methods/{id}','HomeController@getPymentMethod');