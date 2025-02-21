<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\BookController;
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

Route::post('/register', [AuthController::class, 'register'])->name('api.register');
Route::post('/login', [AuthController::class, 'login'])->name('api.login');

// Book
Route::middleware(['auth:sanctum', 'role:admin,editor,viewer',])->prefix('books')->group(function () {
    Route::get('/', [BookController::class, 'index'])->name('api.index');

    Route::middleware(['auth:sanctum', 'role:admin,editor'])->group(function () {
        Route::post('/store', [BookController::class, 'store'])->name('api.store');
        Route::post('/update/{id}', [BookController::class, 'update'])->name('api.update');
    });

    Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
        Route::delete('/delete/{id}', [BookController::class, 'destroy'])->name('api.delete');
    });
});
