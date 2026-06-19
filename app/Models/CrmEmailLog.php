<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CrmEmailLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'emailable_type',
        'emailable_id',
        'user_id',
        'to_email',
        'to_name',
        'subject',
        'body',
        'status',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function emailable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
