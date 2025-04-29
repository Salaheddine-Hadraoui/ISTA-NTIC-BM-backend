<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\ScheduleController;
use App\Models\Filiers;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsAdmin;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
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
    //-------------------------------------------------------------------------------------------------------------------------------------

});

Route::get('/course-pdf/{filename}', function (Request $request, $filename) {
    $path = 'Courses/' . $filename;

    if (!Storage::disk('public')->exists($path)) {
        abort(404);
    }

    $file = Storage::disk('public')->get($path);

    return Response::make($file, 200, [
        'Content-Type' => 'application/pdf',
    ]);
});


//--------------- for admin --------------------------------------------------------------------------------------------
Route::middleware(['auth:sanctum', IsAdmin::class])->group(
    function () {
        Route::get('/dashboard-data',action: function(){
                $nb_user = User::where('role','user')->count();
                $todayEvents = Event::whereDate('date', '2025-04-30')->get();
                return response()->json([
                    'totalUsers'=>$nb_user,
                    'events' => $todayEvents,
                ]);
        });

        //----------------------------------------Events------------------------------------------------------------------
        Route::post('adminOnly/addnewEvent', [EventsController::class, 'store']);
        Route::post('adminOnly/updateEvent/{id}', [EventsController::class, 'update']);
        Route::delete('adminOnly/deleteEvent/{event}', [EventsController::class, 'destroy']);
        //----------------------------------------Courses------------------------------------------------------------------
        Route::get('adminOnly/getmodules', [CourseController::class, 'modules']);
        Route::post('adminOnly/addNewcourses', [CourseController::class, 'store']);
        Route::delete('adminOnly/deleteCours/{course}', [CourseController::class, 'destroy']);
        //----------------------------------------Schedule------------------------------------------------------------------
        Route::post('adminOnly/addNewSchedule', [ScheduleController::class, 'store']);
        Route::delete('adminOnly/deleteSchedule/{schedule}', [ScheduleController::class, 'destroy']);
    }
);


Route::get('adminOnly/getfiliers', [ScheduleController::class, 'filiers']);



//---Events route-------------------------
Route::get('getevents', [EventsController::class, 'index']);

Route::get('getevents/latest', [EventsController::class, 'index_latest']);

Route::get('getevents/{eventName}', [EventsController::class, 'show']);


//---Courses route-----------------------------------------------------------------------------
Route::get('getcourses', [CourseController::class, 'index']);
//---Schedule route-----------------------------------------------------------------------------
Route::get('getfiliers', [ScheduleController::class, 'filiers']);
Route::get('getschedules', [ScheduleController::class, 'index']);







//--------------------------------------------------------------------------------------

Route::get('getFilieres ', function () {
    $filiers = Filiers::all();
    return response()->json(
        ['filiers' => $filiers]
    );
});
