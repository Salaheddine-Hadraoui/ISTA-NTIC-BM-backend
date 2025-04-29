<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::all()->map(function ($event) {
            $event['formated_date'] = Carbon::parse($event->date)->translatedFormat('l d F Y');
            return $event;
        });
        return response()->json([
            'events' => $events
        ], 200);
    }
    public function index_latest()
    {
        $events = Event::all()->where('date','=',now());
        return response()->json([
            'latestevents' => $events
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
            $data = $request->validate([
                'title' => 'required|string|max:255',
                'date' => 'required|date',
                'time' =>      'required|date_format:H:i',
                'location' => 'required|string|max:255',
                'description' => 'required|string|max:4000',
                'details' => 'required|string|max:4000',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',

            ]);
        } catch (ValidationException $eror) {
            return response()->json([
                'success' => false,
                'errors' => $eror->errors()
            ], status: 200);
        }
        if ($request->hasFile('image')) {

            $path =  $request->file('image')->store('Events', 'public');
            // n7too l path dial image f image column f events table
            $data['image'] = $path;
        };

        $event = Event::create($data);

        $event->refresh();

        $event['formated_date'] = Carbon::parse($event->date)->translatedFormat('l d F Y');

        $event->time = Carbon::parse($event->time)->translatedFormat('H:i');
        return response()->json(
            [
                'success' => true,
                'event' => $event
            ],
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $eventName)
    {
        $event = Event::find($eventName->id);
        if (!$event) {
            return response()->json([
                'success' => false,
                'message' => 'Événement introuvable.'
            ], 404);
        }

        $event['formated_date'] = Carbon::parse($event->date)->translatedFormat('l d F Y');

        $event->time = Carbon::parse($event->time)->translatedFormat('H:i');
        return response()->json(
            [
                'success' => true,
                'event' => $event
            ],
            201
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $event = Event::find($id);

        if (!$event) {
            return response()->json([
                'success' => false,
                'message' => 'Événement introuvable.'
            ], 404);
        }

        try {
            $data = $request->validate([
                'title' => 'required|string|max:255',
                'date' => 'required|date',
                'time' => 'required|date_format:H:i',
                'location' => 'required|string|max:255',
                'description' => 'nullable|string|max:1000',
                'details' => 'nullable|string|max:1000',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
            ]);
        } catch (ValidationException $error) {
            return response()->json([

                'request' => $request->all(),
                'success' => false,
                'errors' => $error->errors()
            ], 422);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            if($event->image){
                Storage::disk('public')->delete($event->image);
            }
            $path = $request->file('image')->store('Events', 'public');
            $data['image'] = $path;
        } else {
            $data['image'] = $event->image; // keep existing image
        }

        $event->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Événement mis à jour avec succès.',
            'event' => $event
        ], 200);
    }

    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $event = Event::find($id);

        if (!$event) {
            return response()->json([
                'success' => false,
                'message' => 'Événement introuvable.'
            ], 404);
        }

        $event->delete();

        return response()->json([
            'success' => true,
            'event' => $event,
            'message' => 'Événement supprimé avec succès.'
        ], 200);
    }
}
