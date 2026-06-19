<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CrmSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'company_email',
        'company_phone',
        'company_website',
        'currency',
        'timezone',
        'date_format',
        'company_address',
        'quote_terms',
        'invoice_terms',
        'default_tax_percent',
        'enable_email_notifications',
        'enable_task_reminders',
    ];

    protected $casts = [
        'default_tax_percent' => 'decimal:2',
        'enable_email_notifications' => 'boolean',
        'enable_task_reminders' => 'boolean',
    ];

    public static function current(): self
    {
        return self::firstOrCreate([], [
            'company_name' => 'CRM Platform',
            'currency' => 'USD',
            'timezone' => 'America/New_York',
            'date_format' => 'm/d/Y',
        ]);
    }
}
