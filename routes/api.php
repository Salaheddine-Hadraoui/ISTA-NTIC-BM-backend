<?php

use App\Http\Controllers\EventsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\AuthSocialiteController;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;





Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        $user = $request->user();
        $token = PersonalAccessToken::where('tokenable_id',$user->id)
        ->orderBy('created_at', 'desc')
            ->first();
        return $user 
            ? response()->json(['user' => $user,'token' => $token->id.'|'.$token->token.'testhere------'], 200)
            : response()->json(['error' => 'Your session has expired. Please log in again'], 401);
    });
    
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::post('/login', [AuthController::class, 'Login']);
Route::post('/register', [AuthController::class, 'Register']);

//---Event route-------------------------
Route::get('getevents',[EventsController::class,'index']);

