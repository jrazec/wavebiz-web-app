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
        $admin = Admin::where('fldUserName', 'admin');
        
        // Return the view with the settings data
        return view('admin.settings', compact('admin'));
    }
}
