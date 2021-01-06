<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\GroupController;

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
        Route::get('/{todo}', [TodoController::class, 'show'])->name('todos.show');
        Route::post('/', [TodoController::class, 'create'])->name('todos.create');
        Route::patch('/{todo}', [TodoController::class, 'update'])->name('todos.update');
        Route::delete('/{todo}', [TodoController::class, 'destroy'])->name('todos.destroy');
    });

    // GROUPS ROUTES
    Route::group(['prefix' => 'groups'], function () {
        Route::get('/', [GroupController::class, 'index'])->name('groups');
        Route::get('/{group}', [GroupController::class, 'show'])->name('groups.show');
        Route::post('/', [GroupController::class, 'create'])->name('groups.create');
        Route::patch('/{group}', [GroupController::class, 'update'])->name('groups.update');
        Route::delete('/{group}', [GroupController::class, 'destroy'])->name('groups.destroy');
    });
});
