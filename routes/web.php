<?php

use App\Http\Controllers\AdministrationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FacebookController;
use App\Http\Controllers\GithubController;
use App\Http\Controllers\GoogleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/**
 * Login
 */
Route::get('', [AuthController::class, 'index'])->name('login-page');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

/**
 * Facebook login URL - not working on localhost
 */
Route::prefix('facebook')->name('facebook.')->group( function() {
    Route::get('auth', [FacebookController::class, 'loginUsingFacebook'])->name('login');
    Route::get('callback', [FacebookController::class, 'callbackFromFacebook'])->name('callback');
});


/**
 * Google login URL
 */
Route::prefix('google')->name('google.')->group( function() {
    Route::get('login', [GoogleController::class, 'loginWithGoogle'])->name('login');
    Route::any('callback', [GoogleController::class, 'callbackFromGoogle'])->name('callback');
});

/**
 * Github login URL
 */
Route::prefix('github')->name('github.')->group( function() {
    Route::get('login', [GithubController::class, 'loginUsingGithub'])->name('login');
    Route::any('callback', [GithubController::class, 'callbackFromGithub'])->name('callback');
});


/**
 * Admin
 */
Route::middleware(['auth'])->prefix('admin')->name('admin.')->as('admin.')->group(function () {
    Route::get('/', [AdministrationController::class, 'index'])->name('index');
});
