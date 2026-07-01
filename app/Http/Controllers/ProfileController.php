<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesAvatarUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    use HandlesAvatarUpload;

    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'avatar_b64'   => ['nullable', 'string'],
            'remove_avatar' => ['nullable', 'boolean'],
        ], [
            'name.required' => 'Please enter your name.',
        ]);

        $user->name = $request->input('name');

        if ($request->filled('avatar_b64')) {
            $path = $this->storeAvatarFromBase64($request->input('avatar_b64'));

            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $user->avatar = $path;
        } elseif ($request->boolean('remove_avatar') && $user->avatar) {
            Storage::disk('public')->delete($user->avatar);
            $user->avatar = null;
        }

        $user->save();

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Profile updated successfully.');
    }
}
