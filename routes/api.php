<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ConnectionController;
use Illuminate\Support\Facades\Route;

use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;


Route::middleware('auth:sanctum')->group(function () {
    
    // routes/api.php
    
    Route::get('/users/search', [UserController::class, 'search'])->name('users.search');
    Route::apiResource('users', UserController::class);
    Route::apiResource('posts', PostController::class);
    Route::apiResource('comments', CommentController::class);
    Route::apiResource('likes', LikeController::class);
    Route::apiResource('connections', ConnectionController::class);

});

require __DIR__.'/auth.php';
