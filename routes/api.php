<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// public re
Route::get('/posts', [PostController::class, 'index'])->name('api.posts.index');
Route::get('/posts/{slug}', [PostController::class, 'show'])->name('api.posts.show');

// login ra logout
Route::post('/login', [AuthController::class, 'login'])->name('api.login');
Route::delete('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('api.logout');


//protected re
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', fn (Request $request) => $request->user()->load('role'));
    Route::post('/posts', [PostController::class, 'store'])->name('api.posts.store');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('api.posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('api.posts.destroy');
});
