<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'account_id',
        'payment_number',
        'payment_date',
        'amount',
        'method',
        'reference_number',
        'notes',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public static function nextPaymentNumber(): string
    {
        $nextId = (int) static::max('id') + 1;

        return 'PAY-' . str_pad((string) $nextId, 6, '0', STR_PAD_LEFT);
    }

    protected static function booted(): void
    {
        static::saved(function (Payment $payment) {
            $payment->invoice?->recalculateTotals();
        });

        static::deleted(function (Payment $payment) {
            $payment->invoice?->recalculateTotals();
        });
    }
}
