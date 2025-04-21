<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\EventsController;
use App\Models\Filiers;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsAdmin;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;



//----------------------------------------------------------------------------------------------------------------------

Route::post('/login', [AuthController::class, 'Login']);
Route::post('/register', [AuthController::class, 'Register']);

//----------------------------------------------------------------------------------------------------------------------

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        $user = $request->user();
        $token = PersonalAccessToken::where('tokenable_id',$user->id)
        ->orderBy('created_at', 'desc')
            ->first();
        return $user 
            ? response()->json(['user' => $user,'token' => $token->id.'|'.$token->token], 200)
            : response()->json(['error' => 'Your session has expired. Please log in again'], 401);
    });
    
    Route::post('/logout', [AuthController::class, 'logout']);
});



//--------------- for admin --------------------------------------------------------------------------------------------
Route::middleware(['auth:sanctum',IsAdmin::class])->group(
    function(){
        Route::post('adminOnly/addnewEvent',[EventsController::class,'store']);
        Route::delete('adminOnly/deleteEvent',[EventsController::class,'destroy']);
    }
);







//---Event route-------------------------
Route::get('getevents',[EventsController::class,'index']);

Route::get('getevents/latest',[EventsController::class,'index_latest']);

Route::get('getevents/{eventName}',[EventsController::class,'show']);
//--------------------------------------------------------------------------------------

Route::get('getFilieres ',function(){
    $filiers = Filiers::all();
    return response()->json(
        ['filiers'=>$filiers]
    );
});

