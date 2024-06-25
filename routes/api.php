<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\KategoriController;
use App\Http\Controllers\API\LantaiController;
use App\Http\Controllers\API\LokasiController;
use App\Http\Controllers\Api\PermintaanController;
use App\Http\Controllers\Api\UserController;
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

Route::get('/profile', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
// Route::apiResource('/constans', ConstansController::class);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::apiResource('/lantai', LantaiController::class);
    Route::apiResource('/lokasi', LokasiController::class);
    Route::apiResource('/kategori', KategoriController::class);
    Route::apiResource('/user', UserController::class);
    Route::apiResource('/permintaan', PermintaanController::class);

    Route::put('permintaan/{id}/status/{status}', [PermintaanController::class, 'updateStatus']);
});
