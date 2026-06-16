<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalesTeamMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'sales_team_id',
        'user_id',
        'role',
        'joined_at',
        'is_active',
    ];

    protected $casts = [
        'joined_at' => 'date',
        'is_active' => 'boolean',
    ];

    public function salesTeam()
    {
        return $this->belongsTo(SalesTeam::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
