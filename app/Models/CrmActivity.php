<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CrmActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'activityable_type',
        'activityable_id',
        'type',
        'subject',
        'description',
        'activity_date',
    ];

    protected $casts = [
        'activity_date' => 'datetime',
    ];

    public function activityable()
    {
        return $this->morphTo();
    }
}
