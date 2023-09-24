<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.index');
    }

    public function login(Request $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect(route('dashboard'));
        }
        return redirect()->back()->with('message', 'email atau password salah')->withInput();
    }

    public function register()
    {
        return view('auth.register');
    }

    public function store(StoreUserRequest $request)
    {
        DB::transaction(function()use($request){
            User::create($request->input());
        });
        return redirect()->back()->with('message', 'Akun telah berhasil dibuat');
    }
}
