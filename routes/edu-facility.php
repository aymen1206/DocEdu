<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\EduFacility\LetterController;
use App\Http\Controllers\EduFacility\LetterAbsController;
use App\Http\Controllers\EduFacility\LetterAppController;
use App\Http\Controllers\EduFacility\TemplatesController;
use App\Http\Controllers\EduFacility\TemplateOneController;
use App\Http\Controllers\EduFacility\TemplateTwoController;
use App\Http\Controllers\EduFacility\TemplateThreeController;


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
Route::get('APPRECIATION/','HomeController@appreciation');
Route::get('/users', [HomeController::class, 'users'])->name('home');

Route::get('/letter', [LetterController::class, 'form']); // صفحة اختبار/نموذج (اختياري)
Route::post('/letter/generate', [LetterController::class, 'generate'])->name('letter.generate');
Route::post('/letter/download-word', [LetterController::class, 'downloadWord'])->name('letter.word');
Route::post('/letter/download-pdf', [LetterController::class, 'downloadPdf'])->name('letter.pdf');
Route::post('/letter/preview', [LetterController::class, 'preview'])->name('letter.preview');


Route::get('AbsenceNotification/letter', [LetterAbsController::class, 'form']); // صفحة اختبار/نموذج (اختياري)
Route::post('AbsenceNotification/letter/generate', [LetterAbsController::class, 'generate'])->name('abs.letter.generate');
Route::post('AbsenceNotification/letter/download-word', [LetterAbsController::class, 'downloadWord'])->name('abs.letter.word');
Route::post('AbsenceNotification/letter/download-pdf', [LetterAbsController::class, 'downloadPdf'])->name('abs.letter.pdf');
Route::post('AbsenceNotification/letter/preview', [LetterAbsController::class, 'preview'])->name('abs.letter.preview');

Route::get('APPRECIATION/letter', [LetterAppController::class, 'appreciationForm'])->name('appreciation.form');
Route::post('APPRECIATION/generate', [LetterAppController::class, 'generateAppreciation'])->name('appreciation.generate');
Route::post('APPRECIATION/download-word', [LetterAppController::class, 'downloadAppreciationWord'])->name('appreciation.word');
Route::post('APPRECIATION/download-pdf', [LetterAppController::class, 'downloadAppreciationPdf'])->name('appreciation.pdf');



Route::get('appreciation/template-1', [TemplatesController::class, 'templateOne']);
Route::get('appreciation/template-2', [TemplatesController::class, 'templateTwo']);
Route::get('appreciation/template-3', [TemplatesController::class, 'templateThree']);



Route::post('appreciation/template-1/generate', [TemplateOneController::class, 'generate'])->name('tempOne.generate');
Route::post('appreciation/template-1/download-word', [TemplateOneController::class, 'downloadWord'])->name('tempOne.word');
Route::post('appreciation/template-1/download-pdf', [TemplateOneController::class, 'downloadPdf'])->name('tempOne.pdf');
Route::post('appreciation/template-1/preview', [TemplateOneController::class, 'preview'])->name('tempOne.preview');


Route::post('appreciation/template-2/generate', [TemplateTwoController::class, 'generate'])->name('tempTwo.generate');
Route::post('appreciation/template-2/download-word', [TemplateTwoController::class, 'downloadWord'])->name('tempTwo.word');
Route::post('appreciation/template-2/download-pdf', [TemplateTwoController::class, 'downloadPdf'])->name('tempTwo.pdf');
Route::post('appreciation/template-2/preview', [TemplateTwoController::class, 'preview'])->name('tempTwo.preview');


Route::post('appreciation/template-3/generate', [TemplateThreeController::class, 'generate'])->name('tempThree.generate');
Route::post('appreciation/template-3/download-word', [TemplateThreeController::class, 'downloadWord'])->name('tempThree.word');
Route::post('appreciation/template-3/download-pdf', [TemplateThreeController::class, 'downloadPdf'])->name('tempThree.pdf');
Route::post('appreciation/template-3/preview', [TemplateThreeController::class, 'preview'])->name('tempThree.preview');
