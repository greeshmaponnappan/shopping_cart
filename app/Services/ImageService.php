<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class ImageService
{
    /**
     * Download an image from URL, convert to WEBP, and store it.
     *
     * @param string $imageUrl
     * @param string $folder
     * @return string|null
     */
    public function downloadAndConvertWebp(string $imageUrl, string $folder = 'products'): ?string
    {
        try {
            // Fetch image content from URL
            $imageContent = file_get_contents($imageUrl);
            if (!$imageContent) {
                return null;
            }

            // Create Intervention Image object
            $image = Image::read($imageContent)->toWebp(80);

            // Create filename
            $filename = uniqid('img_') . '.webp';
            $path = "public/{$folder}/{$filename}";

            // Save to storage
            Storage::put($path, (string) $image->encode());

            // Return public path
            return Storage::url($path);

        } catch (\Exception $e) {
            return null;
        }
    }


    /**
     * Convert a local uploaded file (PNG/JPG) to WEBP and store it.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $folder
     * @return string|null
     */
    public function convertUploadedToWebp($file, string $folder = 'products'): ?string
    {
        try {
            $image = Image::read($file)->toWebp(80);

            // Generate filename
            $filename = uniqid('img_') . '.webp';
            $path = "public/{$folder}/{$filename}";

            Storage::put($path, (string) $image->encode());

            return Storage::url($path);

        } catch (\Exception $e) {
            return null;
        }
    }

    public function uploadAsWebp($image, $path)
    {
        $fileName = time() . '.webp';

        $img = Image::read($image->getRealPath())->toWebp(80);

        Storage::disk('public')->put($path . '/' . $fileName, (string) $img);

        return $fileName;
    }
    
}
