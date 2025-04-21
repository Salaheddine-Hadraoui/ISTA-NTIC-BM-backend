<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::all()->map(function ($event) {
            $event->date = Carbon::parse($event->date)->translatedFormat('l d F Y');
            return $event;
        });
        return response()->json([
            'events' => $events
        ],200);
    }
    public function index_latest()
    {
        $events = Event::all()->where('');
        return response()->json([
            'latestevents' => $events
        ],200);
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
        $user= $request->user();
        if(!$user && $user->role !== 'admin'){
                return response()->json([
                    'error' => 'Accès refuse. Reserve aux administrateurs.'],  403
                );
        };
       try {
        $data = $request->validate([
            'title' => 'required|string|max:255',  
            'date' => 'required|date',  
             'time' =>      'required|date_format:H:i',  
                'location' => 'required|string|max:255',  
               'description' => 'nullable|string|max:1000',  
               'details' => 'nullable|string|max:1000',  
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:1048',  
    
        ]);
       } 
       catch(ValidationException $eror){
        return response()->json([
            'success' => false,
            'errors' => $eror->errors()
        ] ,201);
       }
        if($request->hasFile('image')){

            $path =  $request->file('image')->store('Events','public');
                    // n7too l path dial image f image column f events table
            $data['image'] = $path;
        };

        $event = Event::create($data);

        $event->refresh();

        $event->date = Carbon::parse($event->date)->translatedFormat('l d F Y');

        $event->time = Carbon::parse($event->time)->translatedFormat('H:i');
        return response()->json([
            'success' => true,
            'event' => $event
        ] ,201
        );

    }

    /**
     * Display the specified resource.
     */
    public function show(Event $eventName)
    {
        $event = Event::find($eventName->id);

        $event->date = Carbon::parse($event->date)->translatedFormat('l d F Y');

        $event->time = Carbon::parse($event->time)->translatedFormat('H:i');     
           return response()->json([
            'success' => true,
            'event' => $event
        ] ,201
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
