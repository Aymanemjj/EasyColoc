<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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
            ->withPivot(['is_owner']);
    }

    public function owner()
    {
        return $this->belongsToMany(User::class)
            ->withTimestamps()
            ->withPivot(['is_owner'])
            ->wherePivot('is_owner', 1);
    }
}
