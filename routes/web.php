<?php

use App\Http\Controllers\Auth\AuthSocialiteController;
use Illuminate\Support\Facades\Route;



Route::prefix('auth')->group(function () {
    Route::get('{provider}/redirect', [AuthSocialiteController::class, 'redirectToSOcilaProvider']);
    Route::get('{provider}/callback', [AuthSocialiteController::class, 'callbackToSocialProvider']);
    
});
Route::get('/proxy-avatar/{url}', function ($url) {
    $useUrl = 'https://'.$url;
    return response()->stream(function () use ($useUrl) {
        echo file_get_contents($useUrl);
    }, 200, ['Content-Type' => 'image/jpeg']);
});

require __DIR__.'/auth.php';
