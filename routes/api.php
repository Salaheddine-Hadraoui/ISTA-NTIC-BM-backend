<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AuthController;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

Route::middleware([EnsureFrontendRequestsAreStateful::class, 'auth:sanctum'])->group(function () {
    Route::get('/user/social', function () {
        $user = Auth::user();

        return $user 
            ? response()->json(['user' => $user], 200)
            : response()->json(['error' => 'Your session has expired. Please log in again'], 401);
    });
    
});
Route::middleware(['web'])->post('/logout', [AuthController::class, 'logout']);

Route::post('/login', [AuthController::class, 'Login']);
Route::post('/register', [AuthController::class, 'Register']);

