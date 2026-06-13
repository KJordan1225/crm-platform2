<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sku',
        'category',
        'unit_price',
        'is_active',
        'description',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function priceBookEntries()
    {
        return $this->hasMany(PriceBookEntry::class);
    }

    public function quoteLineItems()
    {
        return $this->hasMany(QuoteLineItem::class);
    }
}
