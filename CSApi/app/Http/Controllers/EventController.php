<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function readAll()
    {
        $events = Event::with(['organizer', 'participants'])->get();
        return response()->json($events);
    }

    public function createOne(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string',
            'date' => 'required|date',
            'max_participants' => 'required|integer|min:1',
        ]);

        $event = Event::create([
            ...$validated,
            'organizer_id' => Auth::id(),
            'status' => 'active',
        ]);

        return response()->json($event, 201);
    }

    public function readOne(Event $event)
    {
        return response()->json($event->load(['organizer', 'participants']));
    }

    public function updateOne(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'location' => 'sometimes|string',
            'date' => 'sometimes|date',
            'max_participants' => 'sometimes|integer|min:1',
            'status' => 'sometimes|in:active,cancelled,completed',
        ]);

        $event->update($validated);
        return response()->json($event);
    }

    public function deleteOne(Event $event)
    {
        $event->delete();
        return response()->json(null, 204);
    }

    public function join(Event $event)
    {
        if ($event->participants()->count() >= $event->max_participants) {
            return response()->json(['message' => 'Event is full'], 400);
        }

        $event->participants()->attach(Auth::id());
        return response()->json(['message' => 'Successfully joined the event']);
    }

    public function leave(Event $event)
    {
        $event->participants()->detach(Auth::id());
        return response()->json(['message' => 'Successfully left the event']);
    }
}