<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\DocBlock\Tags\Author;

use function PHPUnit\Framework\isEmpty;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'password',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function fullname()
    {
        return $this->firstname . " " . $this->lastname;
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function house(): BelongsToMany
    {
        return $this->belongsToMany(House::class)
            ->withTimestamps()
            ->withPivot(['is_owner', 'deleted_at', 'status']);
    }

    public function notReserved()
    {
        return $this->house->isEmpty();
    }

    public function pfp()
    {
        $pfp = substr($this->firstname, 0, 1) . substr($this->lastname, 0, 1);
        return strtoupper($pfp);
    }

    public function allPayments(): HasMany
    {
        return $this->hasMany(PaymentPending::class);
    }

    public function needToPay($id)
    {
        $toPay = [];

        foreach ($this->allPayments as $payment) {
            if ($payment->expence->house->id == $id && !$payment->status) array_push($toPay, $payment);

        }


        return $toPay;
    }

}
