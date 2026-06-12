@if($errors->any())
    <div class="alert alert-danger">
        <strong>Fix the following errors:</strong>
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="mb-3">
    <label class="form-label">Company</label>
    <input type="text" name="company" class="form-control"
           value="{{ old('company', $lead->company ?? '') }}">
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">First Name</label>
        <input type="text" name="first_name" class="form-control"
               value="{{ old('first_name', $lead->first_name ?? '') }}" required>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Last Name</label>
        <input type="text" name="last_name" class="form-control"
               value="{{ old('last_name', $lead->last_name ?? '') }}" required>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control"
               value="{{ old('email', $lead->email ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Phone</label>
        <input type="text" name="phone" class="form-control"
               value="{{ old('phone', $lead->phone ?? '') }}">
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select" required>
        @php
            $statuses = ['New', 'Working', 'Qualified', 'Unqualified', 'Converted'];
        @endphp

        @foreach($statuses as $status)
            <option value="{{ $status }}"
                @selected(old('status', $lead->status ?? 'New') === $status)>
                {{ $status }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Source</label>
    <select name="source" class="form-select">
        @php
            $sources = ['Website', 'Referral', 'Cold Call', 'Email Campaign', 'Social Media', 'Trade Show', 'Other'];
        @endphp

        <option value="">Select Source</option>
        @foreach($sources as $source)
            <option value="{{ $source }}"
                @selected(old('source', $lead->source ?? '') === $source)>
                {{ $source }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Industry</label>
    <input type="text" name="industry" class="form-control"
           value="{{ old('industry', $lead->industry ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Estimated Value</label>
    <input type="number" step="0.01" name="estimated_value" class="form-control"
           value="{{ old('estimated_value', $lead->estimated_value ?? 0) }}">
</div>

<div class="mb-3">
    <label class="form-label">Notes</label>
    <textarea name="notes" class="form-control" rows="4">{{ old('notes', $lead->notes ?? '') }}</textarea>
</div>
