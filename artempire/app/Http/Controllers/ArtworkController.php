<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Artwork;
use App\User;
use App\Like;
use App\Comment;
use App\Follower;
use App\Lib\Image;

class ArtworkController extends Controller
{
    // Get artwork
    public function show($id)
    {
        $artwork = Artwork::withCount(['likes', 'comments'])->with(['user'])->find($id);
        $liked = Like::where('user_id', auth()->user()->id)->where('artwork_id', $id)->first() ? true : false;
        return response()->json([
          'artwork' => $artwork,
          'comments' => $artwork->comments()->with(['user'])->orderBy('created_at', 'desc')->get(),
          'liked' => $liked
        ]);
    }

    // New artwork
    public function store(Request $request)
    {
        if (!$request->hasFile('image')) return response('Error', 422);

        $this->validate($request, [
          'image' => 'required|mimes:png,jpeg,jpg,svg|max:2048|dimensions:min_width=1000,min_height=500'
        ]);

        $this->validate($request, [
          'title' => 'required',
          'description' => 'required',
          'tags' => 'required'
        ]);

        $imageLink = Image::upload($request->image, 'artworks');

        $artwork = Artwork::create([
          'user_id' => auth()->user()->id,
          'image' => $imageLink,
          'title' => $request->title,
          'description' => $request->description,
          'tags' => $request->tags
        ]);

        return $artwork;
    }

    // Update artwork
    public function update(Request $request, $id)
    {
        $this->validate($request, [
          'title' => 'required|string',
          'description' => 'required|string',
          'tags' => 'required|string'
        ]);

        $artwork = Artwork::find($id);
        $artwork->update([
          'title' => $request->title,
          'description' => $request->description,
          'tags' => $request->tags
        ]);

        return $artwork;
    }

    // Delete artwork
    public function destroy($id)
    {
        $artwork = Artwork::find($id);
        Image::delete($artwork->image, 'artworks');
        Like::where('artwork_id', $artwork->id)->delete();
        Comment::where('artwork_id', $artwork->id)->delete();
        $artwork->delete();
    }

    // Like
    public function like($id)
    {
        $user = auth()->user();

        $like = Like::where('user_id', $user->id)->where('artwork_id', $id)->first();

        if ($like) {
          $like->delete();
        } else {
          $like = Like::create([
            'user_id' => $user->id,
            'artwork_id' => $id
          ]);
        }

        // Send like notification

        return $like;
    }

    // Get profile likes
    public function getProfileLikes($id)
    {
        $likes = Like::with(['artwork'])->where('user_id', $id)->get()->toArray();
        return array_map(function($like) {
          return $like['artwork'];
        }, $likes);
    }

    // Comment
    public function comment(Request $request, $id)
    {
        $comment = Comment::create([
          'user_id' => auth()->user()->id,
          'artwork_id' => $id,
          'comment' => $request->comment
        ]);

        $comment = Comment::with(['user'])->find($comment->id);

        // Send comment notification

        return $comment;
    }

    // Delete comment
    public function deleteComment($id)
    {
        Comment::findOrFail($id)->delete();
    }

    // Get profile artworks
    public function getProfileArtworks($id)
    {
        return Artwork::where('user_id', $id)->get();
    }
}
