<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expences extends Model
{
    protected $fillable = [
        'title',
        'amount',
        'date',
        'user_id',
        'house_id',
        'category_id',
    ];

    use SoftDeletes;

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function house(): BelongsTo{
        return $this->belongsTo(House::class, 'house_id');
    }
}
