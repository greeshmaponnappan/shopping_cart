<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToModel; 
use Maatwebsite\Excel\Concerns\WithHeadingRow;
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
    // app/Imports/ProductsImport.php

protected function processImage(?string $imageUrl): ?string
{
    if (empty($imageUrl) || !filter_var($imageUrl, FILTER_VALIDATE_URL)) {
        return null;
    }

    try {
        // 1. Fetch the image content (with robust headers and timeout)
        $response = Http::timeout(10)
                        ->withHeaders([
                            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
                        ])
                        ->get($imageUrl);
        
        if (!$response->successful()) { 
            Log::error("Image Import Failure: HTTP failed. URL: {$imageUrl}. Status: " . $response->status());
            return null;
        }
        
        $imageContents = $response->body();

        $directory = 'products';
        
        // Generate a unique filename and path
        $uniqueFilename =  Str::uuid() . '.webp';

        $diskPath = $directory . '/' . $uniqueFilename;
        
        // 2. **V3 API FIX:** Use read() to load the data 
        //    and toWebp(quality) to encode the output.
        $webpImage = FacadesImage::read($imageContents)
                                 ->toWebp(90);
        
        // Store the WEBP image to the 'public' disk.
        // The V3 object must be converted to a string before storage.
        Storage::disk('public')->put($diskPath, (string) $webpImage); 
        
        return $uniqueFilename;
        
    } catch (\Throwable $e) {
        // ... (error logging)
        Log::error("Image Import Failure for URL: {$imageUrl}. Error: " . $e->getMessage());
        return null;
    }
}
}