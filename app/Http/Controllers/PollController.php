<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Option;
use App\Models\Poll;
use App\Models\Vote;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PollController extends Controller
{
    public function index() {
        return view('create-poll');
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|in:kecelakaan,kesehatan,cuaca,bisnis,acara,lain-lain',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('picture')) {
            $fileName = time() . '.' . $request->picture->getClientOriginalExtension();
            $request->picture->move(public_path('uploads'), $fileName);
            $imagePath = 'uploads/' . $fileName;
            $validatedData['picture'] = 'uploads/' . $fileName;
        } else {
            $imagePath = null;
        }

        $poll = new Poll;
        $poll->user_id = auth()->id();
        $poll->title = $request->input('title');
        $poll->description = $request->input('description');
        $poll->category = $request->input('category');
        $poll->picture = $imagePath;
        $poll->date_made = Carbon::now();
        $poll->save();

        foreach ($request->options as $optionText) {
            $option = new Option;
            $option->text = $optionText;
            $poll->options()->save($option);
        }

        return redirect('/feed')->with('success', 'Poll berhasil dibuat.');
    }

    public function vote(Request $request, $pollId) {
        $request->validate([
            'option_id' => 'required|exists:options,id'
        ]);

        $userId = Auth::id();

        $hasVoted = Vote::whereHas('option', function($query) use ($pollId) {
            $query->where('poll_id', $pollId);
        })->where('user_id', $userId)->exists();

        if ($hasVoted) {
            $userVote = Vote::where('user_id', $userId)->whereHas('option', function($query) use ($pollId) {
                $query->where('poll_id', $pollId);
            })->first();

            $userVote->update([
                'option_id' => $request->input('option_id'),
                'count' => 1
            ]);

            return redirect()->back()->with('success', 'Your vote has been updated.');
        }

        Vote::create([
            'option_id' => $request->input('option_id'),
            'user_id' => $userId,
            'count' => 1
        ]);

        return redirect()->back()->with('success', 'Berhasil memilih');
    }

    public function findById($id) {
        $poll = Poll::findOrFail($id);

        return view('update-poll', compact('poll'));
    }

    public function update(Request $request, $pollId)
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

        return redirect('/profile')->with('success', 'Poll berhasil diperbarui.');
    }

}
