<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
        protected $fillable = [
        'bio',
        'image',
        'user_id'
    ];

    use SoftDeletes;
}

