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
    <label class="form-label">Account</label>
    <select name="account_id" class="form-select">
        <option value="">No Account</option>
        @foreach($accounts as $account)
            <option value="{{ $account->id }}"
                @selected(old('account_id', $opportunity->account_id ?? '') == $account->id)>
                {{ $account->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Opportunity Name</label>
    <input type="text" name="name" class="form-control"
           value="{{ old('name', $opportunity->name ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Amount</label>
    <input type="number" step="0.01" name="amount" class="form-control"
           value="{{ old('amount', $opportunity->amount ?? 0) }}">
</div>

<div class="mb-3">
    <label class="form-label">Stage</label>
    <select name="stage" class="form-select" required>
        @php
            $stages = [
                'Prospecting',
                'Qualification',
                'Needs Analysis',
                'Proposal',
                'Negotiation',
                'Closed Won',
                'Closed Lost'
            ];
        @endphp

        @foreach($stages as $stage)
            <option value="{{ $stage }}"
                @selected(old('stage', $opportunity->stage ?? 'Prospecting') === $stage)>
                {{ $stage }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Probability</label>
    <input type="number" name="probability" min="0" max="100" class="form-control"
           value="{{ old('probability', $opportunity->probability ?? 10) }}">
</div>

<div class="mb-3">
    <label class="form-label">Close Date</label>
    <input type="date" name="close_date" class="form-control"
           value="{{ old('close_date', $opportunity->close_date ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Source</label>
    <input type="text" name="source" class="form-control"
           value="{{ old('source', $opportunity->source ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control" rows="4">{{ old('description', $opportunity->description ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Sales Team</label>
    <select name="sales_team_id" class="form-select">
        <option value="">No Team</option>
        @foreach($salesTeams as $team)
            <option value="{{ $team->id }}"
                @selected(old('sales_team_id', $model->sales_team_id ?? '') == $opportunity->id)>
                {{ $opportunity->name }}
            </option>`
        @endforeach
    </select>
</div>

