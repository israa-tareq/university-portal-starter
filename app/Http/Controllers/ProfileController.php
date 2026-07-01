<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
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
            $b64String = $request->input('avatar_b64');

            // Expect: data:image/jpeg;base64,<data>
            if (preg_match('/^data:(image\/(jpeg|png|gif|webp));base64,(.+)$/i', $b64String, $m)) {
                $mimeType  = $m[1];
                $imageData = base64_decode($m[3]);

                if ($imageData !== false && strlen($imageData) <= 2 * 1024 * 1024) {
                    $ext = match (strtolower($m[2])) {
                        'jpeg'      => 'jpg',
                        'png'       => 'png',
                        'gif'       => 'gif',
                        'webp'      => 'webp',
                        default     => 'jpg',
                    };

                    $path = 'avatars/' . uniqid('avatar_', true) . '.' . $ext;

                    if ($user->avatar) {
                        Storage::disk('public')->delete($user->avatar);
                    }

                    Storage::disk('public')->put($path, $imageData);
                    $user->avatar = $path;
                } else {
                    return back()->withErrors(['avatar' => 'The image must be smaller than 2 MB.']);
                }
            } else {
                return back()->withErrors(['avatar' => 'Please upload a valid JPG, PNG, GIF, or WebP image.']);
            }
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
