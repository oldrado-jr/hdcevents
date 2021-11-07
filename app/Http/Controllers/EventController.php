<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search');

        if ($search) {
            $events = Event::where([
                ['title', 'like', "%${search}%"]
            ])->get();
        } else {
            $events = Event::all();
        }


        return view('welcome', ['events' => $events, 'search' => $search]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $event = new Event();
        $this->setData($request, $event);

        $user = auth()->user();
        $event->user_id = $user->id;

        $event->save();

        return redirect()->route('event.index')->with('msg', 'Evento criado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        $user = auth()->user();
        $hasUserJoined = false;

        if ($user instanceof User) {
            $hasUserJoined = $user->eventsAsParticipant()->allRelatedIds()->contains($event->id);
        }

        return view('events.show', [
            'event'         => $event,
            'eventOwner'    => User::where('id', $event->user_id)->first(),
            'hasUserJoined' => $hasUserJoined
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        $user = auth()->user();

        if ($user->id != $event->user_id) {
            return redirect()->route('dashboard');
        }

        return view('events.edit', ['event' => $event]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        $this->setData($request, $event);
        $event->update();

        return redirect()->route('dashboard')->with('msg', 'Evento editado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('dashboard')->with('msg', 'Evento excluído com sucesso!');
    }

    /**
     * Show the dashboard for displaying all user events.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $user = auth()->user();
        return view('events.dashboard', [
            'events' => $user->events, 'eventsAsParticipant' => $user->eventsAsParticipant
        ]);
    }

    /**
     * Join an user to an event.
     *
     * @param \App\Models\Event $event
     * @return \Illuminate\Http\Response
     */
    public function joinEvent(Event $event)
    {
        /** @var User $user */
        $user = auth()->user();
        $user->eventsAsParticipant()->attach($event->id);
        return redirect()->route('dashboard')->with(
            'msg',
            'Sua presença está confirmada no evento ' . $event->title
        );
    }

    /**
     * Let an user leaves the event.
     *
     * @param \App\Models\Event $event
     * @return \Illuminate\Http\Response
     */
    public function leaveEvent(Event $event)
    {
        /** @var User $user */
        $user = auth()->user();
        $user->eventsAsParticipant()->detach($event->id);
        return redirect()->route('dashboard')->with(
            'msg',
            'Você saiu com sucesso do evento ' . $event->title
        );
    }

    /**
     * Upload image file and save into filesystem.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Event $event
     * @return void
     */
    private function uploadImage(Request $request, Event $event)
    {
        if (!$request->hasFile('image') || !$request->file('image')->isValid()) {
            return;
        }

        $requestImage = $request->image;
        $originalImageName = $requestImage->getClientOriginalName();
        $extension = $requestImage->extension();
        // Makes image name.
        $imageName = md5(time() . $originalImageName) . ".${extension}";

        $requestImage->move(public_path('img/events'), $imageName);

        // Set image name in the object.
        $event->image = $imageName;
    }

    /**
     * Set request data to the object.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Event $event
     * @return void
     */
    private function setData(Request $request, Event $event)
    {
        $event->title = $request->title;
        $event->city = $request->city;
        $event->date = $request->date;
        $event->private = $request->boolean('private', $request->private);
        $event->description = $request->description;

        if (!$request->isNotFilled('items')) {
            $event->items = $request->items;
        }

        $this->uploadImage($request, $event);
    }
}
