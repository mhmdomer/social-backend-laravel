<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Notifications\FollowedYou;
use App\User;

class FollowersController extends Controller
{
    public function follow(User $user) {
        $currentUser = auth()->user();
        if ($currentUser->follow($user)) {
            $user->notify(new FollowedYou($currentUser));
        }
        return response(['data' => null, 'message' => 'success'], 200);
    }

    public function unFollow(User $user) {
        auth()->user()->unFollow($user);
        return response(['data' => null, 'message' => 'success'], 200);
    }
}
