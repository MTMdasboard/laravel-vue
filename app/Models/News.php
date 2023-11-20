<?php

namespace App\Models;

use App\Rules\Base64ImageRule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\File;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'published_at',
        'base64image',
        'views',
        'likes',
    ];

    protected $casts = [
        'published_at' => 'datetime:Y-m-d h:m',
        'views' => 'integer',
        'likes' => 'integer',
    ];

    public static function getRules(): array
    {
        return [
            'user_id' => ['nullable', 'integer', 'exists:users,id'],
            'title' =>['required','string','max:255'],
            'content' =>['nullable', 'string','max:10000'],
            'published_at' =>['nullable', 'string', 'date'],
            'base64image' =>['nullable', new Base64ImageRule()],
        ];
    }
}
