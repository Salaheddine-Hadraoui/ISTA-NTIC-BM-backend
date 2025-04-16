<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AuthController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user/social', function () {
        $user = Auth::user();

        return $user 
            ? response()->json(['user' => $user], 200)
            : response()->json(['error' => 'Your session has expired. Please log in again'], 401);
    });
});

Route::post('/user', [AuthController::class, 'login']);
