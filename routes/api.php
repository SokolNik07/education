<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['prefix' => '/users', 'namespace' => 'App\Http\Controllers\User', 'middleware' => ['auth:sanctum', 'admin']], function () {
    Route::get('', 'IndexController')->name('user.index');
    Route::get('/{user}', 'ShowController')->name('user.show');
    Route::post('', 'StoreController')->name('user.store');
    Route::put('/{user}', 'UpdateController')->name('user.update');
    Route::delete('/{user}', 'DestroyController')->name('user.destroy');
});
Route::group(['prefix' => '/articles', 'namespace' => 'App\Http\Controllers\Article', 'middleware' => 'auth:sanctum'], function () {
    Route::get('', 'IndexController')->name('article.index');
    Route::get('/{article}', 'ShowController')->name('article.show');
    Route::post('', 'StoreController')->name('article.store');
    Route::put('/{article}', 'UpdateController')->name('article.update');
    Route::delete('/{article}', 'DestroyController')->name('article.destroy');
});
Route::group(['prefix' => '/videos', 'namespace' => 'App\Http\Controllers\Video', 'middleware' => 'auth:sanctum'], function () {
    Route::get('', 'IndexController')->name('video.index');
    Route::get('/{video}', 'ShowController')->name('video.show');
    Route::post('', 'StoreController')->name('video.store');
    Route::put('/{video}', 'UpdateController')->name('video.update');
    Route::delete('/{video}', 'DestroyController')->name('video.destroy');
});
Route::group(['prefix' => '/comments', 'namespace' => 'App\Http\Controllers\Comment', 'middleware' => 'auth:sanctum'], function () {
    Route::get('', 'IndexController')->name('comment.index');
    Route::get('/{comment}', 'ShowController')->name('comment.show');
    Route::post('', 'StoreController')->name('comment.store');
    Route::put('/{comment}', 'UpdateController')->name('comment.update');
    Route::delete('/{comment}', 'DestroyController')->name('comment.destroy');
});
Route::group(['namespace' => 'App\Http\Controllers\Registration'], function () {
    Route::post('/registration', 'RegistrationController')->name('registration');
    Route::post('/login', 'LoginController')->name('login');
    Route::get('/logout', 'LogoutController')->name('logout');
});

Route::get('/email/verify', function () {
    return view('verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
