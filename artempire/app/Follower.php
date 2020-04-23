<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    protected $fillable = [
      'user_id', 'follower_id'
    ];

    public function follower()
    {
        return $this->hasOne('App\User', 'id', 'follower_id');
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
