<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PriceBookEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'price_book_id',
        'product_id',
        'list_price',
        'is_active',
    ];

    protected $casts = [
        'list_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function priceBook()
    {
        return $this->belongsTo(PriceBook::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
