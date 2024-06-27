<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use Carbon\Carbon;

class NewsController extends Controller
{
    public function index() {
        return view('create-news');
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

        $news = new News;
        $news->user_id = auth()->id();
        $news->title = $request->input('title');
        $news->description = $request->input('description');
        $news->category = $request->input('category');
        $news->picture = $imagePath;
        $news->date_made = Carbon::now();
        $news->save();

        return redirect('/feed')->with('success', 'Berita berhasil dibuat.');
    }


    public function findById($id) {
        $news = News::findOrFail($id);

        return view('update-news', compact('news'));
    }

    public function update(Request $request, $newsId)
    {
        $news = News::findOrFail($newsId);

        $validatedData = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
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

        return redirect('/profile')->with('success', 'Berita berhasil diperbarui.');
    }
}
