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
                @selected(old('account_id', $contact->account_id ?? '') == $account->id)>
                {{ $account->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">First Name</label>
        <input type="text" name="first_name" class="form-control"
               value="{{ old('first_name', $contact->first_name ?? '') }}" required>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Last Name</label>
        <input type="text" name="last_name" class="form-control"
               value="{{ old('last_name', $contact->last_name ?? '') }}" required>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Title</label>
    <input type="text" name="title" class="form-control"
           value="{{ old('title', $contact->title ?? '') }}">
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control"
               value="{{ old('email', $contact->email ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Phone</label>
        <input type="text" name="phone" class="form-control"
               value="{{ old('phone', $contact->phone ?? '') }}">
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Mobile</label>
    <input type="text" name="mobile" class="form-control"
           value="{{ old('mobile', $contact->mobile ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Department</label>
    <input type="text" name="department" class="form-control"
           value="{{ old('department', $contact->department ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Notes</label>
    <textarea name="notes" class="form-control" rows="4">{{ old('notes', $contact->notes ?? '') }}</textarea>
</div>
