<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('posts', \App\Http\Controllers\PostController::class);
Route::post('posts/{id}/comments', [\App\Http\Controllers\CommentController::class, 'store']);
Route::delete('/comments/{commentId}', [\App\Http\Controllers\CommentController::class, 'delete']);
Route::get('get-post?search={keyword}', [\App\Http\Controllers\PostController::class, 'search']);
