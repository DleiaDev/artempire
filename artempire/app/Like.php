<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $guarded = [];

    protected $casts = [
      'artwork_id' => 'integer'
    ];

    public $timestamps = false;

    public function artwork()
    {
        return $this->belongsTo('App\Artwork');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
