<div class="mb-3">
    <label class="form-label">Account Name</label>
    <input type="text" name="name" class="form-control"
           value="{{ old('name', $account->name ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Industry</label>
    <input type="text" name="industry" class="form-control"
           value="{{ old('industry', $account->industry ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Website</label>
    <input type="text" name="website" class="form-control"
           value="{{ old('website', $account->website ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Phone</label>
    <input type="text" name="phone" class="form-control"
           value="{{ old('phone', $account->phone ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control"
           value="{{ old('email', $account->email ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control" rows="4">{{ old('description', $account->description ?? '') }}</textarea>
</div>
