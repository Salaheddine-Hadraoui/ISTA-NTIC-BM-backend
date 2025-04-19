<?php

use App\Http\Controllers\Auth\AuthSocialiteController;
use Illuminate\Support\Facades\Route;



Route::prefix('auth')->group(function () {
    Route::get('{provider}/redirect', [AuthSocialiteController::class, 'redirectToSOcilaProvider']);
    
    Route::get('{provider}/callback', [AuthSocialiteController::class, 'callbackToSocialProvider']);
    
});

require __DIR__.'/auth.php';
