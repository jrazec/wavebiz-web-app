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
        
        $credentials = $request->only('fldUserName', 'fldPassword');
        if (Auth::guard('admin')->attempt($credentials)) {
            
            return redirect()->intended($this->redirectTo);
        } else {
            return redirect()->back()->withErrors(['Invalid credentials']);
        }


       
    }
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }


    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function username()
    {
        return 'fldUserName';
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }

}
