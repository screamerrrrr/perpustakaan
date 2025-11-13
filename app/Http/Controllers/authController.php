<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;

class authController extends Controller
{
    public function showLoginForm(){
        return view("auth.login");
    }
    public function loginProcess(Request $request){
     $credentials = $request->only('email', 'password');
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        $user = Auth::user();
        if ($user->role=='admin') {
                        return redirect()->route('admin.dashboard');

        }else{
                        return redirect()->route('peminjam.dashboard');

        }
    }
      return back()->withErrors([
        'email' => 'Email atau password salah.',
    ])->onlyInput('email');
}
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerate();
        return redirect('/');
    }
}
