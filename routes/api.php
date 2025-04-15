<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\AuthSocialiteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user/social', function (){
    $user = Auth::user();
    if(!$user){
        return response()->json(
            [
                'error'=>'Your session has expired. Please log in again'
            ]
        ,401);
    }
    return response()->json(
        [
            'user'=>Auth::user()
        ]
        ,200);

});
Route::middleware(['auth:sanctum'])->post('/user', [AuthController::class,'login']);


