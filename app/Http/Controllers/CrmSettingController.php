<?php

namespace App\Http\Controllers;

use App\Models\CrmSetting;
use Illuminate\Http\Request;

class CrmSettingController extends Controller
{
    public function edit()
    {
        $settings = CrmSetting::current();

        return view('crm_settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = CrmSetting::current();

        $validated = $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'company_email' => ['nullable', 'email', 'max:255'],
            'company_phone' => ['nullable', 'string', 'max:255'],
            'company_website' => ['nullable', 'string', 'max:255'],
            'currency' => ['required', 'string', 'max:10'],
            'timezone' => ['required', 'string', 'max:255'],
            'date_format' => ['required', 'string', 'max:255'],
            'company_address' => ['nullable', 'string'],
            'quote_terms' => ['nullable', 'string'],
            'invoice_terms' => ['nullable', 'string'],
            'default_tax_percent' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'enable_email_notifications' => ['nullable', 'boolean'],
            'enable_task_reminders' => ['nullable', 'boolean'],
        ]);

        $settings->update($validated);

        return back()->with('success', 'CRM settings updated successfully.');
    }
}
