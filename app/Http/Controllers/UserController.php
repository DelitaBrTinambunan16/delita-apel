<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // List user
    public function index()
    {
        $datauser = User::paginate(10);
        return view('admin.user.index', compact('datauser'));
    }

    // Form create
    public function create()
    {
        return view('admin.user.create');
    }

    // Store user
    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required',
            'email'            => 'required|email|unique:users,email',
            'password'         => 'required|min:6|confirmed',
            'profile_picture'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except('password');
        $data['password'] = Hash::make($request->password);

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            if ($file->isValid()) {
                $path = $file->store('profile_pictures', 'public');
                $data['profile_picture'] = $path;
            }
        }

        User::create($data);

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan');
    }

    // Form edit
    public function edit(User $user)
    {
        return view('admin.user.edit', compact('user'));
    }

    // Update
    public function update(Request $request, User $user)
    {
        $request->validate([
            'email'            => 'required|email',
            'profile_picture'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except('password');

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            if ($file->isValid()) {
                // Hapus foto lama
                if ($user->profile_picture) {
                    Storage::disk('public')->delete($user->profile_picture);
                }

                $path = $file->store('profile_pictures', 'public');
                $data['profile_picture'] = $path;
            }
        }

        $user->update($data);

        return redirect()->route('user.index')->with('success', 'User berhasil diperbarui');
    }

    // Delete user
    public function destroy(User $user)
    {
        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
        }

        $user->delete();
        return redirect()->route('user.index')->with('success', 'User berhasil dihapus');
    }
}
