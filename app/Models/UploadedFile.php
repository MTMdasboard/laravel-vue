<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UploadedFile extends Model
{

    protected $fillable = [
        'filename',
        'original_filename',
        'extension',
        'mime_type',
        'size',
        'file_path',
        'is_image',
        'thumb_100x100_path',
    ];
    
    protected $casts = [
        'is_image' => 'boolean',
    ];

    public static function getRules(): array
    {
        return [
            'filename' => 'nullable|string|max:255',
            'file' => ['required', 'file', 'max:8388608' ],
        ];
    }
}
