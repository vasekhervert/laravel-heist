<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginPageController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PostController;

Route::get('/', [LoginPageController::class, 'index'])->name('login');
Route::get('/dashboard', [LoginPageController::class, 'dashboard'])
    ->middleware('auth')
    ->name('dashboard');
Route::post('/logout', [AuthController::class, 'webLogout'])->name('logout');

Route::post('/login', [AuthController::class, 'loginWithEmail'])->name('login.email');

Route::middleware(['auth'])->group(function () {
    Route::post('/posts', [PostController::class, 'storeWeb'])->name('posts.store');
    Route::delete('/posts/{post}', [PostController::class, 'destroyWeb'])->name('posts.destroy');
    Route::put('/posts/{post}', [PostController::class, 'updateWeb'])->name('posts.update');
});

Route::get('/login-user/{id}', function($id) {
    $user = \App\Models\User::find($id);
    
    if (!$user) {
        return redirect()->route('login')
            ->with('error', 'Uživatel nenalezen');
    }
    
    auth()->login($user);
    
    return redirect()->route('dashboard')
        ->with('success', 'Úspěšně jste se přihlásili');
});

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');
