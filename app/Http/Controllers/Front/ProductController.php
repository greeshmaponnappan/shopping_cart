<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Interfaces\ProductRepositoryInterface;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $repo;
    public function __construct(ProductRepositoryInterface $repo) { $this->repo = $repo; }

    public function index()
    {
        $products = $this->repo->paginate(12);
        return view('products.index', compact('products'));
    }

    public function show($id)
    {
        $product = $this->repo->find($id);
        if (!$product) abort(404);
        return view('products.show', compact('product'));
    }
}
