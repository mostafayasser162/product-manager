<?php

namespace App\Rules;

use Illuminate\Support\Arr;

class Rules
{
    // Files
    const MAX_FILE_SIZE = 1024 * 1024 * 10; // 10 MB

    // Images
    const MIMES_IMAGES = 'jpeg,jpg,png,svg';

    const MAX_IMAGE_SIZE = self::MAX_FILE_SIZE;

    public static function get($key, $default = []): array
    {
        $rules = [

            'file' => [
                'image' => ['file', 'mimes:' . self::MIMES_IMAGES, 'max:' . self::MAX_IMAGE_SIZE],
            ],
        ];

        return Arr::get($rules, $key, $default);
    }
}
