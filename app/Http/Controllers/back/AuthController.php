<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth; // Bu satırı ekleyin

class AuthController extends Controller
{
    public function login(){
        return view('back.auth.login'); 
    }
    
    public function loginPost(Request $request){
       // dd($request->all()); // Bu, gönderilen tüm verileri görüntüler
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            toastr()->success('Tekrardan Hoşgeldiniz! '.Auth::user()->name);
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('admin.login')->withErrors('Email. adresi veya şifre hatalı');
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('admin.login');
    }
    
}
