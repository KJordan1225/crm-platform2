<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'industry',
        'website',
        'phone',
        'email',
        'billing_street',
        'billing_city',
        'billing_state',
        'billing_zip',
        'billing_country',
        'description',
    ];

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function opportunities()
    {
        return $this->hasMany(Opportunity::class);
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

    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }
}
