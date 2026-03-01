<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invite extends Model
{
    protected $fillable = [
        'title',
        'body',
        'token',
        'email',
        'status',
        'user_id',
        'house_id'
    ];

    use SoftDeletes;

    public function sender():BelongsTo{
        return $this->belongsTo(User::class, 'user_id');
    }

    public function link(){
        return "http://127.0.0.1:8000/invite/"  . $this->token . "/response" ;
    }

    public function is_active(){
        return $this->status;
    }

    public function isInvitee(){
        return $this->email == auth()->user()->email;
    }
}
