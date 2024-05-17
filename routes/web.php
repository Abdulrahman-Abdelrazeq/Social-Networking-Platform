<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ConnectionController;
use Illuminate\Support\Facades\Route;



// ->middleware(['auth', 'verified'])->name('home');

Route::get('/users/search', [UserController::class, 'search'])->name('users.search');
Route::middleware('auth')->group(function () {

    Route::resource('/users', UserController::class)->names('user');


    Route::get('/', [PostController::class, 'index'])->name('home');
    Route::resource('/posts', PostController::class)->names('post');

    Route::get('/posts/{post}/liked-users', [LikeController::class, 'likedUsers'])->name('posts.liked_users');
    Route::post('/posts/{post}/like', [LikeController::class, 'like'])->name('posts.like');

    Route::resource('/comments', CommentController::class)->names('comment');
    Route::get('/posts/{postId}/comments', [CommentController::class, 'index'])->name('comments.index');

    Route::resource('/connections', ConnectionController::class)->names('connection');
    Route::get('/connections/{connection}/requests', [ConnectionController::class, 'index'])->name('connection.requests');

    
    Route::get('/myprofile', [PostController::class, 'user_posts'])->name('profile.show');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
