<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Validator;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;
use App\Exports\ProductsExport;


class AdminProductController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = Product::where('products.fldIsDeleted', 0)
            ->join('categories', 'products.fldCategoryID', '=', 'categories.fldID')
            ->select('products.*', 'categories.fldName as fldCategoryName', 'products.fldImage', 'categories.fldID as fldCategoryID');
    
        // Check if a category filter is applied
        if ($request->filled('category')) {
            $query->where('products.fldCategoryID', $request->category);
        }
    
        // Now paginate (keep query parameters for pagination links)
        $products = $query->paginate(10)->appends($request->all());
    
        // Fetch deleted products (no filter here)
        $deletedProducts = Product::where('products.fldIsDeleted', 1)
            ->join('categories', 'products.fldCategoryID', '=', 'categories.fldID')
            ->select('products.*', 'categories.fldName as fldCategoryName', 'categories.fldImage', 'categories.fldID as fldCategoryID')
            ->get();
    
        // Fetch categories
        $categories = Category::where('fldIsDeleted', 0)
            ->select('*')
            ->get();
    
        return view('admin.products', compact('products', 'deletedProducts', 'categories'));
    }
    

   // Logic for creation new product
   public function create(Request $request)
   {
   
       // Default image path in case no image is uploaded
       $imagePath = 'images/default.png';
   
       // Handle the image upload
       if ($request->hasFile('fldImage')) {
           // Validate image if needed
           $request->validate([
               'fldImage' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // Validate image type
           ]);
   
           // Generate the image file name with extension
           $imageName = time() . $request->fldImage->getClientOriginalName();
   
           // Store the image in the 'public/images' folder
           $imageSave = Storage::disk('public')->putFileAs('images', $request->fldImage, $imageName);
   
           // Set the image path for storage
           $imagePath = 'images/' . $imageName;  // Relative path to the image
       }
   
       // Insert the product into the database with the image path
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
           'fldImage' => $imagePath,  // Store the relative image path in the database
       ]);
   
       // Audit log creation
       AuditLog::create([
           'fldUserID' => Auth::guard('admin')->user()->fldID,  // Store the user ID from the logged-in admin
           'fldAction' => 'Create Product',
           'fldDescription' => 'Created product: ' . $request->fldName,
           'created_at' => now(),
       ]);
   
       return redirect()->route('admin.products')->with('success', 'Product created successfully.');
   }
   
   

   // Show the form for editing a product
   public function edit(Request $request)
   {
       try {
           // Find the product by its ID
           $product = Product::find($request->edit_fldID);
   
           // Check if the product exists
           if (!$product) {
               return redirect()->route('admin.categories')->with('error', 'Product not found.');
           }
   
           // Default image path if no new image is uploaded
           $imagePath = $product->fldImage;
   
           // Handle the image upload if a new image is provided
           if ($request->hasFile('edit_fldImage')) {
               // Validate the image type and size
               $request->validate([
                   'edit_fldImage' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // Validate image type
               ]);
   
            // Generate the image file name with extension
            $imageName = time() . $request->edit_fldImage->getClientOriginalName();
    
            // Store the image in the 'public/images' folder
            $imageSave = Storage::disk('public')->putFileAs('images', $request->edit_fldImage, $imageName);
    
            // Set the image path for storage
            $imagePath = 'images/' . $imageName;  // Relative path to the image
           }
   
           // Update the product's details, including the image path
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
               'fldImage' => $imagePath,  // Store the updated image path in the database
           ]);
   
           // Get the logged-in admin user
           $admin = Auth::guard('admin')->user();
   
           // Create an audit log for the update action
           AuditLog::create([
               'fldUserID' => $admin->fldID,
               'fldAction' => 'Edit Product',
               'fldDescription' => 'Edited product: ' . $request->edit_fldName,
               'updated_at' => now(),
           ]);
   
           // Redirect to the products page with a success message
           return redirect()->route('admin.products')->with('success', 'Product updated successfully.');
   
       } catch (\Exception $e) {
           // Catch any exceptions and redirect with an error message
           return redirect()->route('admin.products')->with('error', 'Failed to update product.');
       }
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
          $admin = Auth::guard('admin')->user();
            // Audit log creation
            AuditLog::create([
                    'fldUserID' => $admin->fldID,
                    'fldAction' => 'Delete Product',
                    'fldDescription' => 'Soft Deleted product: ' . $product->delete_fldID,
            ]);
          // Redirect to the products page with a success message
          return redirect()->route('admin.products')->with('success', 'Product deleted successfully.');
    }

    public function import(Request $request)
    {
        // Validate that the uploaded file is an Excel/CSV file
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:csv,xlsx,xls|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.products')
                             ->with('error', 'Please upload a valid CSV or XLSX file.');
        }

        try {
            // Import the file using Laravel Excel
            $file = $request->file('file');
            Excel::import(new ProductsImport, $file);
            // After the import is successful
            return redirect()->route('admin.products')->with('success', 'Products imported successfully.');
        } catch (\Exception $e) {
            // Handle any errors during the import process
            return redirect()->route('admin.products')->with('error', 'An error occurred during import: ' . $e->getMessage());
        }
    }
    public function export()
    {
        return Excel::download(new ProductsExport, 'products_export.csv');
    }
}
