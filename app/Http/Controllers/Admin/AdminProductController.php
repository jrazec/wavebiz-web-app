<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Http\Controllers\Controller;

class AdminProductController extends Controller
{
    //
    public function index()
    {
        $products = Product::all();
        $categories = Category::all();

        // Return the view with the products
        return view('admin.products', compact('products', 'categories'));
    }
}
