<?php

use Illuminate\Support\Facades\Route;
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

Route::apiResource('users', UserController::class);
Route::post('users_restore/{id}', [UserController::class, 'restore'])->name('user.restore');
Route::get('users_with_trashed/{id}', [UserController::class, 'findByIdWithTrashed'])->name('user.withTrashed');