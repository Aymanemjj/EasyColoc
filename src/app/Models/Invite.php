<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invite extends Model
{
    protected $fillable = [
        'message',
        'token',
        'email',
        'status',
        'user_id',
        'house_id'
    ];

    use SoftDeletes;
}
