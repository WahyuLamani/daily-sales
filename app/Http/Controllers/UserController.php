<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('user-setting', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        User::create([
            'name' => ucwords($request->nama),
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('user.setting')->with('success', 'User baru telah di buat');
    }
}
