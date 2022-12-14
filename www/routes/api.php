<?php

use App\Http\Controllers\UserController;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group([
//    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'users'

], function ($router) {
    Route::get('list', [UserController::class, 'index'])->name('users');
    Route::post('store', [UserController::class, 'store'])->name('user.store');
    Route::delete('delete/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::put('update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::get('{id}', [UserController::class, 'show'])->name('user.show');
});
