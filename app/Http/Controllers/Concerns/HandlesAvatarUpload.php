<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

trait HandlesAvatarUpload
{
    /**
     * Decode a "data:image/...;base64,..." string sent from the client and
     * store it on the public disk, returning the stored path.
     *
     * Both signup and profile editing send photos this way (as a base64
     * text field) instead of a real multipart file upload: a real upload's
     * size is capped by PHP's upload_max_filesize ini setting, and when a
     * photo goes over that limit PHP silently drops the file before Laravel
     * ever sees it — the form would submit "successfully" with no photo and
     * no error. Sending the image as POST body text is only bounded by the
     * much larger post_max_size, so an oversized photo reliably fails
     * validation below instead of vanishing silently.
     */
    protected function storeAvatarFromBase64(string $b64String): string
    {
        if (! preg_match('/^data:(image\/(jpeg|png|gif|webp));base64,(.+)$/i', $b64String, $m)) {
            throw ValidationException::withMessages([
                'avatar' => 'Please upload a valid JPG, PNG, GIF, or WebP image.',
            ]);
        }

        $imageData = base64_decode($m[3]);

        if ($imageData === false || strlen($imageData) > 2 * 1024 * 1024) {
            throw ValidationException::withMessages([
                'avatar' => 'The image must be smaller than 2 MB.',
            ]);
        }

        $ext = match (strtolower($m[2])) {
            'jpeg' => 'jpg',
            'png' => 'png',
            'gif' => 'gif',
            'webp' => 'webp',
            default => 'jpg',
        };

        $path = 'avatars/'.uniqid('avatar_', true).'.'.$ext;

        Storage::disk('public')->put($path, $imageData);

        return $path;
    }
}
