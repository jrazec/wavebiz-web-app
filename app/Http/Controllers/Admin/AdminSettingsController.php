<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Http\Controllers\Controller;

class AdminSettingsController extends Controller
{
    //
    public function settings()
    {
        // Fetch settings from the database depending on the username
        $admin = Admin::where('fldUserName', 'admin')
                ->select('*')
                ->get();
        
        // Return the view with the settings data
        return view('admin.profile', compact('admin'));
    }
    public function changePassword(Request $request)
    {
        $admin = Admin::where('fldUserName', 'admin')->first();
        $admin->fldPassword = $request->new_password;
        $admin->save();

       return view('admin.profile', compact('admin'))
            ->with('success', 'Password changed successfully.');
    }
}
