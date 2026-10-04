<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;

class ImageService
{
    /** Stores an uploaded image as a (resized) WebP file on the public disk and returns its relative path. */
    public static function store(UploadedFile $file, string $folder, int $maxWidth = 1600): string
    {
        $name = $folder.'/'.Str::uuid();

        // SVG and GIF are kept as they are.
        if (in_array(strtolower($file->getClientOriginalExtension()), ['svg', 'gif'], true)) {
            return $file->storeAs($folder, Str::uuid().'.'.strtolower($file->getClientOriginalExtension()), 'public');
        }

        try {
            $image = ImageManager::usingDriver(Driver::class)->decodePath($file->getRealPath());
            $image->scaleDown(width: $maxWidth);
            Storage::disk('public')->put($name.'.webp', (string) $image->encode(new WebpEncoder(quality: 82)));

            return $name.'.webp';
        } catch (\Throwable) {
            return $file->store($folder, 'public');
        }
    }

    public static function delete(?string $path): void
    {
        if ($path && ! str_starts_with($path, 'assets/') && ! preg_match('~^(https?:)?//~', $path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
