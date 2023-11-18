<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class NewsController extends Controller
{
    public function index(Request $request)
    {

        $validated = $request->validate([
            "limit" => ["nullable", "integer", "min:1", "max:100"],
            "page" => ["nullable", "integer", "min:1"],
        ]);
        
        $limit = $validated['limit']?? 12;

        $newsList = News::query()->latest('published_at')->paginate($limit);

        return Inertia::render('News/Index', compact('newsList'));
    }

    public function create()
    {
        return Inertia::render('News/Create');
    }

    public function store(Request $request)
    {   
        $validated = $request->validate(News::getRules());
        
        $newsOnce = News::query()->firstOrCreate([
            'user_id' => User::query()->value('id'),
            'title' => $validated['title'],
        ], [
            'content' => $validated['content'],
            'published_at' => new Carbon($validated['published_at'] ?? null),
            'filename' => $validated['filename']?? null,
            'filepath' => $validated['filepath']?? null,
            'likes' => $validated['likes']?? 0,
        ]);

        // alert(__('Сохранено!'));

        return Redirect::route('news.show', $newsOnce->id);

    }

    public function show(Request $request, $news)
    {

        $newsOnce = News::query()->findOrFail($news, ['id', 'title', 'content', 'published_at', 'filename', 'filepath', 'likes']);

        return Inertia::render('News/Show', compact('newsOnce'));
    }

    public function edit(Request $request, $news)
    {

        $newsOnce = News::query()->findOrFail($news, ['id', 'title', 'content', 'published_at', "published", 'filename', 'filepath', 'likes']);

        return Inertia::render('News/Edit', compact('newsOnce'));
    }

    public function update(Request $request, $news)
    {
        $validated = $request->validate([
            ... News::getRules()
        ]);

        News::query()->where('id', $news)->update($validated);

        // alert(__('Сохранено!'));

        return Redirect::route('news.show', $news);
    }

    public function delete($news)
    {
        return Redirect::route('news');
    }

    public function like($news)
    {
        return News::query()->where('id', $news)->increment('like');
    }
}
