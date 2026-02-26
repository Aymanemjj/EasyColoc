<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentPending extends Model
{
    protected $fillable = [
        'amount',
        'status',
        'payment_date',
        'user_id',
        'expence_id'
    ];

    public function owner(): BelongsTo{
        return $this->belongsTo(User::class, 'user_id');
    }
}
