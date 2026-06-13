<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuoteLineItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'quote_id',
        'product_id',
        'product_name',
        'sku',
        'quantity',
        'unit_price',
        'discount_percent',
        'tax_percent',
        'line_total',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'discount_percent' => 'decimal:2',
        'tax_percent' => 'decimal:2',
        'line_total' => 'decimal:2',
    ];

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function calculateLineTotal(): float
    {
        $base = $this->quantity * $this->unit_price;
        $discount = $base * ($this->discount_percent / 100);
        $tax = ($base - $discount) * ($this->tax_percent / 100);

        return round($base - $discount + $tax, 2);
    }

    protected static function booted(): void
    {
        static::saving(function (QuoteLineItem $lineItem) {
            $lineItem->line_total = $lineItem->calculateLineTotal();
        });

        static::saved(function (QuoteLineItem $lineItem) {
            $lineItem->quote?->recalculateTotals();
        });

        static::deleted(function (QuoteLineItem $lineItem) {
            $lineItem->quote?->recalculateTotals();
        });
    }
}
