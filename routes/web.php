<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\TwoFAController;

Route::get('/', function () {
    return view('welcome');
})->name('landing');

Route::get('/login', 'Auth\LoginController@index')->middleware('guest')->name('login');
Route::post('/login', 'Auth\LoginController@login')->name('login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/register', 'Auth\RegisterController@index')->middleware('guest')->name('register');
Route::post('/register', 'Auth\RegisterController@create')->name('register');

Route::get('/2FA', [TwoFAController::class, 'show'])->middleware('auth')->name('2FA');
Route::post('/2FA', [TwoFAController::class, 'verify'])->middleware('auth')->name('2FA.verify');

Auth::routes();

Route::get('/home-no2FA', [HomeController::class, 'clearSecretKey'])->middleware('auth')->name('home-no2FA');
Route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home');
