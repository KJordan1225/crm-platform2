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
    <label class="form-label">Team Name</label>
    <input type="text"
           name="name"
           class="form-control"
           value="{{ old('name', $salesTeam->name ?? '') }}"
           required>
</div>

<div class="mb-3">
    <label class="form-label">Manager</label>
    <select name="manager_id" class="form-select">
        <option value="">No Manager</option>
        @foreach($users as $user)
            <option value="{{ $user->id }}"
                @selected(old('manager_id', $salesTeam->manager_id ?? '') == $user->id)>
                {{ $user->name }} — {{ $user->email }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-check mb-3">
    <input type="hidden" name="is_active" value="0">
    <input type="checkbox"
           name="is_active"
           value="1"
           class="form-check-input"
           id="is_active"
           @checked(old('is_active', $salesTeam->is_active ?? true))>

    <label for="is_active" class="form-check-label">
        Active Team
    </label>
</div>

<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description"
              rows="5"
              class="form-control">{{ old('description', $salesTeam->description ?? '') }}</textarea>
</div>
