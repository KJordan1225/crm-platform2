@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="fw-bold mb-3">CRM Settings</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('crm-settings.update') }}" method="POST" class="card card-body shadow-sm border-0">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Company Name</label>
                <input type="text" name="company_name" class="form-control"
                       value="{{ old('company_name', $settings->company_name) }}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Company Email</label>
                <input type="email" name="company_email" class="form-control"
                       value="{{ old('company_email', $settings->company_email) }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="company_phone" class="form-control"
                       value="{{ old('company_phone', $settings->company_phone) }}">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Website</label>
                <input type="text" name="company_website" class="form-control"
                       value="{{ old('company_website', $settings->company_website) }}">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Currency</label>
                <input type="text" name="currency" class="form-control"
                       value="{{ old('currency', $settings->currency) }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Company Address</label>
            <textarea name="company_address" rows="3" class="form-control">{{ old('company_address', $settings->company_address) }}</textarea>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Timezone</label>
                <input type="text" name="timezone" class="form-control"
                       value="{{ old('timezone', $settings->timezone) }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Date Format</label>
                <input type="text" name="date_format" class="form-control"
                       value="{{ old('date_format', $settings->date_format) }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Default Tax %</label>
                <input type="number" step="0.01" name="default_tax_percent" class="form-control"
                       value="{{ old('default_tax_percent', $settings->default_tax_percent) }}">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Default Quote Terms</label>
            <textarea name="quote_terms" rows="4" class="form-control">{{ old('quote_terms', $settings->quote_terms) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Default Invoice Terms</label>
            <textarea name="invoice_terms" rows="4" class="form-control">{{ old('invoice_terms', $settings->invoice_terms) }}</textarea>
        </div>

        <div class="form-check mb-3">
            <input type="hidden" name="enable_email_notifications" value="0">
            <input type="checkbox" name="enable_email_notifications" value="1" class="form-check-input"
                   id="enable_email_notifications"
                   @checked(old('enable_email_notifications', $settings->enable_email_notifications))>
            <label for="enable_email_notifications" class="form-check-label">
                Enable Email Notifications
            </label>
        </div>

        <div class="form-check mb-4">
            <input type="hidden" name="enable_task_reminders" value="0">
            <input type="checkbox" name="enable_task_reminders" value="1" class="form-check-input"
                   id="enable_task_reminders"
                   @checked(old('enable_task_reminders', $settings->enable_task_reminders))>
            <label for="enable_task_reminders" class="form-check-label">
                Enable Task Reminders
            </label>
        </div>

        <button class="btn btn-primary">
            Save Settings
        </button>
    </form>
</div>
@endsection
