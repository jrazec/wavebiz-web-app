<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; 


class ProfileController extends Controller
{
    //

    // Show user data
    public function show()
    {
        $user = auth()->user();
        return view('profile', compact('user'));
    }

    public function update(Request $request)
    {
        // Validate the request data
        $request->validate([
            'fldUserName' => 'required|string|max:255',
            'fldEmailAdd' => 'required|string|email|max:255',
            'fldPassword' => 'required|string|min:8|confirmed',
        ]);

        // Update the user's profile
        $user = auth()->user();
        $user->fldUserName = $request->input('fldUserName');
        $user->fldEmailAdd = $request->input('fldEmailAdd');
        $user->fldPassword = bcrypt($request->input('fldPassword'));
        $user->save();

        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    }

}
