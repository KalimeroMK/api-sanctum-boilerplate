<?php

namespace Modules\Core\Traits;

use Illuminate\Support\Str;

trait ImageUpload
{
    /**
     * @param $image
     *
     * @return string
     */
    public function verifyAndStoreImage($image): string
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
