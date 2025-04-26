<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CourseController;
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
    Route::get('/restoreME', function (Request $request) {
        $user = $request->user();
        return response()->json([
            'message' => 'Connexion réussie.',
            'user'    => $user,
            'role' => $user->role,
        ], 200);
    });
    Route::get('/user', function (Request $request) {
        $user = $request->user();
        $token = PersonalAccessToken::where('tokenable_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->first();
        return $user
            ? response()->json(['user' => $user, 'token' => $token->id . '|' . $token->token], 200)
            : response()->json(['error' => 'Your session has expired. Please log in again'], 401);
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});



//--------------- for admin --------------------------------------------------------------------------------------------
Route::middleware(['auth:sanctum', IsAdmin::class])->group(
    function () {
    //----------------------------------------Events------------------------------------------------------------------
        Route::post('adminOnly/addnewEvent', [EventsController::class, 'store']);
        Route::post('adminOnly/updateEvent/{id}', [EventsController::class, 'update']);
        Route::delete('adminOnly/deleteEvent/{event}', [EventsController::class, 'destroy']);
    //----------------------------------------Courses------------------------------------------------------------------
        Route::get('adminOnly/getmodules',[CourseController::class,'modules']);
        Route::post('adminOnly/addNewcourses', [CourseController::class, 'store']);
        Route::post('adminOnly/updateCours/{id}', [CourseController::class, 'update']);
        Route::delete('adminOnly/addNewcourses/{course}', [CourseController::class, 'destroy']);
    }
);




//---Event route-------------------------
Route::get('getevents', [EventsController::class, 'index']);

//Route::get('getevents/latest', [EventsController::class, 'index_latest']);

Route::get('getevents/{eventName}', [EventsController::class, 'show']);


//---Event route-----------------------------------------------------------------------------
Route::get('getcourses', [CourseController::class, 'index']);







//--------------------------------------------------------------------------------------

Route::get('getFilieres ', function () {
    $filiers = Filiers::all();
    return response()->json(
        ['filiers' => $filiers]
    );
});
