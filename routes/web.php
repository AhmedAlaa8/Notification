<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::resource('post',\App\Http\Controllers\PostController::class)->middleware(['auth']);
Route::get('xx',[\App\Http\Controllers\PostController::class,'xx'])->name('xx')->middleware(['auth']);

require __DIR__.'/auth.php';
