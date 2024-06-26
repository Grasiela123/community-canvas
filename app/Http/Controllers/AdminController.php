<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\News;
use App\Models\Poll;
use App\Models\Event;
use App\Models\Option;
use App\Models\User;

class AdminController extends Controller
{
    public function index() {
        $currentUser = Auth::user();
        $users = User::where('id', '!=', $currentUser->id)->orderByDesc('created_at')->paginate(5);
        $newsItems = News::where('user_id', '!=', $currentUser->id)->orderByDesc('created_at')->paginate(5);
        $polls = Poll::where('user_id', '!=', $currentUser->id)
                    ->with(['options' => function ($query) {
                         $query->withCount('votes');
                     }])
                     ->orderByDesc('created_at')
                     ->paginate(5);
        $events = Event::where('user_id', '!=', $currentUser->id)->orderByDesc('created_at')->paginate(5);

        return view('admin', [
            'currentUser' => $currentUser,
            'users' => $users,
            'newsItems' => $newsItems,
            'polls' => $polls,
            'events' => $events,
        ]);
    }

    public function delete($type, $id) {
        switch ($type) {
            case 'user':
                $item = User::find($id);
                break;
            case 'news':
                $item = News::find($id);
                break;
            case 'event':
                $item = Event::find($id);
                break;
            case 'poll':
                $item = Poll::find($id);
                break;
            default:
                return back()->with('error', 'Data tidak ditemukan.');
        }

        if (!$item) {
            return back()->with('error', 'Data tidak ditemukan.');
        }

        $item->delete();

        switch ($type) {
            case 'user':
                return redirect()->back()->with('success', 'Pengguna berhasil dihapus.');
                break;
            case 'news':
                return redirect()->back()->with('success', 'Berita berhasil dihapus.');
                break;
            case 'event':
                return redirect()->back()->with('success', 'Acara berhasil dihapus.');
                break;
            case 'poll':
                return redirect()->back()->with('success', 'Poll berhasil dihapus.');
                break;
            default:
                return back()->with('error', 'Tidak berhasil dihapus');
        }
    }

    public function update(Request $request, $id) {
        $user = User::findOrFail($id);
    
        $validatedData = $request->validate([
            'username'=> 'required|min:3',
            'email' => 'required|email',
            'password' => 'nullable|min:6',
            'address' => 'required',
            'role' => 'required',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validatedData['username'] !== $user->username) {
            $request->validate([
                'username' => 'unique:users,username',
            ]);
        }

        if ($validatedData['email'] !== $user->email) {
            $request->validate([
                'email' => 'unique:users,email',
            ]);
        }
    
        if ($request->hasFile('picture')) {
            $fileName = time() . '.' . $request->picture->getClientOriginalExtension();
            $request->picture->move(public_path('uploads'), $fileName);
            $validatedData['picture'] = 'uploads/' . $fileName;
    
            if ($user->picture && file_exists(public_path($user->picture))) {
                unlink(public_path($user->picture));
            }
        }
    
        if (isset($validatedData['password'])) {
            $user->password = bcrypt($validatedData['password']);
        }
    
        $user->username = $validatedData['username'];
		$user->email = $validatedData['email'];
        $user->address = $validatedData['address'];
        $user->picture = $validatedData['picture'] ?? $user->picture;
    
        $user->save();
    
        return redirect('/admin')->with('success', 'User berhasil diperbarui.');
    }

    public function getUserById($id)
    {
        $user = User::findOrFail($id);
        return view('update-user', compact('user'));
    }

    public function getNewsById($id) {
        $news = News::findOrFail($id);

        return view('update-news-admin', compact('news'));
    }

    public function updateNews(Request $request, $newsId)
    {
        $news = News::findOrFail($newsId);

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|in:kecelakaan,kesehatan,cuaca,acara,bisnis,lain-lain',
            'picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $news->title = $validatedData['title'];
        $news->description = $validatedData['description'];
        $news->category = $validatedData['category'];

        if ($request->hasFile('picture')) {
            if ($news->picture && file_exists(public_path($news->picture))) {
                unlink(public_path($news->picture));
            }

            $fileName = time() . '.' . $request->picture->getClientOriginalExtension();
            $request->picture->move(public_path('uploads'), $fileName);
            $imagePath = 'uploads/' . $fileName;
            $validatedData['picture'] = 'uploads/' . $fileName;
            $news->picture = $imagePath;
        }

        $news->save();

        return redirect('/admin')->with('success', 'Berita berhasil diperbarui.');
    }

    public function getPollById($id) {
        $poll = Poll::findOrFail($id);

        return view('update-poll-admin', compact('poll'));
    }

    public function updatePoll(Request $request, $pollId)
    {
        $poll = Poll::findOrFail($pollId);

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|in:kecelakaan,kesehatan,cuaca,acara,bisnis,lain-lain',
            'picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $poll->title = $validatedData['title'];
        $poll->description = $validatedData['description'];
        $poll->category = $validatedData['category'];

        if ($request->hasFile('picture')) {
            if ($poll->picture && file_exists(public_path($poll->picture))) {
                unlink(public_path($poll->picture));
            }

            $fileName = time() . '.' . $request->picture->getClientOriginalExtension();
            $request->picture->move(public_path('uploads'), $fileName);
            $imagePath = 'uploads/' . $fileName;
            $validatedData['picture'] = 'uploads/' . $fileName;
            $poll->picture = $imagePath;
        }

        $poll->options()->delete();
        foreach ($request->options as $optionText) {
            $option = new Option;
            $option->text = $optionText;
            $poll->options()->save($option);
        }

        $poll->save();

        return redirect('/admin')->with('success', 'Poll berhasil diperbarui.');
    }

    public function getEventById($id) {
        $event = Event::findOrFail($id);

        return view('update-event-admin', compact('event'));
    }

    public function updateEvent(Request $request, $eventId) {
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

        return redirect('/admin')->with('success', 'Acara berhasil diperbarui.');
    }
}
