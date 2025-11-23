<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\ProductsImport;
use App\Interfaces\ProductRepositoryInterface;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;


class ProductController extends Controller
{
    protected $products;
    protected $imageService;

    public function __construct(
        ProductRepositoryInterface $products,
        ImageService $imageService
    ) {
        $this->products = $products;
        $this->imageService = $imageService;
    }

    public function index()
    {
        $products = $this->products->all();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png'
        ]);

        $data = $request->only(['name', 'price']);

        if ($request->hasFile('image')) {
            $data['image'] = $this->imageService->uploadAsWebp(
                $request->image,
                'products'
            );
        }

        $this->products->create($data);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {
        $product = $this->products->find($id);
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png'
        ]);

        $data = $request->only(['name', 'price']);

        if ($request->hasFile('image')) {
            $data['image'] = $this->imageService->uploadAsWebp(
                $request->image,
                'products'
            );
        }

        $this->products->update($id, $data);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $this->products->delete($id);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product deleted successfully.');
    }
    /**
     * Shows the import form (optional, you can just return the view).
     */
    public function createImport()
    {//dd("in");
        return view('admin.products.import');
    }
    public function importPage()
{
    return view('admin.products.import');
}

    /**
     * Handles the file upload and initiates the import process.
     */
    public function import(Request $request)
{
    // 1. Validation
    $request->validate([
        'file' => 'required|file|mimes:xlsx,xls,csv|max:10240', // Max 10MB file size
    ], [
        'file.mimes' => 'The file must be an Excel file (.xlsx, .xls) or a CSV.',
    ]);

    try {
        // 2. Import the file using the ProductsImport class
        Excel::import(new ProductsImport, $request->file('file'));

        return redirect()->route('admin.products.index')
                         ->with('success', 'Products imported successfully! Image conversion to WEBP completed.');

    } catch (ValidationException $e) { 
         // Handle validation errors from the import process 
         $failures = $e->failures();

         // The `withErrors` helper accepts an array of MessageBag errors or simple arrays
         // Use Laravel's built-in error handling for easier display
         return redirect()->back()->withErrors($failures)->withInput();

    } catch (\Exception $e) {
        // Handle general errors (file reading, disk failures, image fetching errors, etc.)
        Log::error("Product Import Fatal Error: " . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred during the import process. Please check the logs.');
    }
}
    public function show($id)
    {
        // Optional: You can return product details here
        return abort(404);
    }
}
