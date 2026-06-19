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
    <label class="form-label">Template Name</label>
    <input type="text"
           name="name"
           class="form-control"
           value="{{ old('name', $emailTemplate->name ?? '') }}"
           required>
</div>

<div class="mb-3">
    <label class="form-label">Subject</label>
    <input type="text"
           name="subject"
           class="form-control"
           value="{{ old('subject', $emailTemplate->subject ?? '') }}"
           required>
</div>

<div class="mb-3">
    <label class="form-label">Category</label>
    <input type="text"
           name="category"
           class="form-control"
           value="{{ old('category', $emailTemplate->category ?? '') }}">
</div>

<div class="form-check mb-3">
    <input type="hidden" name="is_active" value="0">
    <input type="checkbox"
           name="is_active"
           value="1"
           class="form-check-input"
           id="is_active"
           @checked(old('is_active', $emailTemplate->is_active ?? true))>

    <label for="is_active" class="form-check-label">
        Active Template
    </label>
</div>

<div class="mb-3">
    <label class="form-label">Body</label>
    <textarea name="body"
              rows="12"
              class="form-control"
              required>{{ old('body', $emailTemplate->body ?? '') }}</textarea>
</div>
