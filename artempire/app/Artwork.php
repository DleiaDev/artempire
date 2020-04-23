<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Artwork extends Model
{
    use Searchable;

    protected $guarded = [];

    protected $casts = [
        'user_id' => 'integer',
    ];

    public function getTagsAttribute($value)
    {
        return explode(',', $value);
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function likes()
    {
        return $this->hasMany('App\Like');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
}
