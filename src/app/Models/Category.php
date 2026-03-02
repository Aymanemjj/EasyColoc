<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    protected $fillable = [
        'name',
        'description',
        'house_id'
    ];

    use SoftDeletes;

    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class, 'house_id');
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expences::class);
    }

    public function deletable()
    {
        return $this->expenses()->count() == 0;
    }
}
