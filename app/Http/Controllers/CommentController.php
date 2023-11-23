<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    public function store(Request $request, $news)
    {

        // Валидация данных, полученных из запроса
        $validatedData = $request->validate([
            'content' => ['required', 'string'],
        ]);
        
        // Создание комментария для указанной новости
        $comment = new Comment();
        $comment->content = $validatedData['content'];
        $comment->news_id = $news; // Привязка комментария к новости
        $comment->save();
        
        // Возвращение результата (например, перенаправление или JSON-ответ)
        return response()->json(['message' => 'Комментарий успешно создан'], 201);
    }
}
