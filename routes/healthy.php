<?php

use Illuminate\Support\Facades\Route;

// routes/web.php, api.php or any other central route files you have
        Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]], function()
        {
        Route::get('/', function () {  return response('OK', 200);});
        });  







