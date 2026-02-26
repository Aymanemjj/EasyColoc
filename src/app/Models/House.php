<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class House extends Model
{
    protected $fillable = [
        'title',
        'image',
        'description',
        'status'
    ];

    use HasFactory;
    use SoftDeletes;

    public function user(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withTimestamps()
            ->withPivot(['is_owner', 'deleted_at', 'banned']);
    }

    public function owner()
    {
        return $this->belongsToMany(User::class)
            ->withTimestamps()
            ->withPivot(['is_owner'])
            ->wherePivot('is_owner', 1);
    }
    public function authIsOwner()
    {
        return $this->owner[0]->id == Auth::user()->id;
    }

    public function userIsOwner($user)
    {
        return $this->owner[0]->id == $user->id;
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }
}
