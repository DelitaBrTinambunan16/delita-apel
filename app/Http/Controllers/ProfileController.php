<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    // Form edit profil
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('profile.edit', compact('user'));
    }

    // Update foto profil
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048'
        ]);

        // Jika upload foto baru
        if ($request->hasFile('profile_picture')) {

            // hapus foto lama
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            // upload foto baru
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }

        $user->save();

        return redirect()
            ->route('profile.edit', $user->id)
            ->with('success', 'Foto profil berhasil diperbarui!');
    }

    // Hapus foto profil
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
        }

        $user->profile_picture = null;
        $user->save();

        return redirect()
            ->route('profile.edit', $user->id)
            ->with('success', 'Foto profil berhasil dihapus!');
    }
}
