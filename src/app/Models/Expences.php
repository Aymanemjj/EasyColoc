<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expences extends Model
{
    protected $fillable = [
        'title',
        'amount',
        'month',
        'user_id',
        'house_id'
    ];

    use SoftDeletes;
}
