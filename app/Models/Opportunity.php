<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Opportunity extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'name',
        'amount',
        'stage',
        'probability',
        'close_date',
        'source',
        'description',
        'user_id',
        'sales_team_id',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
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

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function salesTeam()
    {
        return $this->belongsTo(SalesTeam::class);
    }
}
