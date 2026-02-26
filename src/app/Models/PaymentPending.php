<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentPending extends Model
{
    protected $fillable = [
        'amount',
        'status',
        'payment_date',
        'user_id',
        'expence_id'
    ];
    use SoftDeletes;

    public function owner(): BelongsTo{
        return $this->belongsTo(User::class, 'user_id');
    }

    public function expence():BelongsTo{
        
        return $this->belongsTo(Expences::class,'expence_id');
    }
}
