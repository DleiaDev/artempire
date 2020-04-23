<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $guarded = [];

    protected $casts = [
        'from' => 'integer',
        'to' => 'integer',
        'sent' => 'boolean',
        'read' => 'boolean',
        'received' => 'boolean',
    ];
}
