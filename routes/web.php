<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;

Route::get('/', [PostController::class, 'index'])
    ->middleware('auth')
    ->name('home');

Route::get('/home', function () {
    return redirect('/');
})->name('home');

Auth::routes();

// Posts routes
Route::group(['prefix' => 'posts'], function () {
    $controller = PostController::class;
    Route::get('',               [$controller,'index'])  ->name('posts.index');
    Route::post('/',             [$controller,'store'])  ->name('posts.store');
    Route::get('/create',        [$controller,'create']) ->name('posts.create');
    Route::get('/{post}',        [$controller,'show'])   ->name('posts.show');
    Route::get('/{post}/edit',   [$controller,'edit'])   ->name('posts.edit');
    Route::patch('/{post}',      [$controller,'update']) ->name('posts.update');
    Route::delete('/{post}',     [$controller,'destroy'])->name('posts.destroy');
});

// Profile routes
Route::group(['prefix' => 'profile'], function () {
    $controller = ProfileController::class;
    Route::get('/{user}',      [$controller,'index'])  ->name('profile.show');
    Route::get('/{user}/edit', [$controller,'edit'])   ->name('profile.edit');
    Route::patch('/{user}',    [$controller,'update']) ->name('profile.update');
});

// Comment routes
Route::post('/posts/{post}/comments',[CommentController::class,'store'])  ->name('comments.store');
Route::delete('/comments/{comment}', [CommentController::class,'destroy'])->name('comments.destroy');

// Like routes
Route::post('/posts/{post}/likes',   [LikeController::class,'store'])  ->name('likes.store');
Route::delete('/posts/{post}/likes', [LikeController::class,'destroy'])->name('likes.destroy');
