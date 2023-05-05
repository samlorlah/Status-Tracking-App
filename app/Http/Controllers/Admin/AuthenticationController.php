<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class AuthenticationController extends Controller
{
    public function login()
    {
        if(auth('admin')->user())
        {
            return redirect(route('admin.dashboard'));
        }
        return view('admin.auth.login');
    }

    public function loginUser(Request $request) {
        $request->validate([
            'email' => ['required'],
            'password' => ['required', 'min:8'],
        ]);

        $remember = false;

        if($request->remember)
        {
            $remember = true;
        }
        
        $email = $request->email;
        if (auth()->guard('admin')->attempt(['email' => $email, 'password' => $request->password])) {

            $request->session()->regenerate();
            return redirect(route('admin.dashboard'));
        }

        alert()->error('Invalid Username / Password', 'error');
        return back();
    }

    public function logoutUser(Request $request) {
        auth('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Session::flush();

        return redirect(route('admin.login'));
    }
}
