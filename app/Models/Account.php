<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

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
        'user_id',
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

    public function salesOrders()
    {
        return $this->hasMany(SalesOrder::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
