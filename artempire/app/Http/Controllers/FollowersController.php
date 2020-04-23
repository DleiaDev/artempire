<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Follower;

class FollowersController extends Controller
{
    public function follow($user_id)
    {

        $currentUser = auth()->user();

        // Determine if current user is already following this user
        $followRow = Follower::where(['user_id' => $user_id, 'follower_id' => $currentUser->id])->first();

        // Is following (Unfollow)
        if ($followRow) {
          $followRow->delete();
          if ($currentUser->id == 1) {
            User::find($user_id)->update(['verified' => false]);
          }

          return 'unfollow';

          // Not following (follow)
        } else {
          Follower::create([
            'user_id' => $user_id,
            'follower_id' => $currentUser->id
          ]);
          if ($currentUser->id == 1) {
            User::find($user_id)->update(['verified' => true]);
          }
          return 'follow';
        }
    }

    public function getFollowers($id)
    {
        return Follower::with(['follower'])->where('user_id', $id)->get();
    }

    public function getFollowings($id)
    {
        return Follower::with(['user'])->where('follower_id', $id)->get();
    }
}
