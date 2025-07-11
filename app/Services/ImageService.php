<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ImageService
{
    public function deleteProductImage(?string $storedPath): void
    {
        if (! $storedPath) return;

        $path = str_replace('storage/', '', $storedPath);

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
