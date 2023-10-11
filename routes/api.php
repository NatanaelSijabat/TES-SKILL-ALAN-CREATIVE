<?php

use App\Http\Controllers\Api\FoodController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::resource('/food', FoodController::class);

Route::get('/food', [FoodController::class, 'index']);
Route::get('/food/{id}', [FoodController::class, 'show']);
Route::post('/food', [FoodController::class, 'store']);
Route::post('/food/{id}', [FoodController::class, 'update']);
Route::delete('/food/{id}', [FoodController::class, 'destroy']);
