<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['prefix' => '/users', 'namespace' => 'App\Http\Controllers\User', 'middleware' => ['auth:sanctum', 'admin']], function () {
    Route::get('', 'UserCRUDController@index')->name('user.index');
    Route::get('/{id}', 'UserCRUDController@show')->name('user.show');
    Route::post('', 'UserCRUDController@store')->name('user.store');
    Route::put('/{id}', 'UserCRUDController@update')->name('user.update');
    Route::delete('/{id}', 'UserCRUDController@destroy')->name('user.destroy');
});
Route::group(['prefix' => '/characters', 'namespace' => 'App\Http\Controllers\Character', 'middleware' => 'auth:sanctum'], function () {
    Route::get('', 'CharacterCRUDController@index')->name('character.index');
    Route::get('/{id}', 'CharacterCRUDController@show')->name('character.show');
    Route::post('', 'CharacterCRUDController@store')->name('character.store');
    Route::post('/{id}', 'CharacterCRUDController@update')->name('character.update');
    Route::delete('/{id}', 'CharacterCRUDController@destroy')->name('character.destroy');
});
Route::group(['prefix' => '/fractions', 'namespace' => 'App\Http\Controllers\Fraction', 'middleware' => 'auth:sanctum'], function () {
    Route::get('', 'FractionCRUDController@index')->name('fraction.index');
    Route::get('/{id}', 'FractionCRUDController@show')->name('fraction.show');
    Route::post('', 'FractionCRUDController@store')->name('fraction.store');
    Route::post('/{id}', 'FractionCRUDController@update')->name('fraction.update');
    Route::delete('/{id}', 'FractionCRUDController@destroy')->name('fraction.destroy');
});
Route::group(['prefix' => '/articles', 'namespace' => 'App\Http\Controllers\Article', 'middleware' => 'auth:sanctum'], function () {
    Route::get('', 'ArticleCRUDController@index')->name('article.index');
    Route::get('/{id}', 'ArticleCRUDController@show')->name('article.show');
    Route::post('', 'ArticleCRUDController@store')->name('article.store');
    Route::post('/{id}', 'ArticleCRUDController@update')->name('article.update');
    Route::delete('/{id}', 'ArticleCRUDController@destroy')->name('article.destroy');
});
Route::group(['prefix' => '/videos', 'namespace' => 'App\Http\Controllers\Video', 'middleware' => 'auth:sanctum'], function () {
    Route::get('', 'VideoCRUDController@index')->name('video.index');
    Route::get('/{id}', 'VideoCRUDController@show')->name('video.show');
    Route::post('', 'VideoCRUDController@store')->name('video.store');
    Route::put('/{id}', 'VideoCRUDController@update')->name('video.update');
    Route::delete('/{id}', 'VideoCRUDController@destroy')->name('video.destroy');
});
Route::group(['prefix' => '/comments', 'namespace' => 'App\Http\Controllers\Comment', 'middleware' => 'auth:sanctum'], function () {
    Route::get('', 'CommentCRUDController@index')->name('comment.index');
    Route::get('/{id}', 'CommentCRUDController@show')->name('comment.show');
    Route::post('', 'CommentCRUDController@store')->name('comment.store');
    Route::put('/{id}', 'CommentCRUDController@update')->name('comment.update');
    Route::delete('/{id}', 'CommentCRUDController@destroy')->name('comment.destroy');
});
Route::group(['namespace' => 'App\Http\Controllers\Auth'], function () {
    Route::post('/registration', 'AuthController@registration')->name('registration');
    Route::post('/login', 'AuthController@login')->name('login');
    Route::get('/logout', 'AuthController@logout')->name('logout');
    Route::post('/forgot-password', 'AuthController@forgotPassword')->name('forgot.password');
    Route::post('/reset-password', 'AuthController@resetPassword')->name('password.reset');
});
Route::group(['prefix' => '/files', 'namespace' => 'App\Http\Controllers\FileManager', 'middleware' => 'auth:sanctum'], function () {
    Route::get('', 'FileManagerController@index')->name('file.index');
    Route::post('', 'FileManagerController@store')->name('file.store');
    Route::put('/{name}', 'FileManagerController@update')->name('file.update');
    Route::get('/{name}', 'FileManagerController1@show')->name('file.show');
    Route::delete('/{name}', 'FileManagerController@destroy')->name('file.destroy');
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
