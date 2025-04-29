<?php

namespace App\Http\Controllers;

use App\Models\Filiers;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ScheduleController extends Controller
{

    public function filiers()
    {
        $filiers = Filiers::all();
        return response()->json([
            'filiers' => $filiers
        ], 200);
    }
    public function index()
    {
        $schedules = Schedule::with('filiers')->get();
        return response()->json([
            'schedules' => $schedules
        ], 200);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'filiers_id' => 'required|exists:filiers,id',
                'schedule_pdf' => 'required|file|mimes:pdf|max:10240'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors(),
                'success' => false
            ], 200);
        }

        if ($request->hasFile('schedule_pdf')) {
            $path = $request->file('schedule_pdf')->store('Schedules', 'public');
            $data['schedule_pdf'] = $path;
        }

        
        $schedule = Schedule::create($data);
        $schedule->load('filiers');

        return response()->json([
            'schedule' => $schedule,
            'success' => true
        ], 201);
    }

    public function destroy($id)
    {
        $schedule = Schedule::find($id);

        if (!$schedule) {
            return response()->json([
                'success' => false,
                'message' => 'Schedule not found.'
            ], 404);
        }

        // Optionally delete the file from storage
        if (Storage::disk('public')->exists($schedule->schedule_pdf)) {
            Storage::disk('public')->delete($schedule->schedule_pdf);
        }

        $schedule->delete();

        return response()->json([
            'success' => true,
            'message' => 'Schedule deleted successfully.',
            'schedule' => $schedule
        ], 200);
    }
}
