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
    <label class="form-label">Task Title</label>
    <input type="text" name="title" class="form-control"
           value="{{ old('title', $crmTask->title ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" rows="4" class="form-control">{{ old('description', $crmTask->description ?? '') }}</textarea>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            @foreach(['Open', 'In Progress', 'Completed', 'Deferred'] as $status)
                <option value="{{ $status }}"
                    @selected(old('status', $crmTask->status ?? 'Open') === $status)>
                    {{ $status }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Priority</label>
        <select name="priority" class="form-select">
            @foreach(['Low', 'Normal', 'High', 'Urgent'] as $priority)
                <option value="{{ $priority }}"
                    @selected(old('priority', $crmTask->priority ?? 'Normal') === $priority)>
                    {{ $priority }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Due Date</label>
        <input type="date" name="due_date" class="form-control"
               value="{{ old('due_date', isset($crmTask) && $crmTask->due_date ? $crmTask->due_date->format('Y-m-d') : '') }}">
    </div>
</div>

<input type="hidden" name="taskable_type" value="{{ old('taskable_type', $crmTask->taskable_type ?? '') }}">
<input type="hidden" name="taskable_id" value="{{ old('taskable_id', $crmTask->taskable_id ?? '') }}">

<div class="mb-3">
    <label class="form-label">Sales Team</label>
    <select name="sales_team_id" class="form-select">
        <option value="">No Team</option>
        @foreach($salesTeams as $team)
            <option value="{{ $team->id }}"
                @selected(old('sales_team_id', $model->sales_team_id ?? '') == $crmTask->id)>
                {{ $crmTask->name }}
            </option>
        @endforeach
    </select>
</div>

