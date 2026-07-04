<?php

namespace App\Http\Controllers\Admin\Concerns;

use App\Support\PublicImageStorage;
use Illuminate\Http\Request;

trait HandlesUploadedImages
{
    /**
     * @param  array<string, mixed>  $payload
     * @return array<string, mixed>
     */
    protected function mergeUploadedImage(
        Request $request,
        array $payload,
        string $directory,
        ?string $existingPath = null,
    ): array {
        if (! $request->hasFile('image')) {
            return $payload;
        }

        PublicImageStorage::delete($existingPath);

        $payload['image_path'] = PublicImageStorage::store($request->file('image'), $directory);
        $payload['image_url'] = null;

        return $payload;
    }
}
