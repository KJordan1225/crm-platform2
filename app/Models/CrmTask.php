<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class CrmTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'taskable_type',
        'taskable_id',
        'title',
        'description',
        'status',
        'priority',
        'due_date',
        'completed_at',
        'user_id',
        'sales_team_id',
    ];

    protected $casts = [
        'due_date' => 'date',
        'completed_at' => 'datetime',
    ];

    public function taskable()
    {
        return $this->morphTo();
    }

    public function markCompleted(): void
    {
        $this->update([
            'status' => 'Completed',
            'completed_at' => now(),
        ]);
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
