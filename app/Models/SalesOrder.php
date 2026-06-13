<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalesOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'quote_id',
        'opportunity_id',
        'account_id',
        'contact_id',
        'order_number',
        'status',
        'order_date',
        'subtotal',
        'discount_total',
        'tax_total',
        'grand_total',
        'notes',
    ];

    protected $casts = [
        'order_date' => 'date',
        'subtotal' => 'decimal:2',
        'discount_total' => 'decimal:2',
        'tax_total' => 'decimal:2',
        'grand_total' => 'decimal:2',
    ];

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

    public function opportunity()
    {
        return $this->belongsTo(Opportunity::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function lineItems()
    {
        return $this->hasMany(SalesOrderLineItem::class);
    }

    public static function nextOrderNumber(): string
    {
        $nextId = (int) static::max('id') + 1;

        return 'SO-' . str_pad((string) $nextId, 6, '0', STR_PAD_LEFT);
    }

    public function recalculateTotals(): void
    {
        $this->loadMissing('lineItems');

        $subtotal = $this->lineItems->sum(fn ($line) => $line->quantity * $line->unit_price);

        $discountTotal = $this->lineItems->sum(function ($line) {
            $base = $line->quantity * $line->unit_price;
            return $base * ($line->discount_percent / 100);
        });

        $taxTotal = $this->lineItems->sum(function ($line) {
            $base = $line->quantity * $line->unit_price;
            $discount = $base * ($line->discount_percent / 100);
            return ($base - $discount) * ($line->tax_percent / 100);
        });

        $this->update([
            'subtotal' => $subtotal,
            'discount_total' => $discountTotal,
            'tax_total' => $taxTotal,
            'grand_total' => $subtotal - $discountTotal + $taxTotal,
        ]);
    }
}
