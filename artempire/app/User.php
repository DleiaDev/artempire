<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Scout\Searchable;

use App\Follower;
use App\Artwork;
use App\Social;

class User extends Authenticatable
{
    use Searchable;

    protected $guarded = [];

    protected $casts = [
        'verified' => 'boolean'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at'
    ];

    protected $appends = [
      'is_following' => false,
      'last_artwork' => null
    ];

    public function getAlgoliaRecord()
    {
        return [
            'username' => $this->username,
            'profile' => $this->profile,
            'verified' => $this->verified,
            'description' => $this->description
        ];
    }

    public function searchableAs()
    {
        return 'users';
    }

    public function getIsfollowingAttribute()
    {
        return $this->attributes['is_following'];
    }

    public function contact()
    {
        return $this->hasOne('App\Contact');
    }

    public function social()
    {
        return $this->hasOne('App\Social');
    }

    public function artworks()
    {
        return $this->hasMany('App\Artwork')->orderBy('created_at', 'desc');
    }

    public function likes()
    {
        return $this->hasMany('App\Like');
    }

    public function followers()
    {
        return $this->hasMany('App\Follower', 'user_id');
    }

    public function followings()
    {
        return $this->hasMany('App\Follower', 'follower_id');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
}
