<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;


class AdminSigninController extends Controller
{
    use AuthenticatesUsers;
    protected $redirectTo = '/admin/dashboard';
    public function showSignin(){
        return view('signin');
    }
    public function signin(Request $request)
    {
        $this->validate($request, [
            'fldUserName' => 'required',
            'fldPassword' => 'required',
        ]);
        
        $credentials = [
            'fldUserName' => $request->fldUserName,
            'fldPassword' => $request->fldPassword, 
        ];
   
        $admin = \App\Models\Admin::where('fldUserName', $request->fldUserName)->first();

        if ($admin && $admin->fldPassword === $request->fldPassword)
        {
            Auth::guard('admin')->login($admin);
            return redirect()->intended($this->redirectTo);
        } else {
            return redirect()->back()->withErrors(['Invalid credentials']);
        }
        


       
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/signin');
    }

}
