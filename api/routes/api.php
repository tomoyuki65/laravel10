<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// 今回は不要なのでコメントアウト
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')->group(function() {
    Route::post('/user', [UserController::class, 'create']);
    Route::get('/users', [UserController::class, 'users']);
    Route::get('/user/{uid}', [UserController::class, 'user']);
    Route::put('/user/{uid}', [UserController::class, 'update']);
    Route::delete('/user/{uid}', [UserController::class, 'delete']);
});
