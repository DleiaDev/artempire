<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Follower;
use App\Social;
use App\Artwork;

class PagesController extends Controller
{
    // App view
    public function app()
    {
        $user = User::with(['social', 'artworks'])->find(auth()->user()->id);
        $userJSON = json_encode($user);
        $userJSON = str_replace('\'', '\\\'', $userJSON);
        return view('app', compact('userJSON'));
    }

    // Profile
    public function profile($username)
    {
        $user = User::with(['social', 'artworks'])
          ->withCount(['artworks', 'followers', 'followings', 'likes'])
          ->find(auth()->user()->id);

        if (auth()->user()->username === $username) {
          $userJSON = json_encode($user);
          $userJSON = str_replace('\'', '\\\'', $userJSON);
          return view('app', compact('userJSON'));
        }

        $profile = User::where('username', $username)
          ->with(['social', 'artworks'])
          ->withCount(['artworks', 'followers', 'followings', 'likes'])
          ->first();

        if (!$profile) return response('Profile not found', 404);

        $user->is_following = Follower::where([
          'user_id' => $profile->id,
          'follower_id' => $user->id
        ])->first() ? true : false;

        $userJSON = json_encode($user);
        $userJSON = str_replace('\'', '\\\'', $userJSON);
        $profileJSON = json_encode($profile);
        $profileJSON = str_replace('\'', '\\\'', $profileJSON);

        return view('app', compact('userJSON', 'profileJSON'));
    }
}
