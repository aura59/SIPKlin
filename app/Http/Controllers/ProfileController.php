<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('profile.index', compact('user'));
    }


    public function update(Request $request)
    {
        $user = Auth::user();


        $request->validate([
            'name' => 'required|string|max:255',

            'email' => 'required|email|max:255|unique:users,email,' . $user->id,

            'password' => 'nullable|min:8|confirmed',

            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);


        $user->name = $request->name;

        $user->email = $request->email;


        // Ubah Password
        if ($request->filled('password')) {

            $user->password = Hash::make($request->password);

        }


        // Upload Foto
        if ($request->hasFile('avatar')) {

            $avatar = $request->file('avatar');

            $namaFile = time() . '.' . $avatar->getClientOriginalExtension();


            // Simpan ke public/img/profile
            $avatar->move(
                public_path('img/profile'),
                $namaFile
            );


            $user->avatar = 'img/profile/' . $namaFile;

        }


        $user->save();


        return redirect()
            ->route('admin.profile')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}