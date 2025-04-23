<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; 
use App\Models\Category;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Product::where('fldIsDeleted',0)->get();
        $categories = Category::from('categories as cs')
            ->select(
                'cs.*',
                DB::raw('(
                    SELECT COUNT(*) 
                    FROM categories c 
                    WHERE c.subCategoryId = cs.fldID AND c.fldName IS NOT NULL
                ) as SubcategoryCount')
            )
            ->whereNull('cs.subCategoryId')
            ->where('cs.fldIsDeleted', 0)
            ->get();
        // select cs.fldID, c.fldName from categories cs join categories c on cs.fldID = c.subCategoryId;
        $subcategories = Category::from('categories as cs')
            ->select(
                'c.fldID',
                'c.fldName as subcategoryName',
                'cs.fldName as categoryName',
                'c.fldDescription',
            )
            ->join('categories as c', 'cs.fldID', '=', 'c.subCategoryId')
            ->where('c.fldIsDeleted', 0)
            ->get();

        return view('home', compact('products', 'categories', 'subcategories'));
    }
}
