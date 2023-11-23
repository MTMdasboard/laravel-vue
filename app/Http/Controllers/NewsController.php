<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

// for ($i=0; $i < 12; $i++) { 
//     News::create([
//         'user_id' => 1,
//         'title' => fake()->sentence(2),
//         'content' => fake()->text,
//         'published_at' => new Carbon( fake()->date ),
//         'views' => 0,
//         'likes' => 0,
//     ]);
// }

class NewsController extends Controller
{
    public function index(Request $request)
    {

        $validated = $request->validate([
            "limit" => ["nullable", "integer", "min:1", "max:100"],
            "page" => ["nullable", "integer", "min:1"],
        ]);

        $limit = $validated['limit'] ?? 9;

        $newsList = News::query()->latest('published_at')->paginate($limit);

        return Inertia::render('news/index', compact('newsList'));
    }

    public function create()
    {
        $userList = User::all(['id', 'name']);

        return Inertia::render('news/create', compact('userList'));

    }

    public function store(Request $request)
    {
        $validated = $request->validate(News::getRules());

        $newsOnce = News::query()->firstOrCreate([
            'user_id' => $validated['user_id'],
            'title' => $validated['title'],
        ], [
            'content' => $validated['content'],
            'published_at' => new Carbon($validated['published_at'] ?? null),
            'base64image' => $validated['base64image'] ?? null,
        ]);

        return Redirect::route('news.show', $newsOnce->id);

    }

    public function show(Request $request, $news)
    {

        $newsOnce = News::query()->with('comments')->findOrFail($news, ['id', 'user_id', 'title', 'content', 'published_at', 'base64image', 'views', 'likes']);

        $newsOnce->increment('views');

        if ($newsOnce->user_id) {
            $newsOnce->user = User::query()->findOrFail($newsOnce->user_id, ['name']);
        }

        return Inertia::render('news/show', compact('newsOnce'));
    }

    public function edit(Request $request, $news)
    {

        $newsOnce = News::query()->findOrFail($news, ['id', 'user_id', 'title', 'content', 'published_at', 'base64image']);

        $userList = User::all(['id', 'name']);

        return Inertia::render('news/edit', compact(['newsOnce', 'userList']));
    }

    public function update(Request $request, $news)
    {
        $validated = $request->validate(News::getRules());

        News::query()->where('id', $news)->update($validated);

        return Redirect::route('news.show', $news);
    }

    public function delete(Request $request, $news)
    {
        $newsModel = News::findOrFail($news);
        $newsModel->comments()->delete(); // Удаление связанных комментариев
        $newsModel->delete(); // Удаление новости
        return Redirect::route('news');
    }

    public function like($news)
    {
        News::query()->where('id', $news)->increment('likes');

        $updatedLikes = News::query()->where('id', $news)->value('likes');

        return response()->json(['likes' => $updatedLikes]);
    }
}
