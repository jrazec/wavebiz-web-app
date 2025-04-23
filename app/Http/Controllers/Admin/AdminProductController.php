<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Models\AuditLog;

class AdminProductController extends Controller
{
    //
    public function index()
    {
        // Fetch all products from the database that is joined with categories
        $products = Product::where('products.fldIsDeleted', 0)
           ->join('categories', 'products.fldCategoryID', '=', 'categories.fldID')
           ->select('products.*', 'categories.fldName as fldCategoryName','categories.fldImage','categories.fldID as fldCategoryID')
           ->get();
       $deletedProducts = Product::where('products.fldIsDeleted', 1)
           ->join('categories', 'products.fldCategoryID', '=', 'categories.fldID')
           ->select('products.*', 'categories.fldName as fldCategoryName','categories.fldImage','categories.fldID as fldCategoryID')
           ->get();
       $categories = Category::where('fldIsDeleted', 0)
           ->select('*')
           ->get();
       return view('admin.products', compact('products', 'deletedProducts', 'categories'));
    }

   // Logic for creation new product
   public function create(Request $request)
   {

        // insert the data into the database directly using Produt::create()
        $product = Product::create([
            'fldName' => $request->fldName,
            'fldDescription' => $request->fldDescription,
            'fldShortDescription' => $request->fldShortDescription,
            'fldPrice' => $request->fldPrice,
            'fldCategoryID' => $request->fldCategoryID,
            'fldBrand' => $request->fldBrand,
            'fldFDARegistration' => $request->fldFDARegistration,
            'fldExpiryDate' => $request->fldExpiryDate,
            'fldMaterial' => $request->fldMaterial,
            'fldWeight' => $request->fldWeight,
            'fldWidth' => $request->fldWidth,
            'fldLength' => $request->fldLength,
            'fldHeight' => $request->fldHeight,
            'fldDimension' => $request->fldDimension,
            'fldUnit' => $request->fldUnit,
            'fldWarranty' => $request->fldWarranty,
            'fldWarrantyPolicy' => $request->fldWarrantyPolicy,
            'fldCondition' => $request->fldCondition,
            'fldSpecialPrice' => $request->fldSpecialPrice,
            'fldVariation1' => $request->fldVariation1,
            'fldVariation2' => $request->fldVariation2,
            'fldIsBattery' => $request->fldIsBattery,
            'fldIsFlammable' => $request->fldIsFlammable,
            'fldIsLiquid' => $request->fldIsLiquid,
            'fldIsPublished' => $request->fldIsPublished,
            'fldIsCompanyOwned' => $request->fldIsCompanyOwned,
            'fldIsSoldOut' => $request->fldIsSoldOut,
            'fldIsVisible' => $request->fldIsVisible,
        ]);
        // Redirect to the products page with a success message

        // Audit log creation
        AuditLog::create([
            'fldUserID' => 1,
            'fldAction' => 'Create Product',
            'fldDescription' => 'Created product: ' . $request->fldName,
            'created_at' => now(),
        ]);
        return redirect()->route('admin.products')->with('success', 'Product created successfully.');


   }


   // Show the form for editing a product
   public function edit(Request $request) {
        // update the product by its id set to the request
        $product = Product::find($request->edit_fldID);
        // Check if the product exists
        if (!$product) {
            return redirect()->route('admin.products')->with('error', 'Product not found.');
        }

        $product->update([
            'fldName' => $request->edit_fldName,
            'fldDescription' => $request->edit_fldDescription,
            'fldShortDescription' => $request->edit_fldShortDescription,
            'fldPrice' => $request->edit_fldPrice,
            'fldCategoryID' => $request->edit_fldCategoryID,
            'fldBrand' => $request->edit_fldBrand,
            'fldFDARegistration' => $request->edit_fldFDARegistration,
            'fldExpiryDate' => $request->edit_fldExpiryDate,
            'fldMaterial' => $request->edit_fldMaterial,
            'fldWeight' => $request->edit_fldWeight,
            'fldWidth' => $request->edit_fldWidth,
            'fldLength' => $request->edit_fldLength,
            'fldHeight' => $request->edit_fldHeight,
            'fldDimension' => $request->edit_fldDimension,
            'fldUnit' => $request->edit_fldUnit,
            'fldWarranty' => $request->edit_fldWarranty,
            'fldWarrantyPolicy' => $request->edit_fldWarrantyPolicy,
            'fldCondition' => $request->edit_fldCondition,
            'fldSpecialPrice' => $request->edit_fldSpecialPrice,
            'fldVariation1' => $request->edit_fldVariation1,
            'fldVariation2' => $request->edit_fldVariation2,
            'fldIsBattery' => $request->edit_fldIsBattery,
            'fldIsFlammable' => $request->edit_fldIsFlammable,
            'fldIsLiquid' => $request->edit_fldIsLiquid,
            'fldIsPublished' => $request->edit_fldIsPublished,
            'fldIsCompanyOwned' => $request->edit_fldIsCompanyOwned,
            'fldIsSoldOut' => $request->edit_fldIsSoldOut,
            'fldIsVisible' => $request->edit_fldIsVisible,
        ]);

        // Audit log creation
        AuditLog::create([
            'fldUserID' => 1,
            'fldAction' => 'Update Product',
            'fldDescription' => 'Updated product: ' . $request->edit_fldName,
            'updated_at' => now(),
        ]);
        // Redirect to the products page with a success message
        return redirect()->route('admin.products')->with('success', 'Product updated successfully.');
        
   }

   // Logic for deleting a product
    public function delete(Request $request) {
          // Find the product by its ID
          $product = Product::find($request->delete_fldID);
          // Check if the product exists
          if (!$product) {
                return redirect()->route('admin.products')->with('error', 'Product not found.');
          }
          // Soft delete the product
          $product->update([
                'fldIsDeleted' => 1,
          ]);

            // Audit log creation
            AuditLog::create([
                    'fldUserID' => 1,
                    'fldAction' => 'Delete Product',
                    'fldDescription' => 'Soft Deleted product: ' . $product->delete_fldID,
            ]);
          // Redirect to the products page with a success message
          return redirect()->route('admin.products')->with('success', 'Product deleted successfully.');
    }
}
