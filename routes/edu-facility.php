<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\EduFacility\LetterController;
use App\Http\Controllers\EduFacility\LetterAbsController;

use App\Http\Controllers\EduFacility\HomeController;
// Dashboard
Route::get('/', [HomeController::class, 'index'])->name('home');

// Login
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout'); 

//----------------------- profile -----------------------------
Route::get('profile/show','ProfileController@show');
Route::get('profile','ProfileController@profile');
Route::post('profile/update/','ProfileController@updateProfile')->name('profile.update');
//--------------------------- Password reset -----------------
Route::get('reset-password','ProfileController@getResetPassword');
Route::post('reset-password','ProfileController@ResetPassword');


Route::get('ParentCallNotice/','HomeController@parentCallNotice');
Route::get('AbsenceNotification/','HomeController@absenceNotification');
Route::get('/users', [HomeController::class, 'users'])->name('home');

Route::get('/letter', [LetterController::class, 'form']); // صفحة اختبار/نموذج (اختياري)
Route::post('/letter/generate', [LetterController::class, 'generate'])->name('letter.generate');
Route::post('/letter/download-word', [LetterController::class, 'downloadWord'])->name('letter.word');
Route::post('/letter/download-pdf', [LetterController::class, 'downloadPdf'])->name('letter.pdf');


Route::get('AbsenceNotification/letter', [LetterAbsController::class, 'form']); // صفحة اختبار/نموذج (اختياري)
Route::post('AbsenceNotification/letter/generate', [LetterAbsController::class, 'generate'])->name('abs.letter.generate');
Route::post('AbsenceNotification/letter/download-word', [LetterAbsController::class, 'downloadWord'])->name('abs.letter.word');
Route::post('AbsenceNotification/letter/download-pdf', [LetterAbsController::class, 'downloadPdf'])->name('abs.letter.pdf');
