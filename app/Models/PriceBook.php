<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PriceBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_standard',
        'is_active',
        'description',
    ];

    protected $casts = [
        'is_standard' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function entries()
    {
        return $this->hasMany(PriceBookEntry::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'price_book_entries')
            ->withPivot(['list_price', 'is_active'])
            ->withTimestamps();
    }
}
