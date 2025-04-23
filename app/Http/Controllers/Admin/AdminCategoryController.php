<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\AuditLog;

class AdminCategoryController extends Controller
{

    public function index()
    {
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
                'cs.fldID',
                'c.fldName',
            )
            ->join('categories as c', 'cs.fldID', '=', 'c.subCategoryId')
            ->where('cs.fldIsDeleted', 0)
            ->get();


        return view('admin.categories', compact('categories','subcategories'));
    }

    // Logic for creation new product
    public function create(Request $request)
    {

        try {
            // Validate the request data
            $request->validate([
                'fldName' => 'required|string|max:255',
                'fldDescription' => 'nullable|string|max:1000',
            ]);
            // insert the data into the database directly using Produt::create()
            $category = Category::create([
                'fldName' => $request->fldName,
                'fldDescription' => $request->fldDescription,
            ]);


            // Audit log creation
            AuditLog::create([
                'fldUserID' => 1,
                'fldAction' => 'Create Category',
                'fldDescription' => 'Created category: ' . $request->fldName,
                'created_at' => now(),
            ]);

            // Redirect to the categories page with a success message
            return redirect()->route('admin.categories')->with('success', 'Category created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.categories')->with('error', 'Failed to create category.');
        }

    }


    // Show the form for editing a product
    public function edit(Request $request) {
        // update the product by its id set to the request
        $category = Product::find($request->edit_fldID);
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
                'fldAction' => 'Create Category',
                'fldDescription' => 'Edited category: ' . $request->fldName,
                'updated_at' => now(),
            ]);
        // Redirect to the products page with a success message
        return redirect()->route('admin.products')->with('success', 'Product updated successfully.');
        
    }

    // Logic for deleting a categories
    public function delete(Request $request) {
            // Find the categories by its ID
            $category = Category::find($request->delete_fldID);
            // Check if the categories exists
            if (!$category) {
                return redirect()->route('admin.categories')->with('error', sprintf('Category with ID %s not found.', $request->delete_fldID));
            }
            // Soft delete the categories
            $category->update([
                'fldIsDeleted' => 1,
            ]);

            // Audit log creation
            AuditLog::create([
                'fldUserID' => 1,
                'fldAction' => 'Delete Category',
                'fldDescription' => 'Soft Deleted category: ' . $category->fldID,
            ]);

            // Redirect to the categories page with a success message
            return redirect()->route('admin.categories')->with('success', 'Category deleted successfully.');
    }
}
