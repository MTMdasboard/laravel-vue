<?php

namespace App\Models;

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
        'filename',
        'filepath',
        'likes',
    ];

    protected $casts = [
        'published' => 'boolean',
        'published_at' => 'date',
        'likes' => 'integer',
    ];

    public static function getRules(): array
    {
        return [
            'user_id' => ['nullable', 'integer', 'exists:users,id'],
            'title' =>['required','string','max:255'],
            'content' =>['nullable', 'string','max:10000'],
            'filename' =>['nullable', 'string','max:255'],
            'filepath' =>['nullable', File::image()->min('1kb')->max('50kb')],
            'likes' =>['nullable', 'integer', 'max:2147483647'],
        ];
    }
}
