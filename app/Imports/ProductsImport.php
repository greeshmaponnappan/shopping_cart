<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToModel; 
use Maatwebsite\Excel\Concerns\WithHeadingRow;
//use Intervention\Image\Facades\Image;
use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Laravel\Facades\Image as FacadesImage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProductsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return Model|null
    */
    public function model(array $row)
    {
        // 1. Fetch and Process Image
        $imagePath = $this->processImage($row['image_url'] ?? null);

        // 2. Return the Product Model instance
        return new Product([
            'name' => $row['name'],
            'price' => $row['price'], 
            'image' => $imagePath,
            // ... map other columns here
        ]);
    }

    /**
     * Helper function to fetch, convert, and store the image.
     *
     * @param string|null $imageUrl
     * @return string|null The path to the stored WEBP image.
     */
    protected function processImage(?string $imageUrl): ?string
    {
        if (empty($imageUrl) || !filter_var($imageUrl, FILTER_VALIDATE_URL)) {
            return null;
        }

        try {
            // Use Laravel's HTTP client to fetch the image content
            $response = Http::get($imageUrl);
            
            if (!$response->successful()) {  
                throw new \Exception("Failed to fetch image from URL.");
            }
            
            $imageContents = $response->body();
            
            // Generate a unique filename and path
            $filename = 'products/' . Str::uuid() . '.webp';
            
            // **IMAGE CONVERSION (PNG/JPG to WEBP)**
            $webpImage = FacadesImage::make($imageContents)->encode('webp', 90);
            
            // Store the WEBP image to the 'public' disk
            Storage::disk('public')->put($filename, (string) $webpImage); 
            
            return $filename;
            
        } catch (\Exception $e) {
            Log::error("Image Import Failure for URL: {$imageUrl}. Error: " . $e->getMessage());
            return null;
        }
    }
}