<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PublicImageStorage
{
    public static function store(UploadedFile $file, string $directory): string
    {
        $filename = Str::uuid()->toString().'.'.$file->guessExtension();

        return $file->storeAs($directory, $filename, 'public');
    }

    public static function delete(?string $path): void
    {
        if (blank($path)) {
            return;
        }

        Storage::disk('public')->delete($path);
    }

    public static function url(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        return Storage::disk('public')->url($path);
    }
}
