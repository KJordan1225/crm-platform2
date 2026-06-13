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
    <label class="form-label">Campaign Name</label>
    <input type="text" name="name" class="form-control"
           value="{{ old('name', $campaign->name ?? '') }}" required>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Type</label>
        <select name="type" class="form-select">
            @foreach(['Email', 'Social Media', 'Webinar', 'Trade Show', 'Direct Mail', 'Referral', 'Other'] as $type)
                <option value="{{ $type }}" @selected(old('type', $campaign->type ?? 'Email') === $type)>
                    {{ $type }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            @foreach(['Planning', 'Active', 'Completed', 'Cancelled'] as $status)
                <option value="{{ $status }}" @selected(old('status', $campaign->status ?? 'Planning') === $status)>
                    {{ $status }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Start Date</label>
        <input type="date" name="start_date" class="form-control"
               value="{{ old('start_date', isset($campaign) && $campaign->start_date ? $campaign->start_date->format('Y-m-d') : '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">End Date</label>
        <input type="date" name="end_date" class="form-control"
               value="{{ old('end_date', isset($campaign) && $campaign->end_date ? $campaign->end_date->format('Y-m-d') : '') }}">
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Budgeted Cost</label>
        <input type="number" step="0.01" name="budgeted_cost" class="form-control"
               value="{{ old('budgeted_cost', $campaign->budgeted_cost ?? 0) }}">
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Actual Cost</label>
        <input type="number" step="0.01" name="actual_cost" class="form-control"
               value="{{ old('actual_cost', $campaign->actual_cost ?? 0) }}">
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Expected Revenue</label>
        <input type="number" step="0.01" name="expected_revenue" class="form-control"
               value="{{ old('expected_revenue', $campaign->expected_revenue ?? 0) }}">
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" rows="5" class="form-control">{{ old('description', $campaign->description ?? '') }}</textarea>
</div>
