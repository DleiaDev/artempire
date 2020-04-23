<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Artwork;
use App\Follower;

class HomeController extends Controller
{
    public function latest()
    {
        return Artwork::orderBy('created_at', 'desc')->get();
    }

    public function following()
    {
        $followerRows = Follower::with('user.artworks')->where('follower_id', auth()->user()->id)->get();
        $artworks = [];
        foreach ($followerRows as $followerRow) {
          $artworksTemp = $followerRow->user->artworks;
          if (count($artworksTemp)) {
            foreach ($artworksTemp as $artwork) {
              $artworks[] = $artwork;
            }
          }
        }

        return collect($artworks);
    }
}
