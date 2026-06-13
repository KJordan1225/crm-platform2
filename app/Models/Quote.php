<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quote extends Model
{
    use HasFactory;

    protected $fillable = [
        'opportunity_id',
        'account_id',
        'contact_id',
        'price_book_id',
        'quote_number',
        'name',
        'status',
        'expiration_date',
        'subtotal',
        'discount_total',
        'tax_total',
        'grand_total',
        'terms',
        'notes',
    ];

    protected $casts = [
        'expiration_date' => 'date',
        'subtotal' => 'decimal:2',
        'discount_total' => 'decimal:2',
        'tax_total' => 'decimal:2',
        'grand_total' => 'decimal:2',
    ];

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

    public function priceBook()
    {
        return $this->belongsTo(PriceBook::class);
    }

    public function lineItems()
    {
        return $this->hasMany(QuoteLineItem::class);
    }

    public function recalculateTotals(): void
    {
        $this->loadMissing('lineItems');

        $subtotal = $this->lineItems->sum(function ($line) {
            return $line->quantity * $line->unit_price;
        });

        $discountTotal = $this->lineItems->sum(function ($line) {
            $base = $line->quantity * $line->unit_price;
            return $base * ($line->discount_percent / 100);
        });

        $taxTotal = $this->lineItems->sum(function ($line) {
            $base = $line->quantity * $line->unit_price;
            $discount = $base * ($line->discount_percent / 100);
            return ($base - $discount) * ($line->tax_percent / 100);
        });

        $grandTotal = $subtotal - $discountTotal + $taxTotal;

        $this->update([
            'subtotal' => $subtotal,
            'discount_total' => $discountTotal,
            'tax_total' => $taxTotal,
            'grand_total' => $grandTotal,
        ]);
    }

    public static function nextQuoteNumber(): string
    {
        $nextId = (int) static::max('id') + 1;

        return 'Q-' . str_pad((string) $nextId, 6, '0', STR_PAD_LEFT);
    }
}
