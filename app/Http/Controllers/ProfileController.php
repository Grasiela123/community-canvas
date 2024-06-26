<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\News;
use App\Models\Poll;
use App\Models\Event;
use App\Models\Option;

class ProfileController extends Controller
{
    public function index() {
        $user = Auth::user();
        $newsItems = News::where('user_id', $user->id)->orderByDesc('created_at')->get();
        $polls = Poll::where('user_id', $user->id)
                     ->with(['options' => function ($query) {
                         $query->withCount('votes');
                     }])
                     ->orderByDesc('created_at')
                     ->get();
        $events = Event::where('user_id', $user->id)->orderByDesc('created_at')->get();


        return view('profile', [
            'user' => $user,
            'newsItems' => $newsItems,
            'polls' => $polls,
            'events' => $events,
        ]);
    }

    public function delete($type, $id) {
        switch ($type) {
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
}
