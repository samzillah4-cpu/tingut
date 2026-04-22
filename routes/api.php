<?php

use App\Http\Controllers\ChatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(['web'])->group(function () {
    Route::apiResource('chats', ChatController::class);
    Route::get('chats/{chat}/messages', [ChatController::class, 'getMessages'])->name('chats.messages');
    Route::post('chats/{chat}/typing', [ChatController::class, 'setTyping'])->name('chats.typing');
    Route::get('chats/{chat}/typing', [ChatController::class, 'getTyping'])->name('chats.typing.get');
    Route::post('chats/{chat}/upload', [ChatController::class, 'uploadFile'])->name('chats.upload');
});
