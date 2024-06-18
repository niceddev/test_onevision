<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/posts');

Route::middleware('guest')
    ->prefix('auth')
    ->name('auth.')
    ->group(function () {

        Route::get('/login', [LoginController::class, 'index'])
            ->name('login.index');
        Route::post('/login', [LoginController::class, 'login'])
            ->name('login');
        Route::post('/logout', [LoginController::class, 'logout'])
            ->withoutMiddleware('guest')
            ->name('logout');

        Route::get('/', [RegisterController::class, 'index'])->name('register.index');
        Route::post('/register', [RegisterController::class, 'register'])->name('register');

    });

Route::middleware('auth')->resource('posts', PostController::class);
