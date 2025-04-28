<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class AdminSubcategoryController extends Controller
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
                'c.fldID',
                'c.fldName as subcategoryName',
                'cs.fldName as categoryName',
                'c.fldDescription',
                'cs.fldID as categoryId',
            )
            ->join('categories as c', 'cs.fldID', '=', 'c.subCategoryId')
            ->where('c.fldIsDeleted', 0)
            ->get();

        return view('admin.subcategories', compact('categories','subcategories'));
    }
    public function create(Request $request)
    {
        try {
            $admin = Auth::guard('admin')->user();
            // insert the data into the database directly using Produt::create()
            $category = Category::create([
                'fldName' => $request->fldName,
                'fldDescription' => $request->fldDescription,
                'subCategoryId' => $request->subCategoryId,
            ]);


            // Audit log creation
            AuditLog::create([
                'fldUserID' => $admin->fldID,
                'fldAction' => 'Create Product',
                'fldDescription' => 'Created product: ' . $request->fldName,
                'created_at' => now(),
            ]);
            // Redirect to the categories page with a success message
            return redirect()->route('admin.subcategories')->with('success', 'Category created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.subcategories')->with('error', 'Failed to create category.');
        }
    }
    public function  edit(Request $request)
    {
        try {
            $id = $request->edit_fldID;
            $subcategories = Category::find($id);
            $admin = Auth::guard('admin')->user();
            $subcategories->update([
                'fldName' => $request->edit_fldName,
                'fldDescription' => $request->edit_fldDescription,
                'subCategoryId' => $request->edit_fldCategoryID,   
            ]);
            if(!$subcategories){
               return redirect()->route('admin.subcategories')->with('error', 'Category not found.');
            }
            $subcategories->save();
            AuditLog::create([
                'fldUserID' => $admin->fldID,
                'fldAction' => 'Edit Product',
                'fldDescription' => 'Edited product: ' . $request->edit_fldName,
                'created_at' => now(),
            ]);
            return redirect()->route('admin.subcategories')->with('success', 'Category updated successfully.');

        } catch (\Exception $e) {
            //throw $th;
            return redirect()->route('admin.subcategories')->with('error', 'Failed to update category.');
        }
    }
    public function delete(Request $request)
    {
        $id = $request->input('delete_fldID');
        // Soft delete the category
        $category = Category::find($id);
        $admin = Auth::guard('admin')->user();
        if ($category) {
            $category->fldIsDeleted = 1;
            $category->save();
            // Audit log creation
            AuditLog::create([
                'fldUserID' => $admin->fldID,
                'fldAction' => 'Deleted Product',
                'fldDescription' => 'Soft Deleted product: ' . $request->delete_fldID,
                'created_at' => now(),
            ]);
            return redirect()->route('admin.subcategories')->with('success', 'Category deleted successfully.');
        } else {
            return redirect()->route('admin.subcategories')->with('error', 'Category not found.');
        }
    }
}
