<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Event\StoreRequest;
use App\Http\Requests\Event\UpdateRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Response;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return EventResource::collection(Event::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $created_event = Event::create($request->validated());

        $responce = [
            'error'     => null,
            'result'    => new EventResource($created_event),
        ];

        return response($responce, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new EventResource(Event::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $user = User::findOrFail($request->user_id);

        $event = Event::findOrFail($id);
        $event = new EventResource(Event::findOrFail($id));

        $event->users()->attach($user);

        return new EventResource(Event::findOrFail($id));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Event::find($id)->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function deleteUser(UpdateRequest $request, string $id)
    {
        $event = Event::findOrFail($id);
        $event = new EventResource(Event::findOrFail($id));

        $event->users()->detach($request->user_id);

        return new EventResource(Event::findOrFail($id));
    }
}
