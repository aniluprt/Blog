<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;


Route::get('/lifecycle-test', function () {
    return response()->json([
        'php_version' => PHP_VERSION,
        'timestamp' => now()->toIso8601String(),
        'message' => 'Laravel is running!',
        'framework_version' => app()->version(),
    ]);
})->name('lifecycle.test');

Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('posts.index');
    }
    return view('welcome');
})->name('welcome');

Route::get('/lifecycle-test', function () {
    return response()->json([
        'php_version' => PHP_VERSION,
        'timestamp'   => now()->toIso8601String(),
        'message'     => 'Laravel is running!',
    ]);
})->name('lifecycle.test');

Route::get('/suspended', function () {
    return view('suspended');
})->name('suspended');

Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

Route::middleware(['auth', 'active'])->group(function () {
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
});

Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');
Route::middleware(['auth', 'active'])->group(function () {
    Route::get('/dashboard', [PostController::class, 'dashboard'])->name('dashboard');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});

Route::middleware(['auth', 'active', 'permission:admin.dashboard'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard.index');
        Route::get('/users', [AdminController::class, 'users'])->middleware('permission:admin.users')->name('users');
        Route::post('/users/{user}/toggle-active', [AdminController::class, 'toggleUserActive'])->middleware('permission:admin.users')->name('users.toggle-active');
        Route::get('/roles', [AdminController::class, 'roles'])->middleware('permission:admin.roles')->name('roles');
        Route::post('/roles/{role}/permissions', [AdminController::class, 'updateRolePermissions'])->middleware('permission:admin.roles')->name('roles.permissions');
        Route::get('/posts', [AdminController::class, 'allPosts'])->middleware('permission:admin.posts')->name('posts');
        Route::delete('/posts/{post}', [AdminController::class, 'deletePost'])->middleware('permission:admin.posts')->name('posts.destroy');
    });


Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});

Route::fallback(function () {
    return view('errors.404');
});
