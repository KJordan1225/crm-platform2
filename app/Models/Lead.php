<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'company',
        'first_name',
        'last_name',
        'email',
        'phone',
        'status',
        'source',
        'industry',
        'estimated_value',
        'notes',
    ];

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function tasks()
    {
        return $this->morphMany(CrmTask::class, 'taskable');
    }

    public function notes()
    {
        return $this->morphMany(CrmNote::class, 'noteable');
    }

    public function activities()
    {
        return $this->morphMany(CrmActivity::class, 'activityable');
    }
}
