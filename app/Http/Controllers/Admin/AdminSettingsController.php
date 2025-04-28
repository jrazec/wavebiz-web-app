<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminSettingsController extends Controller
{ 

    public function settings(Request $request)
    {
        // Check who is the current logged-in user
        $admin = Auth::guard('admin')->user();
        // Return the view with the settings data
        return view('admin.profile', compact('admin'));
    }
    public function changePassword(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        if($admin){
            // Check if the old password matches
            if (!Hash::check($request->old_password, $admin->fldPassword)) {
                return redirect()->route('admin.profile')->with('error','Old password is incorrect.');
            }

            // Update the password
            $admin->fldPassword = Hash::make($request->new_password);
            $admin->save();
        }

    return redirect()->route('admin.profile')->with('success', 'Password changed successfully.')->with('admin', $admin);
    }
}
