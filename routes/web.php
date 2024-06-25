<?php

use App\Http\Controllers\Backend;
use App\Http\Controllers\Backend\KategoriController;
use App\Http\Controllers\Backend\LantaiController;
use App\Http\Controllers\Backend\LokasiController;
use App\Http\Controllers\Backend\PermintaanController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return ['Laravel' => app()->version()];
// });
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [Backend::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [Backend::class, 'profile'])->name('profile.edit');
});

Route::get('/', [Backend::class, 'signin'])->name('signin');
Route::get('/register', [Backend::class, 'register'])->name('register');

Route::middleware('auth')->group(function () {
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::resource('lantai', LantaiController::class); //lantai
    Route::resource('lokasi', LokasiController::class); //lokasi
    Route::resource('kategori', KategoriController::class); //kategori
    Route::resource('permintaan', PermintaanController::class); //permintaan
    Route::post('/permintaan/{id}/status/{status}', [PermintaanController::class, 'updateStatus'])->name('permintaan.updateStatus');
    Route::resource('user', UserController::class); //user
});

require __DIR__ . '/auth.php';
