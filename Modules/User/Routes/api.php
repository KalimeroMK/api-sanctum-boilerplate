<?php

use Modules\User\Http\Controllers\UserController;

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

Route::apiResource('users', UserController::class)->except('update');
Route::get('userinfo', [UserController::class, 'authUser']);
Route::post('user_news_category', [UserController::class, 'addUsersNewsCategory']);
Route::post('users/{id}', [UserController::class, 'update'])->name('user.update');
Route::post('users_restore/{id}', [UserController::class, 'restore'])->name('user.restore');