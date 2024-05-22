<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('user-setting', compact('users'));
    }
    public function account(Request $request)
    {
        return view('account', [
            'user' => $request->user()
        ]);
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

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'Success']);
    }

    public function resetPassword(User $user)
    {
        $newPassword = Str::random(8);
        // Update the user's password
        $user->password = Hash::make($newPassword);
        $user->save();

        // Return the new password for demonstration purposes
        // In a real application, you might send this password via email
        return response()->json(['message' => 'Password has been reset.', 'newPassword' => $newPassword]);
    }


    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'current_password' => 'nullable|required_with:new_password|string',
            'new_password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('current_password') && $request->filled('new_password')) {
            if (Hash::check($request->current_password, $user->password)) {
                $user->password = Hash::make($request->new_password);
            } else {
                return response()->json(['errors' => ['current_password' => ['Current password is incorrect']]], 422);
            }
        }

        $user->save();

        return response()->json(['message' => 'Akun berhasil diperbarui']);
    }
}
