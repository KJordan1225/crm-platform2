<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'first_name',
        'last_name',
        'title',
        'email',
        'phone',
        'mobile',
        'department',
        'notes',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
