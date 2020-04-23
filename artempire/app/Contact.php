<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $guarded = [];

    protected $primaryKey = 'user_id';

    public $timestamps = false;
}
