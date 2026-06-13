<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CampaignMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'memberable_type',
        'memberable_id',
        'status',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function memberable()
    {
        return $this->morphTo();
    }
}
