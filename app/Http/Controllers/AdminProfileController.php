<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminProfileController extends Controller
{
    public function index()
    {
        $admin = Auth::user();
        return view('admin.profil.index', compact('admin'));
    }

    public function update(Request $request)
    {
        $admin = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $admin->id,
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
        ];

        // Ganti password hanya jika diisi
        if ($request->filled('password')) {
            $request->validate([
                'password'              => 'min:6',
                'password_confirmation' => 'required_with:password|same:password',
            ]);
            $data['password'] = Hash::make($request->password);
        }

        User::where('id', $admin->id)->update($data);

        return redirect()->route('admin.profil')->with('success', 'Profil berhasil diperbarui!');
    }
}
