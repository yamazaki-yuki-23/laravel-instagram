<?php

namespace App\Services;

use App\Profile;

class FollowerGetImage
{
    public function getImagePath($user_id)
    {
        $imagePath = Profile::find($user_id);
        return  $imagePath;
    }
}
