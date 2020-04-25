<?php

namespace App\Services;

use App\Profile;

class ConfirmFollow
{
    public function confirm($user_id, $user)
    {
        //ユーザーがフォローしているか確認する
        $follows = $user->following->contains($user_id);
        return $follows;
    }
}
