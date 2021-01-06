<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TodoController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// V1 APIS
Route::group(['prefix' => 'v1'], function () {

    // TODOS ROUTES
    Route::group(['prefix' => 'todos'], function () {
        Route::get('/', [TodoController::class, 'index'])->name('todos');
    });
});
