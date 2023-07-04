<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\EventController;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [UserController::class, 'store'])->name('user.register');
Route::post('/login', [AuthController::class, 'login'])->name('user.login');

Route::get('/events', [EventController::class, 'index'])->name('event.index');
Route::get('/event/{id}', [EventController::class, 'show'])->name('event.show');



Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('user.logout');
    Route::get('/user/{id}', [UserController::class, 'show'])->name('user.show');
    Route::patch('/user/{id}', [UserController::class, 'update'])->name('user.update');

    Route::post('/create-event', [EventController::class, 'store'])->name('event.store');
    Route::post('/event/{id}', [EventController::class, 'update'])->name('event.update');
    Route::patch('/event/{id}', [EventController::class, 'deleteUser'])->name('event.delete-user');
    Route::delete('/event/{id}', [EventController::class, 'destroy'])->name('event.delete');
});
