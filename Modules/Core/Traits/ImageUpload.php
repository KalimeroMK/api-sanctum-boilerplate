<?php

namespace Modules\Core\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

trait ImageUpload
{
    /**
     * Verify and store the uploaded image.
     *
     * @param UploadedFile $image
     * @return string
     */
    public function verifyAndStoreImage(UploadedFile $image): string
    {
        $imageName = Str::random(15) . '.' . $image->getClientOriginalExtension();
        $image->storeAs(
            'uploads/images',
            $imageName,
            'public'
        );

        return $imageName;
    }
}
