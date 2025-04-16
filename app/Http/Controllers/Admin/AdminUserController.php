<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Admin;


class AdminUserController extends Controller
{
    //
    public function index()
    {
        // Fetch users from the database
        $users = User::all();
        // Fetch admin settings from the database
        $admin = Admin::all();

        // Return the view with the user data
        return view('admin.memberlist', compact('users', 'admin'));
    }
}
