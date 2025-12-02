<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;

class BuyerController extends Controller
{
    public function index()
    {
        // Ambil semua produk
        $products = Product::orderBy('created_at', 'desc')->paginate(20);

        // Ambil semua kategori
        $categories = ProductCategory::all();

         $featuredProducts = Product::where('price', 1)->take(10)->get();

        return view('buyer', [
            'products' => $products,
            'featuredProducts' => $featuredProducts,
            'categories' => $categories
        ]);
    }
}
