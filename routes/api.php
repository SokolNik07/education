<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['namespace' => 'App\Http\Controllers\User'], function () {
    Route::get('/users', 'IndexController')->name('user.index');
    Route::get('/users/{user}', 'ShowController')->name('user.show');
    Route::get('/users/create', 'CreateController')->name('user.create');
    Route::post('/users', 'StoreController')->name('user.store');
    Route::get('/users/edit/{user}', 'EditController')->name('user.edit');
    Route::patch('/users/{user}', 'UpdateController')->name('user.update');
    Route::delete('/users/{user}', 'DestroyController')->name('user.destroy');
});
//Route::group(['namespace' => 'App\Http\Controllers\Article'], function () {
//    Route::get('/articles', 'IndexController')->name('article.index');
//    Route::get('/articles/{article}', 'ShowController')->name('article.show');
//    Route::get('/articles/create', 'CreateController')->name('article.create');
//    Route::post('/articles', 'StoreController')->name('article.store');
//    Route::get('/articles/edit/{article}', 'EditController')->name('article.edit');
//    Route::patch('/articles/{article}', 'UpdateController')->name('article.update');
//    Route::delete('/articles/{article}', 'DestroyController')->name('article.destroy');
//});
//Route::group(['namespace' => 'App\Http\Controllers\Video'], function () {
//    Route::get('/videos', 'IndexController')->name('video.index');
//    Route::get('/videos/{video}', 'ShowController')->name('video.show');
//    Route::get('/videos/create', 'CreateController')->name('video.create');
//    Route::post('/videos', 'StoreController')->name('video.store');
//    Route::get('/videos/edit/{video}', 'EditController')->name('video.edit');
//    Route::patch('/videos/{video}', 'UpdateController')->name('video.update');
//    Route::delete('/videos/{video}', 'DestroyController')->name('video.destroy');
//});
//Route::group(['namespace' => 'App\Http\Controllers\Comment'], function () {
//    Route::get('/comments', 'IndexController')->name('comment.index');
//    Route::get('/comments/{comment}', 'ShowController')->name('comment.show');
//    Route::get('/comments/create', 'CreateController')->name('comment.create');
//    Route::post('/comments', 'StoreController')->name('comment.store');
//    Route::get('/comments/edit/{comment}', 'EditController')->name('comment.edit');
//    Route::patch('/comments/{comment}', 'UpdateController')->name('comment.update');
//    Route::delete('/comments/{comment}', 'DestroyController')->name('comment.destroy');
//});
Route::group(['namespace' => 'App\Http\Controllers\Registration'], function () {
    Route::get('/registration', 'IndexController')->name('registration.index');
    Route::post('/registration', 'RegistrationController')->name('registration');
    Route::get('/login', 'LoginIndexController')->name('login.index');
    Route::post('/login', 'LoginController')->name('login');
    Route::get('/logout', 'LogoutController')->name('logout');
});
