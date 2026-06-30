<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Lets a logged-in user edit their own name and profile picture.
 */
class ProfileController extends Controller
{
    /** Show the "edit my profile" form. */
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /** Validate and persist the changes, including a new avatar upload. */
    public function update(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:2048'],
            'remove_avatar' => ['nullable', 'boolean'],
        ], [
            'name.required' => 'Please enter your name.',
            'avatar.image' => 'The profile picture must be an image file.',
            'avatar.max' => 'The profile picture may not be larger than 2MB.',
        ]);

        $user->name = $data['name'];

        if ($request->hasFile('avatar')) {
            // Replace the old file (if any) so we don't pile up orphaned uploads.
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $user->avatar = $request->file('avatar')->store('avatars', 'public');
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
