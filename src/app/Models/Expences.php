<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        return $this->belongsTo(Category::class, 'category_id')->withTrashed();
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class, 'house_id')->withTrashed();
    }

    public function payments(): HasMany
    {
        return $this->hasMany(PaymentPending::class, 'expence_id');
    }
}
