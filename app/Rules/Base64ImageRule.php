<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class Base64ImageRule implements Rule
{
    public function passes($attribute, $value)
    {
        if (Str::startsWith($value, 'data:image')) {
            $exploded = explode(',', $value, 2);
            $decoded = base64_decode($exploded[1]);
            $file = finfo_open();

            $mime = finfo_buffer($file, $decoded, FILEINFO_MIME_TYPE);

            if ($mime && Str::startsWith($mime, 'image')) {
                $size = strlen($decoded);
                return $size >= 1024 && $size <= 102400; // Минимальный и максимальный размер файла в байтах
            }
        }

        return false;
    }

    public function message()
    {
        return __('validation.base64_image');
    }
}
