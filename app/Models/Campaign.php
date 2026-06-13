<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'status',
        'start_date',
        'end_date',
        'budgeted_cost',
        'actual_cost',
        'expected_revenue',
        'description',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'budgeted_cost' => 'decimal:2',
        'actual_cost' => 'decimal:2',
        'expected_revenue' => 'decimal:2',
    ];

    public function members()
    {
        return $this->hasMany(CampaignMember::class);
    }

    public function getMemberCountAttribute()
    {
        return $this->members()->count();
    }

    public function getResponseCountAttribute()
    {
        return $this->members()
            ->whereIn('status', ['Responded', 'Interested', 'Converted'])
            ->count();
    }

    public function getConvertedCountAttribute()
    {
        return $this->members()
            ->where('status', 'Converted')
            ->count();
    }

    public function getRoiAttribute()
    {
        if ((float) $this->actual_cost <= 0) {
            return 0;
        }

        return (($this->expected_revenue - $this->actual_cost) / $this->actual_cost) * 100;
    }
}
