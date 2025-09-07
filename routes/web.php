<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Routes;

// Root page shows posts if authenticated
Route::get('/', [PostController::class, 'index'])
    ->middleware('auth')
    ->name(Routes::HOME);

Route::get('/home', function () {
    return redirect('/');
})->name(Routes::HOME);

Auth::routes();

// Posts routes
Route::controller(PostController::class)
        ->prefix('posts')
        ->group(function () {
            Route::get('',             'index')   ->name(Routes::POSTS_INDEX);
            Route::post('/',           'store')   ->name(Routes::POSTS_STORE);
            Route::get('/create',      'create')  ->name(Routes::POSTS_CREATE);
            Route::get('/{post}',      'show')    ->name(Routes::POSTS_SHOW);
            Route::get('/{post}/edit', 'edit')    ->name(Routes::POSTS_EDIT);
            Route::patch('/{post}',    'update')  ->name(Routes::POSTS_UPDATE);
            Route::delete('/{post}',   'destroy') ->name(Routes::POSTS_DESTROY);
});

// Profile routes
Route::controller(ProfileController::class)
        ->prefix('profile')
        ->group(function () {
            Route::get('/{user}',      'index')  ->name(Routes::PROFILE_SHOW);
            Route::get('/{user}/edit', 'edit')   ->name(Routes::PROFILE_EDIT);
            Route::patch('/{user}',    'update') ->name(Routes::PROFILE_UPDATE);
});

// Comment routes
Route::post('/posts/{post}/comments',[CommentController::class,'store'])  ->name(Routes::COMMENTS_STORE);
Route::delete('/comments/{comment}', [CommentController::class,'destroy'])->name(Routes::COMMENTS_DESTROY);

// Like routes
Route::post('/posts/{post}/likes',   [LikeController::class,'store'])  ->name(Routes::LIKES_STORE);
Route::delete('/posts/{post}/likes', [LikeController::class,'destroy'])->name(Routes::LIKES_DESTROY);
