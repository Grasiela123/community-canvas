<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class EventController extends Controller
{
    public function viewCalendar() {
        return view('calendar');
    }

    public function viewCreateEvent() {
        return view('create-event');
    }

    public function getEventsByDate(Request $request){
        $userAddress = Auth::user()->address;

        $selectedDate = Carbon::parse($request->input('date'))->toDateString();

        $events = Event::where('date_made', $selectedDate)
                       ->whereHas('user', function ($query) use ($userAddress) {
                           $query->where('address', $userAddress);
                       })->get();

        return response()->json($events);
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date_made' => 'required|date',
        ]);

        if ($request->hasFile('picture')) {
            $fileName = time() . '.' . $request->picture->getClientOriginalExtension();
            $request->picture->move(public_path('uploads'), $fileName);
            $imagePath = 'uploads/' . $fileName;
            $validatedData['picture'] = 'uploads/' . $fileName;
        } else {
            $imagePath = null;
        }

        $event = Event::create([
            'user_id' => Auth::id(),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'picture' => $imagePath,
            'date_made' => $request->input('date_made'),
        ]);

        return redirect('/calendar')->with('success', 'Acara berhasil dibuat.');
    }

    public function findById($id) {
        $event = Event::findOrFail($id);

        return view('update-event', compact('event'));
    }

    public function update(Request $request, $eventId) {
        $event = Event::findOrFail($eventId);

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'date_made' => 'required|date',
        ]);

        $event->title = $validatedData['title'];
        $event->description = $validatedData['description'];
        $event->date_made = $validatedData['date_made'];

        if ($request->hasFile('picture')) {
            if ($event->picture && file_exists(public_path($event->picture))) {
                unlink(public_path($event->picture));
            }

            $fileName = time() . '.' . $request->picture->getClientOriginalExtension();
            $request->picture->move(public_path('uploads'), $fileName);
            $imagePath = 'uploads/' . $fileName;
            $validatedData['picture'] = 'uploads/' . $fileName;
            $event->picture = $imagePath;
        }

        $event->save();

        return redirect('/profile')->with('success', 'Acara berhasil diperbarui.');
    }
}


