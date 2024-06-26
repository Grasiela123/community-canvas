<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\News;
use App\Models\Poll;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class FeedController extends Controller
{
    public function getFeed(Request $request) {
        $currentUserAddress = Auth::user()->address;

        $newsQuery = News::with('user')->whereHas('user', function ($query) use ($currentUserAddress) {
            $query->where('address', $currentUserAddress);
        });

        $pollQuery = Poll::with('user')->whereHas('user', function ($query) use ($currentUserAddress) {
            $query->where('address', $currentUserAddress);
        });

        if ($request->filled('date')) {
            $newsQuery->whereDate('date_made', $request->date);
            $pollQuery->whereDate('date_made', $request->date);
        }

        if ($request->filled('category')) {
            $newsQuery->where('category', $request->category);
        }

        if ($request->filled('feed_type')) {
            if ($request->feed_type == 'news') {
                $paginatedFeeds = $newsQuery->orderBy('created_at', 'desc')->paginate(5);
                return view('feed', compact('paginatedFeeds'));
            } elseif ($request->feed_type == 'polls') {
                $paginatedFeeds = $pollQuery->orderBy('created_at', 'desc')->paginate(5);
                return view('feed', compact('paginatedFeeds'));
            }
        }

        $news = $newsQuery->orderBy('created_at', 'desc')->get();
        $polls = $pollQuery->orderBy('created_at', 'desc')->get();

        $feeds = $news->concat($polls)->sortByDesc('created_at');

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 5;
        $currentItems = $feeds->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $paginatedFeeds = new LengthAwarePaginator($currentItems, $feeds->count(), $perPage, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
            'pageName' => 'page',
        ]);

        return view('feed', compact('paginatedFeeds'));
    }
}
